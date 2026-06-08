<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AccountBaseController;
use App\Models\TrainingAttendance;
use App\Models\User;
use App\Models\EmployeeDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainingAttendanceController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Training Attendance';
    }

    /**
     * INDEX – List employees (same pattern as Employee Report)
     */
    public function index(Request $request)
    {
        $this->pageTitle = 'Training Attendance';
    
        $query = \App\Models\TrainingAttendance::with('user')
            ->orderBy('training_date', 'desc');
    
        if (!in_array('admin', user_roles())) {
            $query->where('user_id', auth()->id());
        }
    
        $this->trainings = $query->get();
    
        return view('reports.training.index', $this->data);
    }


    /**
     * CREATE – Training Attendance Form
     */
    public function create()
    {
        $this->user = user();

        $employeeDetails = EmployeeDetails::where('user_id', $this->user->id)->first();

        $this->reportingTo = $employeeDetails
            ? User::find($employeeDetails->reporting_to)
            : null;

        return view('reports.training.create', $this->data);
    }

    /**
     * STORE – Save Training Attendance
     */
    public function store(Request $request)
    {
        $request->validate([
            'training_date'  => 'required|date',
            'training_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imagePath = null;

        if ($request->hasFile('training_image')) {
            $image = $request->file('training_image');
            $destinationPath = public_path('upload/training-attendance');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);

            $imagePath = 'upload/training-attendance/' . $imageName;
        }

        $employeeDetails = EmployeeDetails::where('user_id', auth()->id())->first();

        TrainingAttendance::create([
            'company_id'     => company()->id,
            'user_id'        => auth()->id(),
            'company_email'  => auth()->user()->email,
            'senior_id'      => $employeeDetails->reporting_to ?? null,
            'training_date'  => Carbon::parse($request->training_date)->format('Y-m-d'),
            'training_image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'redirectUrl' => route('training.attendance.index')
        ]);
    }
}
