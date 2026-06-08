<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HrExecutiveReport;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class HrExecutiveReportController extends Controller{
    
      public function reportList()
            {
                $user = Auth::user();
            
               
            
                    $reports = HrExecutiveReport::where('user_id', $user->id)
                                          ->latest()
                                          ->get();
            
                return response()->json([
                    'status' => true,
                    'message' => 'Hr Report list fetched successfully',
                    'data' => $reports
                ], 200);
            }
    


        public function reportCreate(Request $request)
        {
          
            $validator = Validator::make($request->all(), [
                'report_date' => 'required',
                'name' => 'required|string',
                'mobile' => 'required'
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }
        
            try {
        
                // ================= Selected Persons =================
                $selectedPersons = [];
        
                if (!empty($request->selected_person_name)) {
                    foreach ($request->selected_person_name as $i => $val) {
                        $selectedPersons[] = [
                            'name'   => $request->selected_person_name[$i] ?? null,
                            'mobile' => $request->selected_mobile[$i] ?? null,
                            'email'  => $request->selected_email[$i] ?? null,
                            'designation' => $request->selected_designation[$i] ?? null,
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
        
                // ================= Save Report =================
                $report = new HrExecutiveReport();
        
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
        
               
                return response()->json([
                    'status' => true,
                    'message' => 'Executive Report Saved Successfully',
                    'data' => $report
                ], 201);
        
            } catch (\Exception $e) {
        
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    
    
}