<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Models\DashboardWidget;
use App\Models\DealFollowUp;
use App\Models\EmployeeDetails;
use App\Models\Event;
use App\Models\Holiday;
use App\Models\LeadPipeline;
use App\Models\Leave;
use App\Models\ProjectTimeLog;
use App\Models\ProjectTimeLogBreak;
use App\Models\PushNotificationSetting;
use App\Models\Task;
use App\Models\DailyReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgentRetainerExport;
use App\Models\TaskboardColumn;
use App\Models\Ticket;
use App\Traits\ClientDashboard;
use App\Traits\ClientPanelDashboard;
use App\Traits\CurrencyExchange;
use App\Traits\EmployeeDashboard;
use App\Traits\FinanceDashboard;
use App\Traits\HRDashboard;
use App\Traits\OverviewDashboard;
use App\Traits\ProjectDashboard;
use App\Traits\TicketDashboard;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use PDF;
use App\Models\HrExecutiveReport;
use App\Models\SalesExecutiveReport;
use App\Models\AgentRetainer;
use App\Models\HiringSubmission;

class DashboardController extends AccountBaseController
{

    use AppBoot, CurrencyExchange, OverviewDashboard, EmployeeDashboard, ProjectDashboard, ClientDashboard, HRDashboard, TicketDashboard, FinanceDashboard, ClientPanelDashboard;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.dashboard';

        $this->middleware(function ($request, $next) {
            return $next($request);
        });

    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|mixed|void
     */
    public function index()
    {

        $this->isCheckScript();
        session()->forget(['qr_clock_in']);
        if (in_array('employee', user_roles())) {

            $this->viewOverviewDashboard = user()->permission('view_overview_dashboard');
            $this->viewProjectDashboard = user()->permission('view_project_dashboard');
            $this->viewClientDashboard = user()->permission('view_client_dashboard');
            $this->viewHRDashboard = user()->permission('view_hr_dashboard');
            $this->viewTicketDashboard = user()->permission('view_ticket_dashboard');
            $this->viewFinanceDashboard = user()->permission('view_finance_dashboard');

            return $this->employeeDashboard();
        }

        if (in_array('client', user_roles())) {
            return $this->clientPanelDashboard();
        }
    }

    public function widget(Request $request, $dashboardType)
    {
        $data = $request->except('_token');

        // Step 1: Reset all widgets' status to 0
        DashboardWidget::where('status', 1)
            ->where('dashboard_type', $dashboardType)
            ->update(['status' => 0]);

        // Step 2: Update the status to 1 for widgets present in the request
        if (!empty($data)) {
            DashboardWidget::where('dashboard_type', $dashboardType)
                ->whereIn('widget_name', array_keys($data))
                ->update(['status' => 1]);
        }

        return Reply::success(__('messages.updateSuccess'));
    }

    public function checklist()
    {
        if (in_array('admin', user_roles())) {
            $this->isCheckScript();

            return view('dashboard.checklist', $this->data);
        }
    }

    /**
     * @return array|\Illuminate\Http\Response
     */
    public function memberDashboard()
    {
        abort_403(!in_array('employee', user_roles()));

        return $this->employeeDashboard();
    }

