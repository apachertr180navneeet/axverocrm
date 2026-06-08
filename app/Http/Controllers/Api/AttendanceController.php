<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * 🔹 Get Today's Attendance
     */
  public function today()
{
    $user = Auth::user();

    $attendance = Attendance::where('user_id', $user->id)
        ->whereDate('clock_in_time', \Carbon\Carbon::today())
        ->first();

    if (!$attendance) {
        return response()->json([
            'status' => false,
            'message' => 'no attendence, please check-in',
            'data' => null
        ]);
    }

    // ✅ Attendance found
    return response()->json([
        'status' => true,
        'message' => 'Attendance found',
        'data' => $attendance
    ]);
}

    /**
     * 🔹 Create / Submit Today's Attendance
     */
    public function submit()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('clock_in_time', $today)
            ->first();

        // ✅ CLOCK IN
        if (!$attendance) {

            $attendance = Attendance::create([
                'company_id' => $user->company_id ?? 1,
                'user_id' => $user->id,
                'location_id' => 1,
                'clock_in_time' => now(),
                'clock_in_ip' => request()->ip(),
                'working_from' => 'office',
                'added_by' => $user->id,
                'last_updated_by' => $user->id,
                'shift_start_time' => $today->copy()->setTime(9, 0),
                'shift_end_time' => $today->copy()->setTime(18, 0),
                'half_day'=>'no'
            ]);

            return response()->json([
                'message' => 'Clock In successful',
                'data' => $attendance
            ]);
        }

        // ✅ CLOCK OUT
        if (!$attendance->clock_out_time) {

            $attendance->update([
                'clock_out_time' => now(),
                'clock_out_ip' => request()->ip(),
                'last_updated_by' => $user->id,
            ]);

            return response()->json([
                'message' => 'Clock Out successful',
                'data' => $attendance
            ]);
        }

     
        return response()->json([
            'message' => 'Today attendance already completed'
        ], 400);
    }
    
public function index(Request $request)
{
    $viewAttendancePermission = user()->permission('view_attendance');

    $query = Attendance::with('user')->latest();

    // 🔐 Permission logic
    if ($viewAttendancePermission == 'owned') {
        $query->where('user_id', user()->id);
    }

    if ($request->employee_id) {
        $query->where('user_id', $request->employee_id);
    }

    $attendances = $query->get();

    return response()->json([
        'status' => true,
        'message' => 'Attendance list fetched successfully',
        'data' => $attendances
    ]);
}
    
    
}