<?php

namespace App\Http\Controllers;

use App\Models\HiringSubmission;
use App\Models\HrExecutiveReport;
use App\Models\RelationshipManagerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Payment\PayuController;
use App\Exports\PayuApplicationExport;
use App\Models\GlobalSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class HiringController extends Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->pageTitle = 'app.menu.hiring';
    // }
    public function create()
    {
         $this->globalSetting = GlobalSetting::first();

        return view('hiring.create', $this->data);
    }


    public function retainercreate()
    {
         $this->globalSetting = GlobalSetting::first();

        return view('retainer.create', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:advance_income_applications,mobile',
            'email' => 'required|email|unique:advance_income_applications,email',
            'address' => 'nullable|string',
            'expected_date' => 'nullable|date',
            'referred_executive_name' => 'nullable|string',
            'referred_executive_mobile' => 'nullable|string',
            'terms_accepted' => 'required|accepted',
        ]);

        $txnid = Str::uuid()->toString();

        $submission = HiringSubmission::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'referred_executive_name' => $request->referred_executive_name,
            'referred_executive_mobile' => $request->referred_executive_mobile,
            'hiring_work_details' => [],
            'txnid' => $txnid,
            'amount' => 20,
            'terms_accepted' => true,
            'payment_status' => 'success',
            'submitted_at' => now(),
            'expected_date' => $request->expected_date,
            'submit_type' => 'agent'
        ]);

        // return app(PayuController::class)->redirectToPayu($submission);
        return view('hiring.success', ['hiring' => $submission]);
    }


    public function retainerstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:advance_income_applications,mobile',
            'email' => 'required|email|unique:advance_income_applications,email',
            'address' => 'nullable|string',
            'expected_date' => 'nullable|date',
            'referred_executive_name' => 'nullable|string',
            'referred_executive_mobile' => 'nullable|string',
            'terms_accepted' => 'required|accepted',
        ]);

        //$txnid = 'ADI' . time() . rand(1000, 9999);
        $txnid = Str::uuid()->toString();

        $submission = HiringSubmission::create([
           // 'user_id' => $user->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'referred_executive_name' => $request->referred_executive_name,
            'referred_executive_mobile' => $request->referred_executive_mobile,
            // relationship_manager_mobile removed
            'hiring_work_details' => [], // empty array
            'txnid' => $txnid,
            'amount' => 399,
            'terms_accepted' => true,
            'payment_status' => 'pending',
            'submitted_at' => now(),
            'expected_date' => $request->expected_date,
            'submit_type' => 'retaner'
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

    public function exportPayuPdf(Request $request)
    {
        $search = $request->input('search');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $paymentStatus = $request->input('payment_status');

        $query = HiringSubmission::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('txnid', 'LIKE', "%{$search}%");
            });
        }

        if ($fromDate) {
            $query->whereDate('submitted_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('submitted_at', '<=', $toDate);
        }

        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('hiring.pdf.payu_report', compact('data', 'search', 'fromDate', 'toDate', 'paymentStatus'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('payu_applications_' . date('Y-m-d') . '.pdf');
    }

    public function exportPayuExcel(Request $request)
    {
        return Excel::download(new PayuApplicationExport($request), 'payu_applications_' . date('Y-m-d') . '.xlsx');
    }
}