    public function advancedDashboard()
    {

        if (in_array('admin', user_roles()) || $this->sidebarUserPermissions['view_overview_dashboard'] == 4
            || $this->sidebarUserPermissions['view_project_dashboard'] == 4
            || $this->sidebarUserPermissions['view_client_dashboard'] == 4
            || $this->sidebarUserPermissions['view_hr_dashboard'] == 4
            || $this->sidebarUserPermissions['view_ticket_dashboard'] == 4
            || $this->sidebarUserPermissions['view_finance_dashboard'] == 4) {

            $tab = request('tab');

            switch ($tab) {
            case 'project':
                $this->projectDashboard();
                break;
            case 'client':
                $this->clientDashboard();
                break;
            case 'hr':
                $this->hrDashboard();
                break;
            case 'ticket':
                $this->ticketDashboard();
                break;
            case 'finance':
                $this->financeDashboard();
                break;
            default:
                if (in_array('admin', user_roles()) || $this->sidebarUserPermissions['view_overview_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'overview';
                    $this->overviewDashboard();

                }
                elseif ($this->sidebarUserPermissions['view_project_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'project';
                    $this->projectDashboard();

                }
                elseif ($this->sidebarUserPermissions['view_client_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'client';
                    $this->clientDashboard();

                }
                elseif ($this->sidebarUserPermissions['view_hr_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'hr';
                    $this->hrDashboard();

                }
                elseif ($this->sidebarUserPermissions['view_finance_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'finance';
                    $this->ticketDashboard();

                }
                else if ($this->sidebarUserPermissions['view_ticket_dashboard'] == 4) {
                    $this->activeTab = $tab ?: 'finance';
                    $this->financeDashboard();
                }

                break;
            }

            if (request()->ajax()) {
                return $this->returnAjax($this->view);
            }

            if (!isset($this->activeTab)) {
                $this->activeTab = $tab ?: 'overview';
            }

            return view('dashboard.admin', $this->data);
        }
    }

    public function accountUnverified()
    {
        return view('dashboard.unverified', $this->data);
    }

    public function weekTimelog()
    {
        $now = now(company()->timezone);
        $attndcSetting = attendance_setting();
        $this->timelogDate = $timelogDate = Carbon::parse(request()->date);
        $this->weekStartDate = $now->copy()->startOfWeek($attndcSetting->week_start_from);
        $this->weekEndDate = $this->weekStartDate->copy()->addDays(7);
        $this->weekPeriod = CarbonPeriod::create($this->weekStartDate, $this->weekStartDate->copy()->addDays(6)); // Get All Dates from start to end date

        $this->dateWiseTimelogs = ProjectTimeLog::dateWiseTimelogs($timelogDate->toDateString(), user()->id);
        $this->dateWiseTimelogBreak = ProjectTimeLogBreak::dateWiseTimelogBreak($timelogDate->toDateString(), user()->id);

        $this->weekWiseTimelogs = ProjectTimeLog::weekWiseTimelogs($this->weekStartDate->copy()->toDateString(), $this->weekEndDate->copy()->toDateString(), user()->id);
        $this->weekWiseTimelogBreak = ProjectTimeLogBreak::weekWiseTimelogBreak($this->weekStartDate->toDateString(), $this->weekEndDate->toDateString(), user()->id);

        $this->dayMinutes = $this->dateWiseTimelogs->sum('total_minutes');
        $this->dayBreakMinutes = $this->dateWiseTimelogBreak->sum('total_minutes');
        $loggedMinutes = $this->dayMinutes - $this->dayBreakMinutes;

        $this->totalDayMinutes = $this->formatTime($loggedMinutes);
        $this->totalDayBreakMinutes = $this->formatTime($this->dayBreakMinutes);

        $html = view('dashboard.employee.week_timelog', $this->data)->render();

        return Reply::dataOnly(['html' => $html]);
    }

    private function formatTime($totalMinutes)
    {
        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return $hours > 0
            ? $hours . 'h' . ($minutes > 0 ? ' ' . sprintf('%02dm', $minutes) : '')
            : ($minutes > 0 ? sprintf('%dm', $minutes) : '0s');
    }

    public function privateCalendar()
    {
        if (request()->filter) {
            $employee_details = EmployeeDetails::where('user_id', user()->id)->first();
            $employee_details->calendar_view = request()->filter ? request()->filter : null;
            $employee_details->save();
            session()->forget('user');
        }

        $startDate = Carbon::parse(request('start'));
        $endDate = Carbon::parse(request('end'));

        // get calendar view current logined user
        $calendar_filter_array = explode(',', user()->employeeDetail->calendar_view);

        $eventData = array();

        $viewEventPerm = user()->permission('view_events');

        if (!is_null($viewEventPerm) && $viewEventPerm != 'none') {

            if (in_array('events', $calendar_filter_array)) {
                // Events
                $model = Event::with('attendee', 'attendee.user');

                $model->where(function ($query) {
                    $query->whereHas('attendee', function ($query) {
                        $query->where('user_id', user()->id);
                    });
                    $query->orWhere('added_by', user()->id);
                });

                $model->whereBetween('start_date_time', [$startDate->toDateString(), $endDate->toDateString()]);

                $events = $model->get();


                foreach ($events as $event) {
                    $eventData[] = [
                        'id' => $event->id,
                        'title' => $event->event_name,
                        'start' => $event->start_date_time,
                        'end' => $event->end_date_time,
                        'event_type' => 'event',
                        'extendedProps' => ['bg_color' => $event->label_color, 'color' => '#fff', 'icon' => 'fa-calendar']
                    ];
                }
            }

        }
        $user = user();
        $viewHolidayPerm = user()->permission('view_holiday');

        if (!is_null($viewHolidayPerm) && $viewHolidayPerm != 'none') {
            if (in_array('holiday', $calendar_filter_array)) {
                // holiday
                $holidays = Holiday::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                    ->where(function ($query) use ($user) {
                        $query->where(function ($subquery) use ($user) {
                                $subquery->where(function ($q) use ($user) {
                                    $q->where('department_id_json', 'like', '%"' . $user->employeeDetail->department_id . '"%')
                                        ->orWhereNull('department_id_json');
                                });
                                $subquery->where(function ($q) use ($user) {
                                    $q->where('designation_id_json', 'like', '%"' . $user->employeeDetail->designation_id . '"%')
                                        ->orWhereNull('designation_id_json');
                                });
                                $subquery->where(function ($q) use ($user) {
                                    $q->where('employment_type_json', 'like', '%"' . $user->employeeDetail->employment_type . '"%')
                                        ->orWhereNull('employment_type_json');
                                });
                        });
                    });
                $holidays = $holidays->get();

                foreach ($holidays as $holiday) {
                    $eventData[] = [
                        'id' => $holiday->id,
                        'title' => $holiday->occassion,
                        'start' => $holiday->date,
                        'end' => $holiday->date,
                        'event_type' => 'holiday',
                        'extendedProps' => ['bg_color' => '#1d82f5', 'color' => '#fff', 'icon' => 'fa-star']
                    ];
                }
            }

        }

        $viewTaskPerm = user()->permission('view_tasks');

        if (!is_null($viewTaskPerm) && $viewTaskPerm != 'none') {

            if (in_array('task', $calendar_filter_array)) {
                // tasks
                $completedTaskColumn = TaskboardColumn::completeColumn();

                $tasks = Task::with('boardColumn')
                    ->where('board_column_id', '<>', $completedTaskColumn->id)
                    ->whereHas('users', function ($query) {
                        $query->where('user_id', user()->id);
                    })
                    ->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween(DB::raw('DATE(tasks.`due_date`)'), [$startDate->toDateString(), $endDate->toDateString()]);

                        $q->orWhereBetween(DB::raw('DATE(tasks.`start_date`)'), [$startDate->toDateString(), $endDate->toDateString()]);
                    })->get();

                foreach ($tasks as $task) {
                    $eventData[] = [
                        'id' => $task->id,
                        'title' => $task->heading,
                        'start' => $task->start_date,
                        'end' => $task->due_date ?: $task->start_date,
                        'event_type' => 'task',
                        'extendedProps' => ['bg_color' => $task->boardColumn->label_color, 'color' => '#fff', 'icon' => 'fa-list']
                    ];
                }
            }
        }

        $viewTicketPerm = user()->permission('view_tickets');

        if (!is_null($viewTicketPerm) && $viewTicketPerm != 'none') {

            if (in_array('tickets', $calendar_filter_array)) {
                // tickets
                $tickets = Ticket::where('user_id', user()->id)
                    ->whereBetween(DB::raw('DATE(tickets.`updated_at`)'), [$startDate->toDateTimeString(), $endDate->endOfDay()->toDateTimeString()])->get();

                foreach ($tickets as $ticket) {
                    $eventData[] = [
                        'id' => $ticket->ticket_number,
                        'title' => $ticket->subject,
                        'start' => $ticket->updated_at,
                        'end' => $ticket->updated_at,
                        'event_type' => 'ticket',
                        'extendedProps' => ['bg_color' => '#1d82f5', 'color' => '#fff', 'icon' => 'fa-ticket-alt']
                    ];
                }
            }

        }

        $viewleavePerm = user()->permission('view_leave');

        if (!is_null($viewleavePerm) && $viewleavePerm != 'none') {

            if (in_array('leaves', $calendar_filter_array)) {
                // approved leaves of all emoloyees with employee name
                $leaves = Leave::join('leave_types', 'leave_types.id', 'leaves.leave_type_id')
                    ->where('leaves.status', 'approved')
                    ->select('leaves.id', 'leaves.leave_date', 'leaves.status', 'leave_types.type_name', 'leave_types.color', 'leaves.leave_date', 'leaves.duration', 'leaves.status', 'leaves.user_id')
                    ->with('user')
                    ->whereBetween(DB::raw('DATE(leaves.`leave_date`)'), [$startDate->toDateString(), $endDate->toDateString()])
                    ->get();

                foreach ($leaves as $leave) {
                    $duration = ($leave->duration == 'half day') ? '( ' . __('app.halfday') . ' )' : '';

                    $eventData[] = [
                        'id' => $leave->id,
                        'title' => $duration . ' ' . $leave->user->name,
                        'start' => $leave->leave_date->toDateString(),
                        'end' => $leave->leave_date->toDateString(),
                        'event_type' => 'leave',
                        /** @phpstan-ignore-next-line */
                        'extendedProps' => ['name' => 'Leave : ' . $leave->user->name, 'bg_color' => $leave->color, 'color' => '#fff', 'icon' => 'fa-plane-departure']
                    ];
                }
            }
        }

        $viewDealPerm = user()->permission('view_deals');

        if (!is_null($viewDealPerm) && $viewDealPerm != 'none') {

            if (in_array('follow_ups', $calendar_filter_array)) {
                // follow ups
                $followUps = DealFollowUp::with('lead')->whereHas('lead.leadAgent', function ($query) {
                        $query->where('user_id', user()->id);
                })
                    ->whereBetween(DB::raw('DATE(next_follow_up_date)'), [$startDate->startOfDay()->toDateTimeString(), $endDate->endOfDay()->toDateTimeString()])
                    ->get();


                foreach ($followUps as $followUp) {
                    $eventData[] = [
                        'id' => $followUp->id,
                        'title' => $followUp->lead->name,
                        'start' => $followUp->next_follow_up_date->timezone(company()->timezone),
                        'end' => $followUp->next_follow_up_date->timezone(company()->timezone),
                        'event_type' => 'follow_up',
                        'extendedProps' => ['bg_color' => '#1d82f5', 'color' => '#fff', 'icon' => 'fa-thumbs-up']
                    ];
                }
            }

        }

        return $eventData;
    }

    public function getLeadStage($pipelineId)
    {
        $this->startDate = (request('startDate') != '') ? Carbon::createFromFormat($this->company->date_format, request('startDate')) : now($this->company->timezone)->startOfMonth();
        $this->endDate = (request('endDate') != '') ? Carbon::createFromFormat($this->company->date_format, request('endDate')) : now($this->company->timezone);
        $startDate = $this->startDate->toDateString();
        $endDate = $this->endDate->toDateString();

        $this->leadPipelines = LeadPipeline::all();

        $this->leadStatusChart = $this->leadStatusChart($startDate, $endDate, $pipelineId);

        return $this->returnAjax('dashboard.ajax.lead-by-pipeline');

    }

    public function beamAuth()
    {
        $userID = 'wrkst-'.user()->id;
        $userIDInQueryParam = request()->user_id;

        if ($userID != $userIDInQueryParam) {
            return response('Inconsistent request', 401);

        } else {
            $beamsClient = new \Pusher\PushNotifications\PushNotifications([
                'instanceId' => push_setting()->instance_id,
                'secretKey' => push_setting()->beam_secret,
            ]);

            $beamsToken = $beamsClient->generateToken($userID);
            return response()->json($beamsToken);
        }

    }

    public function sendPushNotifications($usersIDs, $title, $body)
    {
        $setting = PushNotificationSetting::first();
        if ($setting->beams_push_status && count($usersIDs) > 0) {
            $beamsClient = new \Pusher\PushNotifications\PushNotifications([
            'instanceId' =>  $setting->instance_id,
            'secretKey' =>  $setting->beam_secret,
            ]);


            $pushIDs = [];

            foreach ($usersIDs[0] as $key => $uid) {
                $pushIDs[] = 'wrkst-' . $uid;
            }

            $publishResponse = $beamsClient->publishToUsers(
            $pushIDs,
            array(
              'web' => array(
                'notification' => array(
                  'title' => $title,
                  'body' => $body,
                  'icon' => companyOrGlobalSetting()->logo_url
                  )
              )
            ));
        }

        return true;
    }

    // public function dailyReport(){
    //   return view('daily-report');
    // }

    
    
       public function dailyReport()
        {
            $this->pageTitle = 'Report Manager';
            
             $this->user = user();
    
            $employeeDetails = EmployeeDetails::where('user_id', $this->user->id)->first();
    
            $this->reportingTo = $employeeDetails
                ? User::find($employeeDetails->reporting_to)
                : null;
            
            //   if (user()->role[0]['role_id'] == 1){
            //      return  $this->dailyReportList();
            //   }else{
                  
                  
            // return view('daily-report',$this->data);
            //   }
            
                  return view('daily-report',$this->data); 
          
        }
        
    

    //     public function storeDailyReport(Request $request)
    //     {
    //         // Selected Persons
    //         $selectedPersons = [];
        
    //         if ($request->hr_name) {
    //             foreach ($request->hr_name as $i => $val) {
    //                 $selectedPersons[] = [
    //                     'hr_name' => $request->hr_name[$i] ?? null,
    //                     'hr_mobile' => $request->hr_mobile[$i] ?? null,
    //                     'selected_name' => $request->selected_name[$i] ?? null,
    //                     'selected_mobile' => $request->selected_mobile[$i] ?? null,
    //                     'salary_offered' => $request->salary_offered[$i] ?? null,
    //                     'person_email' => $request->person_email[$i] ?? null,
    //                 ];
    //             }
    //         }
        
    //         // Retainers
    //         $retainers = [];
        
    //         if ($request->retainer_hr_name) {
    //             foreach ($request->retainer_hr_name as $i => $val) {
    //                 $retainers[] = [
    //                     'hr_name' => $request->retainer_hr_name[$i] ?? null,
    //                     'hr_mobile' => $request->retainer_hr_mobile[$i] ?? null,
    //                     'retainer_name' => $request->retainer_name[$i] ?? null,
    //                     'retainer_mobile' => $request->retainer_mobile[$i] ?? null,
    //                 ];
    //             }
    //         }
        
    //         // Team Details
    //         $teamDetails = [];
        
    //         if ($request->total_hr_name) {
    //             foreach ($request->total_hr_name as $i => $val) {
    //                 $teamDetails[] = [
    //                     'hr_name' => $request->total_hr_name[$i] ?? null,
    //                     'hr_mobile' => $request->total_hr_mobile[$i] ?? null,
    //                     'total_active_executive' => $request->total_active_executive[$i] ?? null,
    //                     'total_active_retainer' => $request->total_active_retainer[$i] ?? null,
    //                 ];
    //             }
    //         }
        
          
    //         $report = new DailyReport();
        
    //         $report->report_date = $request->report_date;
    //         $report->portal_email = $request->portal_email;
    //         // $report-_user_id = $this->user_id;
    //         $report->name = $request->name;
    //         $report->user_id = auth()->id();
    //         $report->mobile = $request->mobile;
    //         $report->total_joined_retainer = $request->total_joined_retainer;
        
    //         $report->selected_persons = json_encode($selectedPersons);
    //         $report->retainers = json_encode($retainers);
    //         $report->team_details = json_encode($teamDetails);
        
    //         $report->save();
        
    //         // return back()->with('success', 'Report Manager Saved Successfully');
    //         return redirect()
    // ->route('daily-report.list')
    // ->with('success', 'Record Saved Successfully');
    //     }



        public function storeDailyReport(Request $request)
{
    // Selected Persons
    $selectedPersons = [];

    if ($request->hr_name) {
        foreach ($request->hr_name as $i => $val) {
            $selectedPersons[] = [
                'hr_name' => $request->hr_name[$i] ?? null,
                'hr_mobile' => $request->hr_mobile[$i] ?? null,
                'selected_name' => $request->selected_name[$i] ?? null,
                'selected_mobile' => $request->selected_mobile[$i] ?? null,
                'salary_offered' => $request->salary_offered[$i] ?? null,
                'person_email' => $request->person_email[$i] ?? null,

                // NEW FIELDS (added in frontend)
                'designation' => $request->designation[$i] ?? null,
                'joining_date' => $request->joining_date[$i] ?? null,
            ];
        }
    }

    /*
    ================= RETAINERS (CURRENTLY NOT USED IN FRONTEND) =================
    $retainers = [];

    if ($request->retainer_hr_name) {
        foreach ($request->retainer_hr_name as $i => $val) {
            $retainers[] = [
                'hr_name' => $request->retainer_hr_name[$i] ?? null,
                'hr_mobile' => $request->retainer_hr_mobile[$i] ?? null,
                'retainer_name' => $request->retainer_name[$i] ?? null,
                'retainer_mobile' => $request->retainer_mobile[$i] ?? null,
            ];
        }
    }
    */

    // Team Details
    $teamDetails = [];

    if ($request->total_hr_name) {
        foreach ($request->total_hr_name as $i => $val) {
            $teamDetails[] = [
                'hr_name' => $request->total_hr_name[$i] ?? null,
                'hr_mobile' => $request->total_hr_mobile[$i] ?? null,
                'total_active_executive' => $request->total_active_executive[$i] ?? null,
                'total_active_retainer' => $request->total_active_retainer[$i] ?? null,
            ];
        }
    }

         $report = new DailyReport();
        
        $report->report_date = $request->report_date;
        $report->portal_email = $request->portal_email;
        $report->name = $request->name;
        $report->user_id = auth()->id();
        $report->mobile = $request->mobile;
        
        $report->selected_persons = json_encode($selectedPersons);
        
        $report->team_details = json_encode($teamDetails);
        
        $report->save();

    return redirect()
        ->route('daily-report.list')
        ->with('success', 'Record Saved Successfully');
}

        public function dailyReportList($id = null)
     {
        $this->pageTitle = 'Report Manager';
    
        if (user()->role[0]['role_id'] == 1) {
            $this->reports = DailyReport::latest()
                ->paginate(10);
        } else {
            $this->reports = DailyReport::where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        }
    
        if ($id) {
    
            if (user()->role[0]['role_id'] == 1) {
                $this->report = DailyReport::where('id', $id)
                    ->firstOrFail();
            } else {
                $this->report = DailyReport::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
            }

      
        $this->selectedPersons = json_decode($this->report->selected_persons ?? '[]', true);
        $this->retainers = json_decode($this->report->retainers ?? '[]', true);
        $this->teamDetails = json_decode($this->report->team_details ?? '[]', true);
    }

    return view('daily-report-list', $this->data);
}


        public function dailyReportPdf($id)
    {
          
            if (user()->role[0]['role_id'] == 1) {
                $report = DailyReport::where('id', $id)
                    ->firstOrFail();
            } else {
                $report = DailyReport::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
            }
        
           
            $selectedPersons = json_decode($report->selected_persons ?? '[]', true);
            $retainers = json_decode($report->retainers ?? '[]', true);
            $teamDetails = json_decode($report->team_details ?? '[]', true);
        
            $pdf = PDF::loadView('daily-report-pdf', compact(
                'report',
                'selectedPersons',
                'retainers',
                'teamDetails'
            ));
        
            return $pdf->download('Daily-Report-'.$report->id.'.pdf');
    }


        
                    
                        public function executiveReport()
            {
                $this->pageTitle = 'Executive Report';
            
                $this->user = user();
            
        //       if (user()->role[0]['role_id'] == 1){
        //          return  $this->executiveReportList();
        //       }else{
                  
                  
        //   return view('hr-executive-report', $this->data);
        //       }
        return view('hr-executive-report', $this->data);
            }
                      


public function storeExecutiveReport(Request $request)
{
    // ================= Selected Persons =================
    $selectedPersons = [];

    if (!empty($request->selected_person_name)) {
        foreach ($request->selected_person_name as $i => $val) {
            $selectedPersons[] = [
                'name'   => $request->selected_person_name[$i] ?? null,
                'mobile' => $request->selected_mobile[$i] ?? null,
                'email'  => $request->selected_email[$i] ?? null,
                'designation'   => $request->selected_designation[$i] ?? null,
               'joining_date' => !empty($request->selected_joining_date[$i])
                    ? Carbon::parse($request->selected_joining_date[$i])->format('Y-m-d')
                    : null,
            ];
        }
    }

    // ================= Follow Up =================
    $followUp = [];

    if (!empty($request->follow_person_name)) {
        foreach ($request->follow_person_name as $i => $val) {

            $formattedInterviewDate = null;

            if (!empty($request->interview_date[$i])) {
                $formattedInterviewDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $request->interview_date[$i]
                )->format('Y-m-d');
            }

            $followUp[] = [
                'name'           => $request->follow_person_name[$i] ?? null,
                'mobile'         => $request->follow_mobile[$i] ?? null,
                'interview_date' => $formattedInterviewDate,
            ];
        }
    }

    // ================= Retainers =================
 

    // ================= Total Joined =================
    $totalJoined = [];

    if (!empty($request->total_executive)) {
        foreach ($request->total_executive as $i => $val) {
            $totalJoined[] = [
                'total_executive' => $request->total_executive[$i] ?? null,
                'total_sales_executive' => $request->total_sales_executive[$i] ?? null,
            ];
        }
    }

    // ================= Main Report Save =================
    $report = new HrExecutiveReport();

    // 🔥 FIXED DATE FORMAT
     $report->report_date = Carbon::createFromFormat(
        'd/m/Y',
        $request->report_date
    )->format('Y-m-d');
    
    $report->portal_email      = $request->portal_email;
    $report->name              = $request->name;
    $report->mobile            = $request->mobile;
    $report->hr_manager_name   = $request->hr_manager_name;
    $report->hr_manager_mobile = $request->hr_manager_mobile;
    $report->user_id           = auth()->id();
    
    $report->selected_persons     = json_encode($selectedPersons);
    $report->follow_up_candidates = json_encode($followUp);
    $report->total_joined_details = json_encode($totalJoined);
    
    $report->save();

    return redirect()
        ->route('hr.executive.report.list')
        ->with('success', 'Executive Report Saved Successfully');
}       
          
          
          
        public function executiveReportList($id = null)
{
    $this->pageTitle = 'Executive Report List';

    if (user()->role[0]['role_id'] == 1) {  // admin role_id = 1
        $this->reports = HrExecutiveReport::latest()->paginate(10);
    } else {
        $this->reports = HrExecutiveReport::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    }

    if ($id) {
        $query = HrExecutiveReport::where('id', $id);

        if (user()->role[0]['role_id'] != 1) {
            $query->where('user_id', auth()->id());
        }

        $this->report = $query->firstOrFail();

        $this->selectedPersons = json_decode($this->report->selected_persons ?? '[]', true);
        $this->followUp = json_decode($this->report->follow_up_candidates ?? '[]', true);
        $this->retainers = json_decode($this->report->referred_retainers ?? '[]', true);
        $this->totalJoined = json_decode($this->report->total_joined_details ?? '[]', true);
    }

   return view('hr-report-list', $this->data);
}

public function executiveReportPdf($id)
{
    $query = HrExecutiveReport::where('id', $id);

    // Non-admin user sirf apna data dekhe
    if (user()->role[0]['role_id'] != 1) {
        $query->where('user_id', auth()->id());
    }

    $report = $query->firstOrFail();

    // 🔥 FORCE SAFE ARRAY CONVERSION
    $selectedPersons = is_array($report->selected_persons)
        ? $report->selected_persons
        : json_decode($report->selected_persons, true);

    $followUp = is_array($report->follow_up_candidates)
        ? $report->follow_up_candidates
        : json_decode($report->follow_up_candidates, true);

    $retainers = is_array($report->referred_retainers)
        ? $report->referred_retainers
        : json_decode($report->referred_retainers, true);

    $totalJoined = is_array($report->total_joined_details)
        ? $report->total_joined_details
        : json_decode($report->total_joined_details, true);

    $pdf = PDF::loadView('hr-report-pdf', [
        'report' => $report,
        'selectedPersons' => $selectedPersons ?? [],
        'followUp' => $followUp ?? [],
        'retainers' => $retainers ?? [],
        'totalJoined' => $totalJoined ?? [],
    ]);

   return $pdf->download('Executive-Report-'.$report->id.'.pdf');
}

    // Sales executive 
    
    public function salesExecutive(){
           $this->pageTitle = 'Sales Executive'; 
               $this->user = user();
               
               return view('sales-executive',$this->data);
        
    }


          public function storeSalesExecutive(Request $request)
        {
         
            $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:20',
                'portal_id' => 'required|string|max:255',
                'manager_name' => 'nullable|string|max:255',
                'manager_mobile' => 'nullable|string|max:20',
        
                'today_sales_number' => 'required|integer|min:0',
                'today_sales_amount' => 'required|numeric|min:0',
        
                'total_sales_number' => 'required|integer|min:0',
                'total_sales_amount' => 'required|numeric|min:0',
            ]);

  
    $followups = [];

    if ($request->has('followup_customer_name')) {
        foreach ($request->followup_customer_name as $index => $customerName) {

            if (!empty($customerName)) {
                $followups[] = [
                    'customer_name' => $customerName,
                    'mobile' => $request->followup_mobile[$index] ?? null,
                ];
            }
        }
    }

        SalesExecutiveReport::create([
            'user_id' => auth()->id(),   
    
            'name' => $request->name,
            'mobile' => $request->mobile,
            'portal_id' => $request->portal_id,
            'manager_name' => $request->manager_name,
            'manager_mobile' => $request->manager_mobile,
    
            'today_sales_number' => $request->today_sales_number,
            'today_sales_amount' => $request->today_sales_amount,
    
            'followups' => $followups,  // Model cast karega array me
    
            'total_sales_number' => $request->total_sales_number,
            'total_sales_amount' => $request->total_sales_amount,
        ]);
    
        return redirect()
            ->route('sales-executive.list')
            ->with('success', 'Sales Executive Report Submitted Successfully');
    }


