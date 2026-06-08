<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refference;
use PDF;

class RefferenceController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    // ── Show Form ─────────────────────────────────────────────
    public function create()
    {
        $this->pageTitle = 'Reference Form';
        $this->user      = user();
        return view('refference.create', $this->data);
    }

    // ── Store ─────────────────────────────────────────────────


public function store(Request $request)
{
    $request->validate([
        'candidate_name'     => 'required|array|min:1',
        'candidate_name.*'   => 'required|string|max:100',
        'candidate_mobile'   => 'required|array|min:1',
        'candidate_mobile.*' => 'required|digits:10',
        'candidate_gender'   => 'required|array|min:1',
        'candidate_gender.*' => 'required|in:Male,Female,Other',
    ]);

    $user = user();

    $candidates = [];

    // 🔥 LOOP (as per your form)
    foreach ($request->candidate_name as $i => $name) {
        $candidates[] = [
            'name'   => $name,
            'mobile' => $request->candidate_mobile[$i],
            'gender' => $request->candidate_gender[$i],
        ];
    }

    // 🔥 SINGLE SAVE (JSON)
    Refference::create([
        'user_id'       => $user->id,
        'portal_id'     =>$request->portal_id,
        'senior_name'   => $request->senior_name,
        'senior_mobile' => $request->senior_mobile,
        'candidates'    => json_encode($candidates),
    ]);

 return redirect()->route('refference.list')->with('success', 'Saved successfully!');
}

    // ── List ──────────────────────────────────────────────────
    // ── List ──────────────────────────────────────────────
// ── List ──────────────────────────────────────────────
public function list(Request $request)
{
    $this->pageTitle = 'Reference List';

    $query = Refference::query();

    // Role-based scope
    if (user()->role[0]['role_id'] != 1) {
        $query->where('user_id', user()->id);
    }

    // Single search — matches senior name OR candidate name (JSON)
    if ($request->filled('search')) {
        $term = $request->search;
        $query->where(function ($q) use ($term) {
            $q->where('senior_name', 'like', '%' . $term . '%')
              ->orWhere('candidates',  'like', '%' . $term . '%');
        });
    }

    $this->refferences = $query->latest()->paginate(10)->appends($request->all());

    // AJAX → return only the partial table
        // AJAX → return only the partial table
    if ($request->ajax()) {
        return view('refference.list_table', $this->data);  // ✅
    }
    
    return view('refference.list', $this->data);
 }

    // ── PDF Download ──────────────────────────────────────────
    public function pdf($id)
    {
        $query = Refference::where('id', $id);

        if (user()->role[0]['role_id'] != 1) {
            $query->where('portal_id', user()->id);
        }

        $refference = $query->firstOrFail();

        $pdf = PDF::loadView('refference.pdf', compact('refference'));

        return $pdf->download('Reference-' . $refference->id . '.pdf');
    }
}