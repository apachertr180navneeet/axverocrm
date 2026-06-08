<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;






class NoticeController extends Controller {
   
   
 public function index(Request $request)
{
    try {
        $viewPermission = user()->permission('view_notice');

        if (!in_array($viewPermission, ['all', 'added', 'owned', 'both'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        $query = Notice::query();

        // Permission based filtering
        if ($viewPermission == 'added') {
            $query->where('added_by', user()->id);
        } elseif ($viewPermission == 'owned') {
            $query->where('user_id', user()->id);
        } elseif ($viewPermission == 'both') {
            $query->where(function ($q) {
                $q->where('added_by', user()->id)
                  ->orWhere('user_id', user()->id);
            });
        }

        $notices = $query->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Notice list fetched successfully',
            'data' => $notices
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}
    
       public function store(){
       return "create";
   } 
    
}