         public function salesExecutiveList(Request $request)
        {
                    $this->pageTitle = 'Sales Executive Report List';
                
                    $query = SalesExecutiveReport::query();
                
                    if (user()->role[0]['role_id'] != 1) {
                        $query->where('user_id', auth()->id());
                    }
                
                    if ($request->filled('name')) {
                        $query->where('name', 'like', '%' . $request->name . '%');
                    }
                
                    if ($request->filled('mobile')) {
                        $query->where('mobile', 'like', '%' . $request->mobile . '%');
                    }
                
                    if ($request->filled('portal_id')) {
                        $query->where('portal_id', 'like', '%' . $request->portal_id . '%');
                    }
                
                    if ($request->filled('manager_name')) {
                        $query->where('manager_name', 'like', '%' . $request->manager_name . '%');
                    }
                
                    if ($request->filled('from_date') && $request->filled('to_date')) {
                        $query->whereBetween('created_at', [
                            $request->from_date . ' 00:00:00',
                            $request->to_date . ' 23:59:59'
                        ]);
                    }
                    $this->reports = $query->latest()
                        ->paginate(10)
                        ->appends($request->all());
                
                    return view('sales-executive-list', $this->data);
                }
        
        
        
                public function downloadSalesExecutivePdf($id)
                {
                    $query = SalesExecutiveReport::where('id', $id);
                
                   
                    if (user()->role[0]['role_id'] != 1) {
                        $query->where('user_id', auth()->id());
                    }
                
                    $report = $query->firstOrFail();
                
                  
                    $followups = is_array($report->followups)
                        ? $report->followups
                        : json_decode($report->followups ?? '[]', true);
                
                    $pdf = PDF::loadView('sales-executive-pdf', [
                        'report' => $report,
                        'followups' => $followups ?? [],
                    ]);
                
                    return $pdf->download('Sales-Executive-Report-'.$report->id.'.pdf');
                }


