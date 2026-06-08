<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessengerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->get();
        $groups = Group::whereHas('users', function ($q) {
            $q->where('user_id', Auth::id());
        })->with(['users'])->get();

        foreach ($groups as $group) {
            $group->member_count = $group->users()->count();
            $lastMessage = GroupMessage::where('group_id', $group->id)->orderBy('created_at', 'desc')->first();
            $group->last_message = $lastMessage ? ($lastMessage->message ? substr($lastMessage->message, 0, 50) : '📎 File shared') : 'No messages yet';
        }

        $allUsers = User::where('id', '!=', Auth::id())->get();

        $conversations = Conversation::where('user_one', Auth::id())
            ->orWhere('user_two', Auth::id())
            ->with(['userOne', 'userTwo'])
            ->latest('updated_at')
            ->get();

        foreach ($conversations as $conversation) {
            $otherUser = $conversation->user_one == Auth::id() ? $conversation->userTwo : $conversation->userOne;
            $conversation->other_user_id = $otherUser->id;
            $conversation->other_user_name = $otherUser->name;
            $conversation->other_user_avatar = strtoupper(substr($otherUser->name, 0, 1));
            $lastMessage = Message::where('conversation_id', $conversation->id)->latest()->first();
            $conversation->last_message = $lastMessage ? $lastMessage->message : 'No messages yet';
            $conversation->last_message_time = $lastMessage ? $lastMessage->created_at->diffForHumans() : '';
            $conversation->unread_count = Message::where('conversation_id', $conversation->id)
                ->where('receiver_id', Auth::id())->where('is_read', false)->count();
        }

        $totalUnread = Message::where('receiver_id', Auth::id())->where('is_read', false)->count();

        return view('user.messenger', compact('users', 'groups', 'allUsers', 'conversations', 'totalUnread'));
    }

    public function getMessages($userId)
    {
        if (!$userId || $userId == 'undefined') {
            return response()->json(['success' => false, 'message' => 'Invalid user ID'], 400);
        }

        $user = User::find($userId);
        if (!$user)
            return response()->json(['success' => false, 'message' => 'User not found'], 404);

        $conversation = Conversation::where(function ($q) use ($userId) {
            $q->where('user_one', Auth::id())->where('user_two', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('user_one', $userId)->where('user_two', Auth::id());
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create(['user_one' => Auth::id(), 'user_two' => $userId, 'last_message_time' => now()]);
        }

        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', Auth::id())->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $messages = Message::where('conversation_id', $conversation->id)
            ->with(['sender', 'receiver'])->orderBy('created_at', 'asc')->get();

        return response()->json(['success' => true, 'conversation_id' => $conversation->id, 'messages' => $messages, 'user' => $user]);
    }

    public function getUserStatus($userId)
    {
        $user = User::find($userId);
        if (!$user)
            return response()->json(['success' => false]);
        return response()->json([
            'success' => true,
            'is_online' => $user->isOnline(),
            'last_seen_ago' => $user->last_seen ? $user->last_seen->diffForHumans() : 'Never'
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:2048'
        ]);

        if (empty($request->message) && !$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'Please enter a message or select a file'], 422);
        }

        $receiverId = $request->receiver_id;
        DB::beginTransaction();

        try {
            $conversation = Conversation::where(function ($q) use ($receiverId) {
                $q->where('user_one', Auth::id())->where('user_two', $receiverId);
            })->orWhere(function ($q) use ($receiverId) {
                $q->where('user_one', $receiverId)->where('user_two', Auth::id());
            })->first();

            if (!$conversation) {
                $conversation = Conversation::create(['user_one' => Auth::id(), 'user_two' => $receiverId, 'last_message_time' => now()]);
            }

            $messageData = [
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
                'message' => $request->message,
                'is_read' => false
            ];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $filePath = $file->storeAs('chat-files', $fileName, 'public');
                $messageData['file_path'] = $filePath;
                $messageData['file_name'] = $file->getClientOriginalName();
                $messageData['file_type'] = $file->getMimeType();
                $messageData['file_size'] = $this->formatFileSize($file->getSize());
            }

            $message = Message::create($messageData);
            $conversation->update([
                'last_message' => $request->message ?: ($request->hasFile('file') ? '📎 File shared' : ''),
                'last_message_time' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            $message->load(['sender', 'receiver']);
            return response()->json(['success' => true, 'message' => $message, 'conversation_id' => $conversation->id]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function markAsRead($conversationId)
    {
        Message::where('conversation_id', $conversationId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // ============ DELETE & EDIT MESSAGES (with file deletion) ============
    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        if ($message->sender_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        // Delete attached file from storage
        if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
            Storage::disk('public')->delete($message->file_path);
        }
        $message->update(['is_deleted' => true]);
        return response()->json(['success' => true]);
    }

    public function editMessage(Request $request, $messageId)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $message = Message::findOrFail($messageId);
        if ($message->sender_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $message->update(['edited_message' => $request->message, 'edited_at' => now()]);
        return response()->json(['success' => true, 'edited_message' => $request->message]);
    }

    public function deleteGroupMessage($messageId)
    {
        $message = GroupMessage::findOrFail($messageId);
        if ($message->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        // Delete attached file from storage
        if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
            Storage::disk('public')->delete($message->file_path);
        }
        $message->update(['is_deleted' => true]);
        return response()->json(['success' => true]);
    }

    public function editGroupMessage(Request $request, $messageId)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $message = GroupMessage::findOrFail($messageId);
        if ($message->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $message->update(['edited_message' => $request->message, 'edited_at' => now()]);
        return response()->json(['success' => true, 'edited_message' => $request->message]);
    }

    // ============ GROUP MESSAGES ============
    public function getGroupMessages($groupId)
    {
        try {
            $group = Group::findOrFail($groupId);
            if (!$group->users()->where('user_id', Auth::id())->exists()) {
                return response()->json(['success' => false, 'message' => 'You are not a member'], 403);
            }
            $messages = GroupMessage::where('group_id', $groupId)->with('user')->orderBy('created_at', 'asc')->get();
            return response()->json(['success' => true, 'messages' => $messages, 'group' => $group]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Group not found'], 404);
        }
    }

    public function sendGroupMessage(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:2048'
        ]);

        if (empty($request->message) && !$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'Please enter a message or select a file'], 422);
        }

        DB::beginTransaction();
        try {
            $group = Group::findOrFail($request->group_id);
            if (!$group->users()->where('user_id', Auth::id())->exists()) {
                return response()->json(['success' => false, 'message' => 'You are not a member'], 403);
            }

            $messageData = [
                'group_id' => $request->group_id,
                'user_id' => Auth::id(),
                'message' => $request->message,
                'is_read' => false
            ];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $filePath = $file->storeAs('group-chat-files', $fileName, 'public');
                $messageData['file_path'] = $filePath;
                $messageData['file_name'] = $file->getClientOriginalName();
                $messageData['file_type'] = $file->getMimeType();
                $messageData['file_size'] = $this->formatFileSize($file->getSize());
            }

            $message = GroupMessage::create($messageData);
            $message->load('user');
            DB::commit();
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'required|array|min:1'
        ]);

        DB::beginTransaction();
        try {
            $group = Group::create(['name' => $request->name, 'description' => $request->description, 'created_by' => Auth::id()]);
            $group->users()->attach(Auth::id(), ['role' => 'admin']);
            foreach ($request->members as $memberId) {
                $group->users()->attach($memberId, ['role' => 'member']);
            }
            DB::commit();
            return response()->json(['success' => true, 'group' => $group]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function downloadGroupFile($messageId)
    {
        $message = GroupMessage::findOrFail($messageId);
        if (!$message->group->users()->where('user_id', Auth::id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
            return Storage::disk('public')->download($message->file_path, $message->file_name);
        }
        return response()->json(['error' => 'File not found'], 404);
    }

    public function downloadPrivateFile($messageId)
    {
        $message = Message::findOrFail($messageId);
        if ($message->sender_id != Auth::id() && $message->receiver_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
            return Storage::disk('public')->download($message->file_path, $message->file_name);
        }
        return response()->json(['error' => 'File not found'], 404);
    }

    // ============ UTILITIES ============
    public function getConversations()
    {
        $conversations = Conversation::where('user_one', Auth::id())->orWhere('user_two', Auth::id())
            ->with(['userOne', 'userTwo'])->latest('updated_at')->get();

        $formattedConversations = [];
        foreach ($conversations as $conversation) {
            $otherUser = $conversation->user_one == Auth::id() ? $conversation->userTwo : $conversation->userOne;
            $formattedConversations[] = [
                'id' => $conversation->id,
                'other_user_id' => $otherUser->id,
                'other_user_name' => $otherUser->name,
                'other_user_avatar' => strtoupper(substr($otherUser->name, 0, 1)),
                'unread_count' => Message::where('conversation_id', $conversation->id)->where('receiver_id', Auth::id())->where('is_read', false)->count(),
                'last_message' => $conversation->last_message ?? 'No messages yet',
                'last_message_time' => $conversation->last_message_time ? $conversation->last_message_time->diffForHumans() : ''
            ];
        }

        $totalUnread = Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
        return response()->json(['success' => true, 'conversations' => $formattedConversations, 'total_unread' => $totalUnread]);
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
        return response()->json(['success' => true, 'count' => $count]);
    }

    public function streamAudio($messageId)
    {
        $message = Message::find($messageId);
        if (!$message) {
            $message = GroupMessage::find($messageId);
        }
        if (!$message) {
            abort(404);
        }

        if ($message instanceof Message) {
            if ($message->sender_id != Auth::id() && $message->receiver_id != Auth::id()) {
                abort(403);
            }
        } else {
            $isMember = $message->group->users()->where('user_id', Auth::id())->exists();
            if (!$isMember) {
                abort(403);
            }
        }

        $filePath = storage_path('app/public/' . $message->file_path);
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = strtolower(pathinfo($message->file_name, PATHINFO_EXTENSION));
        $mime = match ($extension) {
            'wav' => 'audio/wav',
            'webm' => 'audio/webm',
            default => mime_content_type($filePath) ?: 'application/octet-stream'
        };

        return response()->file($filePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'no-cache, private',
        ]);
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576)
            return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)
            return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}