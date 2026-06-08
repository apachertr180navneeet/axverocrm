<?php

namespace App\Http\Controllers;

use App\Models\Hiring;
use App\Models\User;
use App\Mail\PaymentSuccessMail;
use App\Mail\PaymentPendingMail;
use App\Mail\PaymentFailedMail;
use App\Mail\PaymentRejectedMail;
use App\Models\HiringSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Payment\PayuController;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HiringController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.hiring';
    }
    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        $userData = [
            'name' => $user->name,
            'mobile' => $user->mobile ?? '',
            'portal_email' => $user->email,
            'designation' => $user->designation ?? '',
            'department' => $user->department ?? '',
            'senior_manager_name' => $user->senior_manager_name ?? '',
            'senior_manager_mobile' => $user->senior_manager_mobile ?? '',
        ];
        $this->pageTitle = __('app.menu.hiring');
        return view('hiring.create', [
            ...$this->data,
            'userData' => $userData,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $user = Auth::user();

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'mobile' => 'required|string|max:20',
    //         'portal_email' => 'required|email',
    //         'joining_date' => 'required|date',
    //         'designation' => 'required|string',
    //         'department' => 'required|string',
    //         'senior_manager_name' => 'required|string',
    //         'senior_manager_mobile' => 'required|string',
    //         'advance_amount' => 'required|numeric|min:0',
    //         'terms_accepted' => 'accepted',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Create hiring record
    //     $hiring = Hiring::create([
    //         'user_id' => $user->id,
    //         'name' => $request->name,
    //         'mobile' => $request->mobile,
    //         'portal_email' => $request->portal_email,
    //         'joining_date' => $request->joining_date,
    //         'designation' => $request->designation,
    //         'department' => $request->department,
    //         'senior_manager_name' => $request->senior_manager_name,
    //         'senior_manager_mobile' => $request->senior_manager_mobile,
    //         'hiring_work_details' => $request->hiring_work_details ?? [],
    //         'advance_amount' => $request->advance_amount,
    //         'terms_accepted' => true,
    //         'payment_status' => 'pending',
    //     ]);

    //     // If amount is zero, skip payment
    //     if ($request->advance_amount <= 0) {
    //         $hiring->update(['payment_status' => 'paid']);
    //         Mail::to($user->email)->send(new PaymentSuccessMail($hiring, $user));
    //         return redirect()->route('hiring.success', $hiring->id);
    //     }

    //     // Prepare PayU data with CORRECT hash generation
    //     $payuData = $this->preparePayUData($hiring, $request);

    //     // Log for debugging
    //     Log::info('PayU Request Data:', $payuData);

    //     return view('hiring.payu_redirect', compact('payuData'));
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:20',
                'portal_email' => 'required|email',
                'joining_date' => 'required|date',
                'designation' => 'required|string',
                'department' => 'required|string',
                'senior_manager_name' => 'required|string',
                'senior_manager_mobile' => 'required|string|max:20',
                'hiring_work_details' => 'nullable|array',
                'terms_accepted' => 'required|accepted'
            ], [
                'terms_accepted.required' => 'You must accept the Terms and Conditions to proceed.',
                'terms_accepted.accepted' => 'Please check the Terms and Conditions box.'
            ]);

            $user = auth()->user();

            // Prevent duplicate submission
            $existing = HiringSubmission::where('user_id', $user->id)
                ->where('payment_status', 'success')
                ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Already submitted and paid.');
            }

            $txnid = Str::uuid()->toString();

            // Process hiring work details
            $hiringWorkDetails = [];
            if ($request->has('hiring_work_details')) {
                foreach ($request->hiring_work_details as $detail) {
                    if (!empty($detail['name']) || !empty($detail['mobile']) || !empty($detail['portal_email'])) {
                        $hiringWorkDetails[] = [
                            'name' => $detail['name'] ?? '',
                            'mobile' => $detail['mobile'] ?? '',
                            'portal_email' => $detail['portal_email'] ?? '',
                            'joining_date' => $detail['joining_date'] ?? null
                        ];
                    }
                }
            }

            $submission = HiringSubmission::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->portal_email,
                'joining_date' => $request->joining_date,
                'designation' => $request->designation,
                'department' => $request->department,
                'senior_manager_name' => $request->senior_manager_name,
                'senior_manager_mobile' => $request->senior_manager_mobile,
                'hiring_work_details' => $hiringWorkDetails,
                'txnid' => $txnid,
                'amount' => config('services.payu.amount'),
                'terms_accepted' => true,
                'submitted_at' => now(),
                'payment_status' => 'pending'
            ]);
            DB::commit();
            // Redirect to PayU
            return app(PayuController::class)->redirectToPayu($submission);

        } catch (\Throwable $th) {
             DB::rollBack();
            Log::error('Store error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function getList(Request $request){

        abort_403(!in_array('client', user_roles()));
         // ========== PAYU HIRING DATA FILTERS ==========
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

        $hiringSubmissions = $query->orderBy('created_at', 'desc')->paginate(20);
        $this->pageTitle = __('app.menu.advanceIncome');
        return view('hiring.list', [
            ...$this->data,
            'hiringSubmissions' => $hiringSubmissions,
        ]);
    }

        // ========== EXPORT PAYU TO EXCEL ==========
    public function exportPayuExcel(Request $request)
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

        $filename = 'payu_applications_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Headers
        fputcsv($output, [
            'S.No',
            'ID',
            'Name',
            'Mobile',
            'Email',
            'Joining Date',
            'Designation',
            'Department',
            'Senior Manager',
            'Senior Manager Mobile',
            'Amount',
            'Payment Status',
            'Transaction ID',
            'Submitted Date'
        ]);

        $sno = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $sno++,
                $row->id,
                $row->name,
                $row->mobile,
                $row->email,
                $row->joining_date ? date('d-m-Y', strtotime($row->joining_date)) : '-',
                $row->designation,
                $row->department,
                $row->senior_manager_name,
                $row->senior_manager_mobile,
                $row->amount,
                strtoupper($row->payment_status),
                $row->txnid,
                $row->created_at ? date('d-m-Y H:i:s', strtotime($row->created_at)) : '-'
            ]);
        }

        fclose($output);
        exit();
    }

    // ========== EXPORT PAYU TO PDF ==========
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

    // private function preparePayUData($hiring, $request)
    // {
    //     $merchantKey = env('PAYU_MERCHANT_KEY');
    //     $merchantSalt = env('PAYU_MERCHANT_SALT');

    //     // Generate unique transaction ID
    //     $txnid = 'HIR' . time() . rand(1000, 9999);
    //     $amount = number_format($request->advance_amount, 2, '.', '');

    //     // Save transaction ID
    //     $hiring->update(['order_id' => $txnid]);

    //     // Product info (max 100 chars)
    //     $productInfo = substr("Hiring Fee - " . $request->designation, 0, 100);

    //     // UDF fields (all 5 fields must be present even if empty)
    //     $udf1 = (string) $hiring->id;
    //     $udf2 = '';
    //     $udf3 = '';
    //     $udf4 = '';
    //     $udf5 = '';

    //     // IMPORTANT: Correct hash string format - exactly as per PayU documentation
    //     $hashString = $merchantKey . '|'
    //         . $txnid . '|'
    //         . $amount . '|'
    //         . $productInfo . '|'
    //         . $request->name . '|'
    //         . $request->portal_email . '|'
    //         . $udf1 . '|'
    //         . $udf2 . '|'
    //         . $udf3 . '|'
    //         . $udf4 . '|'
    //         . $udf5 . '||||||'
    //         . $merchantSalt;

    //     // Generate hash - MUST be lowercase SHA512
    //     $hash = hash('sha512', $hashString);

    //     // Success and Failure URLs
    //     $surl = route('hiring.payment.success');
    //     $furl = route('hiring.payment.failure');

    //     // Log for debugging
    //     Log::info('========== PAYU HASH DETAILS ==========');
    //     Log::info('Hash String: ' . $hashString);
    //     Log::info('Generated Hash: ' . $hash);
    //     Log::info('Hash Length: ' . strlen($hash));
    //     Log::info('=======================================');

    //     return [
    //         'key' => $merchantKey,
    //         'txnid' => $txnid,
    //         'amount' => $amount,
    //         'productinfo' => $productInfo,
    //         'firstname' => $request->name,
    //         'email' => $request->portal_email,
    //         'phone' => $request->mobile,
    //         'surl' => $surl,
    //         'furl' => $furl,
    //         'hash' => $hash,
    //         'udf1' => $udf1,
    //         'udf2' => $udf2,
    //         'udf3' => $udf3,
    //         'udf4' => $udf4,
    //         'udf5' => $udf5,
    //         'service_provider' => 'payu_paisa'
    //     ];
    // }

    // public function paymentSuccess(Request $request)
    // {
    //     Log::info('PayU Success Callback:', $request->all());

    //     $hiring = Hiring::find($request->udf1);
    //     if (!$hiring) {
    //         Log::error('Hiring not found for UDF1: ' . $request->udf1);
    //         return redirect()->route('hiring.create')->with('error', 'Application not found');
    //     }

    //     $user = User::find($hiring->user_id);

    //     if ($request->status == 'success') {
    //         $hiring->update([
    //             'payment_status' => 'paid',
    //             'payment_id' => $request->mihpayid,
    //             'payment_completed_at' => now(),
    //             'payment_response' => json_encode($request->all())
    //         ]);

    //         // Send success email
    //         Mail::to($user->email)->send(new PaymentSuccessMail($hiring, $user));

    //         return redirect()->route('hiring.success', $hiring->id)->with('success', 'Payment successful!');
    //     }

    //     return redirect()->route('hiring.create')->with('error', 'Payment failed');
    // }

    // public function paymentFailure(Request $request)
    // {
    //     Log::error('PayU Failure Callback:', $request->all());

    //     $hiring = Hiring::find($request->udf1);
    //     if ($hiring) {
    //         $user = User::find($hiring->user_id);
    //         $status = 'failed';

    //         if (isset($request->unmappedstatus) && $request->unmappedstatus == 'user_cancelled') {
    //             $status = 'rejected';
    //             Mail::to($user->email)->send(new PaymentRejectedMail($hiring, $user));
    //         } else {
    //             Mail::to($user->email)->send(new PaymentFailedMail($hiring, $user));
    //         }

    //         $hiring->update([
    //             'payment_status' => $status,
    //             'payment_response' => json_encode($request->all())
    //         ]);
    //     }

    //     return redirect()->route('hiring.create')->with('error', 'Payment failed. Please try again.');
    // }

    // public function paymentCancel(Request $request)
    // {
    //     Log::info('PayU Cancel Callback:', $request->all());

    //     $hiring = Hiring::find($request->udf1);
    //     if ($hiring) {
    //         $hiring->update(['payment_status' => 'rejected']);
    //         $user = User::find($hiring->user_id);
    //         Mail::to($user->email)->send(new PaymentRejectedMail($hiring, $user));
    //     }

    //     return redirect()->route('hiring.create')->with('warning', 'Payment cancelled by user');
    // }

    // public function payUPending(Request $request)
    // {
    //     Log::info('PayU Pending Callback:', $request->all());

    //     $hiring = Hiring::find($request->udf1);
    //     if ($hiring) {
    //         $hiring->update(['payment_status' => 'pending']);
    //         $user = User::find($hiring->user_id);
    //         Mail::to($user->email)->send(new PaymentPendingMail($hiring, $user));
    //     }

    //     return response()->json(['status' => 'success']);
    // }

    // public function success($id)
    // {
    //     $hiring = Hiring::findOrFail($id);
    //     return view('hiring.success', compact('hiring'));
    // }

    // public function myApplications()
    // {
    //     $applications = Hiring::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
    //     return view('hiring.my_applications', compact('applications'));
    // }

    // public function checkStatus($id)
    // {
    //     $hiring = Hiring::findOrFail($id);
    //     return response()->json([
    //         'id' => $hiring->id,
    //         'payment_status' => $hiring->payment_status,
    //         'payment_id' => $hiring->payment_id,
    //         'amount' => $hiring->advance_amount
    //     ]);
    // }


}