        public function agentRetainer()
                {
                    $this->pageTitle = 'Retainer Form';
                    $this->user = user();
                
                    return view('agent_retainer', $this->data);
                }
                                
                                public function storeAgentRetainer(Request $request)
                {
                    $request->validate([
                        'name' => 'required',
                        'mobile' => 'required'
                    ]);
                
                    $agentRetainer = new AgentRetainer();
                
                    $agentRetainer->user_id = auth()->id();
                    $agentRetainer->name = $request->name;
                    $agentRetainer->mobile = $request->mobile;
                    $agentRetainer->address = $request->address;
                    $agentRetainer->gender = $request->gender;
                    $agentRetainer->date_of_birth = $request->date_of_birth;
                    $agentRetainer->marital_status = $request->marital_status;
                    $agentRetainer->person_name = $request->person_name;
                    $agentRetainer->person_mobile = $request->person_mobile;
                
                    $agentRetainer->save();
                
                    return redirect()->route('agent_retainer.list')
                        ->with('success','Data saved successfully');
                }
                
                
                
                public function listAgentRetainer(Request $request)
                {
                    $this->pageTitle = 'Retainer List';
                
                    $query = AgentRetainer::query();
                
                    // Admin sab dekhega
                    if (user()->role[0]['role_id'] != 1) {
                        $query->where('user_id', auth()->id());
                    }
                
                    // Search
                    if ($request->search) {
                        $query->where(function ($q) use ($request) {
                            $q->where('name','like','%'.$request->search.'%')
                              ->orWhere('mobile','like','%'.$request->search.'%');
                        });
                    }
                
                    // Gender Filter
                    if ($request->gender) {
                        $query->where('gender',$request->gender);
                    }
                
                    // Date Filter
                    if ($request->from_date && $request->to_date) {
                        $query->whereBetween('created_at',[
                            $request->from_date.' 00:00:00',
                            $request->to_date.' 23:59:59'
                        ]);
                    }
                
                    $this->agentRetainers = $query->latest()->paginate(10);
                
                    return view('agent_retainer_list', $this->data);
                }


        public function downloadAgentRetainerPdf($id)
        {
            $query = AgentRetainer::where('id',$id);
        
            if (user()->role[0]['role_id'] != 1) {
                $query->where('user_id',auth()->id());
            }
        
            $agent = $query->firstOrFail();
        
            $pdf = PDF::loadView('agent-retainer-pdf',[
                'agent'=>$agent
            ]);
        
            return $pdf->download('Retainer-'.$agent->id.'.pdf');
        }

        public function exportAgentRetainerExcel(Request $request)
        {
            return Excel::download(new AgentRetainerExport($request), 'agent-retainers.xlsx');
        }


    public function getList()
    {
        $hiringSubmissions = HiringSubmission::orderBy('created_at', 'desc')
            ->paginate(10);
        $this->pageTitle = 'app.menu.AgentList';
       // $this->globalSetting = GlobalSetting::first();
        return view('hiring.list', [
            ...$this->data,
            'hiringSubmissions' => $hiringSubmissions,
        ]);
        //return view('hiring.list', compact('hiringSubmissions'));
    }



    
    
}
