<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Refference;





class Refferencecontroller extends Controller {
   
  
  public function index(Request $request)
{
    try {

        $query = Refference::query();

   
        if (user()->role[0]['role_id'] != 1) {
            $query->where('user_id', user()->id);
        }

    
        if ($request->filled('search')) {
            $term = $request->search;

            $query->where(function ($q) use ($term) {
                $q->where('senior_name', 'like', "%$term%")
                  ->orWhere('candidates', 'like', "%$term%");
            });
        }

        $references = $query->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Reference list fetched successfully',
            'data' => $references
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
}
  
  
  
   
public function store(Request $request)
{
    try {

        $validator = \Validator::make($request->all(), [
            'candidate_name'     => 'required|array|min:1',
            'candidate_name.*'   => 'required|string|max:100',

            'candidate_mobile'   => 'required|array|min:1',
            'candidate_mobile.*' => 'required|digits:10|distinct',

            'candidate_gender'   => 'required|array|min:1',
            'candidate_gender.*' => 'required|in:Male,Female,Other',

            'portal_id'          => 'required|numeric',
            'senior_name'        => 'nullable|string|max:100',
            'senior_mobile'      => 'nullable|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = user();

        $candidates = [];

        foreach ($request->candidate_name as $i => $name) {
            $candidates[] = [
                'name'   => $name,
                'mobile' => $request->candidate_mobile[$i],
                'gender' => $request->candidate_gender[$i],
            ];
        }

        $reference = Refference::create([
            'user_id'       => $user->id,
            'portal_id'     => $request->portal_id,
            'senior_name'   => $request->senior_name ?? $user->name,
            'senior_mobile' => $request->senior_mobile ?? $user->mobile,
            'candidates'    => json_encode($candidates),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reference saved successfully',
            'data' => $reference
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
