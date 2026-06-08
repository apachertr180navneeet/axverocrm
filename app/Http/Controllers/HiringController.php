<?php

namespace App\Http\Controllers;

use App\Models\HiringSubmission;
use App\Models\HrExecutiveReport;
use App\Models\RelationshipManagerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Payment\PayuController;
use App\Models\GlobalSetting;

class HiringController extends Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->pageTitle = 'app.menu.hiring';
    // }
    public function create()
    {
        // $user = Auth::user();
        // if (!$user) {
        //     return redirect()->route('login')->with('error', 'Please login first');
        // }
        // No longer fetch dropdown data
        // return view('hiring.create', compact('user'));
        // $this->pageTitle = __('app.menu.hiring');
        // return view('hiring.create', [
        //     ...$this->data,
        //     //'user' => $user,
        // ]);
         $this->globalSetting = GlobalSetting::first();

        return view('hiring.create', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:advance_income_applications,mobile',
            'email' => 'required|email|unique:advance_income_applications,email',
            'address' => 'nullable|string',
            'pancard_number' => 'required|string|max:10|unique:advance_income_applications,pancard_number',
            'pancard_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'expected_date' => 'nullable|date',
            'referred_executive_name' => 'nullable|string',
            'referred_executive_mobile' => 'nullable|string',
            'relationship_manager_name' => 'nullable|string',
            'relationship_manager_mobile' => 'nullable|string|max:20',
            'terms_accepted' => 'required|accepted',
        ]);

       // $user = Auth::user();

        // Store PAN card image
        $panImagePath = $request->file('pancard_image')->store('pancards', 'public');

        //$txnid = 'ADI' . time() . rand(1000, 9999);
        $txnid = Str::uuid()->toString();

        $submission = HiringSubmission::create([
           // 'user_id' => $user->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'pancard_number' => $request->pancard_number,
            'pancard_image' => $panImagePath,
            'referred_executive_name' => $request->referred_executive_name,
            'referred_executive_mobile' => $request->referred_executive_mobile,
            'relationship_manager_name' => $request->relationship_manager_name,
            // relationship_manager_mobile removed
            'hiring_work_details' => [], // empty array
            'txnid' => $txnid,
            'amount' => 91,
            'terms_accepted' => true,
            'payment_status' => 'pending',
            'submitted_at' => now(),
            'expected_date' => $request->expected_date,
        ]);

        return app(PayuController::class)->redirectToPayu($submission);
    }

    public function paymentSuccess(Request $request)
    {
        $submission = HiringSubmission::where('txnid', $request->txnid)->firstOrFail();

        if ($submission->payment_status === 'success') {
            return view('hiring.success', ['hiring' => $submission]);
        }

        $key = config('services.payu.key');
        $salt = config('services.payu.salt');

        $hashString = $salt . '|' . $request->status . '|||||||||||' .
            $request->email . '|' . $request->firstname . '|' .
            $request->productinfo . '|' . $request->amount . '|' .
            $request->txnid . '|' . $key;

        $calculatedHash = strtolower(hash('sha512', $hashString));

        if ($calculatedHash !== $request->hash) {
            abort(403, 'Invalid hash');
        }

        $submission->update([
            'payment_status' => 'success',
            'payu_response' => $request->all(),
            'paid_at' => now(),
        ]);

        return view('hiring.success', ['hiring' => $submission]);
    }

    public function paymentFailure(Request $request)
    {
        $submission = HiringSubmission::where('txnid', $request->txnid)->first();
        if ($submission) {
            $submission->update([
                'payment_status' => 'failed',
                'payu_response' => $request->all(),
            ]);
        }
        return view('hiring.failure', ['submission' => $submission]);
    }

    public function myApplications()
    {
        $applications = HiringSubmission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('hiring.my_applications', compact('applications'));
    }
    
    public function getList()
    {
        $hiringSubmissions = HiringSubmission::orderBy('created_at', 'desc')
            ->paginate(10);
        $this->pageTitle = 'app.menu.AgentList';
        $this->globalSetting = GlobalSetting::first();
        return view('hiring.list', [
            ...$this->data,
            'hiringSubmissions' => $hiringSubmissions,
        ]);
        //return view('hiring.list', compact('hiringSubmissions'));
    }

    public function success($id)
    {
        $hiring = HiringSubmission::findOrFail($id);
        return view('hiring.success', compact('hiring'));
    }
}