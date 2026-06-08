<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserChat;
use App\Models\User;
use App\Models\UserchatFile;

class MessagesController extends Controller
{

    // 🔹 1. Conversation List
    public function index()
    {
        try {
            $userId = auth()->id();

            $messages = UserChat::where(function ($q) use ($userId) {
                    $q->where('from', $userId)
                      ->orWhere('to', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($chat) use ($userId) {
                    return $chat->from == $userId ? $chat->to : $chat->from;
                });

            $data = [];

            foreach ($messages as $otherUserId => $chatList) {
                $last = $chatList->first();
                $user = User::find($otherUserId);

                $data[] = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_message' => $last->message,
                    'time' => $last->created_at,
                    'unread_count' => $chatList->where('to', $userId)
                                                ->where('message_seen', 'no')
                                                ->count()
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'Conversation list fetched',
                'data' => array_values($data)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 2. Chat Detail
    public function chat($id)
    {
        try {
            $userId = auth()->id();

            $messages = UserChat::where(function ($q) use ($userId, $id) {
                    $q->where('from', $userId)->where('to', $id);
                })
                ->orWhere(function ($q) use ($userId, $id) {
                    $q->where('from', $id)->where('to', $userId);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            // mark as read
            UserChat::where('from', $id)
                ->where('to', $userId)
                ->update(['message_seen' => 'yes']);

            return response()->json([
                'status' => true,
                'message' => 'Chat fetched',
                'data' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching chat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 3. Send Message (NO FILE HERE ❗)
   public function store(Request $request)
{
    try {
        $request->validate([
            'user_type' => 'required|in:employee,client',
            'user_id' => 'required_if:user_type,employee|exists:users,id',
            'client_id' => 'required_if:user_type,client|exists:users,id',
            'message' => 'nullable|string',
            'file.*' => 'nullable|file|max:10240'
        ]);

        $receiverID = $request->user_type == 'client'
            ? $request->client_id
            : $request->user_id;

        if (!$request->message && !$request->hasFile('file')) {
            return response()->json([
                'status' => false,
                'message' => 'Message or file required'
            ], 422);
        }

        // ✅ Step 1: Save Message
        $chat = new UserChat();
        $chat->message = $request->message;
        $chat->user_one = auth()->id();
        $chat->user_id = $receiverID;
        $chat->from = auth()->id();
        $chat->to = $receiverID;
        $chat->message_seen = 'no';
        $chat->save();

        $uploadedFiles = [];

        // ✅ Step 2: Save Files (same Blade logic)
        if ($request->hasFile('file')) {

            foreach ($request->file('file') as $fileData) {

                $file = new \App\Models\UserchatFile();
                $file->users_chat_id = $chat->id;

                $filename = \App\Helper\Files::uploadLocalOrS3(
                    $fileData,
                    \App\Models\UserchatFile::FILE_PATH
                );

                $file->user_id = auth()->id();
                $file->filename = $fileData->getClientOriginalName();
                $file->hashname = $filename;
                $file->size = $fileData->getSize();
                $file->save();

                $uploadedFiles[] = [
                    'id' => $file->id,
                    'file_name' => $file->filename,
                    'file_url' => asset('storage/' . $filename),
                ];
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => [
                'message_id' => $chat->id,
                'receiver_id' => $receiverID,
                'files' => $uploadedFiles
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error sending message',
            'error' => $e->getMessage()
        ], 500);
    }
}

    
}