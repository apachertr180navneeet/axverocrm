<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesExecutiveReport;
use Illuminate\Support\Facades\Validator;


class SalesExecutiveReportController extends Controller{
    
               public function reportList()
            {
                $user = Auth::user();
            
               
            
                    $reports = SalesExecutiveReport::where('user_id', $user->id)
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
        'name' => 'required|string|max:255',
        'mobile' => 'required|string|max:20',
        'portal_id' => 'required|string|max:255',

        'today_sales_number' => 'required|integer|min:0',
        'today_sales_amount' => 'required|numeric|min:0',

        'total_sales_number' => 'required|integer|min:0',
        'total_sales_amount' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422);
    }

    try {

        // ================= Followups =================
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

        // ================= Save =================
        $report = SalesExecutiveReport::create([
            'user_id' => auth()->id(),

            'name' => $request->name,
            'mobile' => $request->mobile,
            'portal_id' => $request->portal_id,
            'manager_name' => $request->manager_name,
            'manager_mobile' => $request->manager_mobile,

            'today_sales_number' => $request->today_sales_number,
            'today_sales_amount' => $request->today_sales_amount,

            'followups' => $followups,

            'total_sales_number' => $request->total_sales_number,
            'total_sales_amount' => $request->total_sales_amount,
        ]);

      
        return response()->json([
            'status' => true,
            'message' => 'Sales Executive Report Submitted Successfully',
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