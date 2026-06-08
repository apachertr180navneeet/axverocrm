<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Validator;


class ReportManagerController extends Controller{
    
               public function reportList()
            {
                $user = Auth::user();
            
               
            
                    $reports = DailyReport::where('user_id', $user->id)
                                          ->latest()
                                          ->get();
            
                return response()->json([
                    'status' => true,
                    'message' => 'Report list fetched successfully',
                    'data' => $reports
                ], 200);
            }
    
    
           public function reportCreate(Request $request)
        {
            
            $validator = Validator::make($request->all(), [
                'report_date' => 'required|date',
                'name' => 'required|string',
                'mobile' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }
        
        
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
                        'designation' => $request->designation[$i] ?? null,
                        'joining_date' => $request->joining_date[$i] ?? null,
                    ];
                }
            }
        
           
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
        
          
            return response()->json([
                'status' => true,
                'message' => 'Record Saved Successfully',
                'data' => $report
            ], 201);
}

}