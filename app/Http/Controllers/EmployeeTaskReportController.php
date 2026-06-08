<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AccountBaseController;
use App\Models\EmployeeReport;
use App\Models\User;
use App\Models\EmployeeDetails;
use App\Models\EmployeeTaskReport;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EmployeeTaskReportController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.employeeTaskReport';
    }
    
    public function index(Request $request)
    {
        $this->pageTitle = 'Employee Task';
    
        $query = EmployeeTaskReport::with('user')
            ->select('user_id')
            ->groupBy('user_id');
    
        if (auth()->user()->id !== 1) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('employee_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->employee_name}%");
            });
        }
    
        $this->employees = $query->get();
    
        return view('reports.employee-task.index', $this->data);
    }




    public function create()
    {
        $this->user = user(); // logged-in user

        $employeeDetails = EmployeeDetails::where('user_id', $this->user->id)->first();

        $this->reportingTo = $employeeDetails
            ? User::find($employeeDetails->reporting_to)
            : null;

        return view('reports.employee-task.create', $this->data);
    }
    
    

  public function store(Request $request)
    {
        $request->validate([
        'reports' => 'required|string',
        'status' => 'required|string',
        'report_date' => 'required|date_format:Y-m-d g:i A',
        ]);
            
        // Convert to DB format
        $reportDate = Carbon::createFromFormat(
            'Y-m-d g:i A', // <-- use g instead of h
            $request->report_date,
            'Asia/Kolkata'
        )->format('Y-m-d H:i:s');
    
        // Get reporting_to
        $employeeDetails = EmployeeDetails::where('user_id', auth()->id())->first();
    
        EmployeeTaskReport::create([
            'user_id'      => auth()->id(),
            'reporting_to' => $employeeDetails->reporting_to ?? null,
            'reports'      => $request->reports,
            'status'       => $request->status,
            'report_date'  => $reportDate,
        ]);
        
        return response()->json([
        'status' => 'success',
        'redirectUrl' => route('employee_task.reports.my')
        ]);


    
        // return redirect()->route('employee_task.report.index')
        //          ->with('success', 'Report saved successfully');
    }
    
    public function show(EmployeeTaskReport $report)
    {
        $this->pageTitle = 'Report Details';
    
        $this->report = $report->load(['user', 'reportingPerson']);
    
        return view('reports.employee-task.show', $this->data);
    }

    public function myReports()
    {
        $this->pageTitle = 'My Reports';
        
        $this->reports = EmployeeTaskReport::with(['user', 'reportingPerson'])
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->get();
    
        return view('reports.employee-task.my_reports', $this->data);
    }
    
    public function assignedReports()
    {
        $user = auth()->user();
    
        $this->pageTitle = $user->name . ' – Task Assigned Employees';
    
        $employeeIds = EmployeeDetails::where('reporting_to', $user->id)
            ->pluck('user_id');
    
        $this->employees = User::whereIn('id', $employeeIds)
            ->orderBy('name')
            ->get();
    
        $this->manager = $user;
    
        return view('reports.employee-task.assigned_task', $this->data);
    }
    

     public function userReports(User $user)
    {
        $this->pageTitle = $user->name . ' – Task detail';
    
        $this->tasks = EmployeeTaskReport::with(['user', 'reportingPerson'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    
        // current employee whose tasks are shown
        $this->employee = $user;
    
        // ✅ check if this user is a reporting manager
        $this->hasAssignedEmployees = EmployeeDetails::where(
            'reporting_to',
            $user->id
        )->exists();
    
        return view('reports.employee-task.user_task', $this->data);
    }
    public function assignedByManager(User $manager)
    {
        $this->pageTitle = $manager->name . ' – Assigned Employees';
    
        $employeeIds = EmployeeDetails::where('reporting_to', $manager->id)
            ->pluck('user_id');
        $this->employees = User::whereIn('id', $employeeIds)
                ->orderBy('name')
                ->get();
        $this->manager = $manager;
    
        return view('reports.employee-task.assigned_task', $this->data);
    }


}
