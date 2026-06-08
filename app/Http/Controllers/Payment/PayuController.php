<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\HiringSubmission;
use Illuminate\Http\Request;

class PayuController extends Controller
{
    public function redirectToPayu($submission)
    {
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        $user = $submission;
        $hashString = $key . '|' . $submission->txnid . '|' . $submission->amount . '|Form Payment|' .
            $user->name . '|' . $user->email . '|||||||||||' . $salt;

        $hash = strtolower(hash('sha512', $hashString));

        return view('hiring.payu_redirect', [
            'submission' => $submission,
            'user' => $user,
            'hash' => $hash,
            'key' => $key,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $submission = HiringSubmission::where('txnid', $request->txnid)->first();

        if (!$submission) {
            abort(404);
        }

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

        return view('payu.failure', ['submission' => $submission]);
    }

    public function redirectForAdvanceIncome($submission)
    {
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        $user = $submission;
        $hashString = $key . '|' . $submission->txnid . '|' . $submission->amount . '|Advance Income Fee|' .
            $user->name . '|' . $user->email . '|||||||||||' . $salt;

        $hash = strtolower(hash('sha512', $hashString));

        return view('hiring.payu_redirect', [
            'submission' => $submission,
            'user' => $user,
            'hash' => $hash,
            'key' => $key,
        ]);
    }
}