<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AccountBaseController;
use App\Models\EmployeeReport;
use App\Models\User;
use App\Models\EmployeeDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EmployeeReportController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.employeeReport';
    }
    
   public function index(Request $request)
    {
        $this->pageTitle = 'Employee Reports';
    
        $query = User::orderBy('name');
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        $this->employees = $query->get();
    
        return view('reports.employee.index', $this->data);
    }


    public function create()
    {
        $this->user = user();

        $employeeDetails = EmployeeDetails::where('user_id', $this->user->id)->first();

        $this->reportingTo = $employeeDetails
            ? User::find($employeeDetails->reporting_to)
            : null;

        return view('reports.employee.create', $this->data);
    }

  public function store(Request $request)
{
    // ✅ Validation
    $request->validate([
        'report_file'            => 'nullable|file|mimes:xlsx,xls,csv,jpeg,png,jpg,pdf|max:10240',
        'report_date'            => 'required|date_format:Y-m-d g:i A',
        'report_description'     => 'required|string',

        // Sales Report Fields
        'full_name'              => 'required|string|max:255',
        'today_sale'             => 'required|integer|min:0',
        'today_team'             => 'required|integer|min:0',
        'overall_total_sale'     => 'required|integer|min:0',
        'overall_total_team'     => 'required|integer|min:0',
        'marketing_work_done'    => 'required|in:yes,no',
    ]);

    // ✅ Convert report date to DB format
    $reportDate = Carbon::createFromFormat(
        'Y-m-d g:i A',
        $request->report_date,
        'Asia/Kolkata'
    )->format('Y-m-d H:i:s');

    // ✅ File upload
    $filePath = null;

    if ($request->hasFile('report_file')) {
        $file = $request->file('report_file');
        $destinationPath = public_path('upload/employee-report');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);

        $filePath = 'upload/employee-report/' . $fileName;
    }

    // ✅ Get reporting manager
    $employeeDetails = EmployeeDetails::where('user_id', auth()->id())->first();

    // ✅ Save report
    EmployeeReport::create([
        'user_id'              => auth()->id(),
        'reporting_to'         => $employeeDetails->reporting_to ?? null,
        'file'                 => $filePath,
        'report_date'          => $reportDate,
        'report_description'   => $request->report_description,

        // Sales Report Data
        'full_name'            => $request->full_name,
        'today_sale'           => $request->today_sale,
        'today_team'           => $request->today_team,
        'overall_total_sale'   => $request->overall_total_sale,
        'overall_total_team'   => $request->overall_total_team,
        'marketing_work_done'  => $request->marketing_work_done,
    ]);

    // ✅ Response
    return response()->json([
        'status' => 'success',
        'redirectUrl' => route('employee.reports.my'),
    ]);
}


    public function myReports()
    {
        $this->pageTitle = 'My Reports';
        
        $this->reports = EmployeeReport::with(['user', 'reportingPerson'])
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->get();
    
        return view('reports.employee.my_reports', $this->data);
    }
    
    public function show(EmployeeReport $report)
    {
        $this->pageTitle = 'Report Details';
    
        $this->report = $report->load(['user', 'reportingPerson']);
    
        return view('reports.employee.show', $this->data);
    }

    public function assignedReports()
{
    $loggedInUserId = auth()->id();

    $this->pageTitle = 'Assigned Reports';

    // Get only reports where logged-in user is manager
    $this->assignedReports = EmployeeReport::with(['user', 'reportingPerson'])
                                ->where('reporting_to', $loggedInUserId)
                                ->latest()
                                ->get();

    return view('reports.employee.assigned_reports', $this->data);
}

    public function employeeReports(User $user, Request $request)
{
    $this->pageTitle = $user->name . ' Reports';

    $query = EmployeeReport::with(['user', 'reportingPerson'])
        ->where('user_id', $user->id);

    // Optional date filter
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('report_date', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay(),
        ]);
    }

    $this->reports = $query->latest()->get();
    $this->employee = $user;

    return view('reports.employee.employeedetailpage', $this->data);
}
    public function assignedEmployees(User $user)
    {
        $this->pageTitle = $user->name . ' – Assigned Employees';
    
        // Get employees who report to this user
        $employeeIds = EmployeeDetails::where('reporting_to', $user->id)
            ->pluck('user_id');
    
        $this->employees = User::whereIn('id', $employeeIds)
            ->orderBy('name')
            ->get();
    
        $this->manager = $user;
    
        return view('reports.employee.assigned_employees', $this->data);
    }


}
