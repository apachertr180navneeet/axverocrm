<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveController extends Controller
{

    // ===========================
    // ✅ INDEX (LIST + SUMMARY)
    // ===========================
    public function index()
    {
        $user = user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // ✅ Leave Types
        $leaveTypes = LeaveType::select('id', 'type_name', 'paid')->get();

        // ✅ User Leaves
        $leaves = Leave::with(['leaveType:id,type_name'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // =========================
        // ✅ SUMMARY
        // =========================
        $fullDay = $leaves->where('duration', '!=', 'half day')->count();
        $halfDay = $leaves->where('duration', 'half day')->count();
        $totalLeaves = $fullDay + ($halfDay * 0.5);

        return response()->json([
            'status' => true,
            'data' => [
                'summary' => [
                    'full_day' => $fullDay,
                    'half_day' => $halfDay,
                    'total' => $totalLeaves
                ],
                'leave_types' => $leaveTypes,
                'leaves' => $leaves
            ]
        ]);
    }


    // ===========================
    // ✅ STORE (CREATE LEAVE)
    // ===========================
    public function store(Request $request)
    {
        try {

            $user = user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // ✅ Validation
            if (!$request->leave_type_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Leave type is required'
                ], 422);
            }

            // ✅ Leave Type Check
            $leaveType = LeaveType::find($request->leave_type_id);

            if (!$leaveType) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid leave type'
                ], 404);
            }

            // ✅ Duration Mapping
            $duration = match ($request->duration) {
                'first_half', 'second_half' => 'half day',
                default => $request->duration,
            };

            // =========================
            // ✅ DATE HANDLING
            // =========================
            $dates = [];

            if ($request->duration == 'multiple') {

                if (!$request->multiStartDate || !$request->multiEndDate) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Start and end date required'
                    ], 422);
                }

                $start = Carbon::parse($request->multiStartDate);
                $end = Carbon::parse($request->multiEndDate);

                if ($start > $end) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid date range'
                    ], 422);
                }

                foreach (CarbonPeriod::create($start, $end) as $date) {
                    $dates[] = $date->copy()->startOfDay();
                }

            } else {

                if (!$request->leave_date) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Leave date required'
                    ], 422);
                }

                $dates[] = Carbon::parse($request->leave_date)->startOfDay();
            }

            // =========================
            // ✅ REMOVE HOLIDAYS
            // =========================
            $formattedDates = collect($dates)->map(fn($d) => $d->format('Y-m-d'));

            $holidays = Holiday::whereIn('date', $formattedDates)->pluck('date');

            $validDates = collect($dates)->filter(function ($date) use ($holidays) {
                return !$holidays->contains($date->format('Y-m-d'));
            });

            if ($validDates->count() == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'All selected dates are holidays'
                ], 400);
            }

            DB::beginTransaction();

            // ✅ File Upload (optional)
            $filePath = null;
            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('leave-attachments', 'public');
            }

            // =========================
            // ✅ SAVE LEAVES
            // =========================
            $uniqueId = Str::random(16);
            $leaveIds = [];

            foreach ($validDates as $date) {

                $leave = new Leave();

                $leave->user_id = $user->id; // 🔥 AUTH USER ONLY
                $leave->unique_id = $uniqueId;
                $leave->leave_type_id = $request->leave_type_id;
                $leave->duration = $duration;
                $leave->leave_date = $date->format('Y-m-d');
                $leave->reason = $request->reason;
                $leave->status = 'pending';
                $leave->paid = $leaveType->paid;

                if ($duration == 'half day') {
                    $leave->half_day_type = $request->duration;
                }

                if ($filePath) {
                    $leave->attachment = $filePath;
                }

                $leave->save();
                $leaveIds[] = $leave->id;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Leave applied successfully',
                'data' => [
                    'leave_ids' => $leaveIds,
                    'attachment_url' => $filePath ? url('storage/' . $filePath) : null
                ]
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}