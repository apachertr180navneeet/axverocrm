<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Holiday;


class HolidayController extends Controller{

       public function index(Request $request)
{
    $viewPermission = user()->permission('view_holiday');

    if (!in_array($viewPermission, ['all', 'added', 'owned', 'both'])) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 403);
    }

    $holidays = Holiday::orderBy('date', 'ASC');

   
    if ($request->filled('searchText')) {
        $holidays->where('occassion', 'like', '%' . $request->searchText . '%');
    }

 

  
    if ($request->filled('start') && $request->filled('end')) {
        $holidays->whereBetween('date', [$request->start, $request->end]);
    }

    $holidays = $holidays->get();

   
    $data = $holidays->map(function ($holiday) {
        return [
            'id' => $holiday->id,
            'title' => $holiday->occassion,
            'date' => $holiday->date->format('Y-m-d'),
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'All holidays fetched successfully',
        'data' => $data
    ]);
}
    
}