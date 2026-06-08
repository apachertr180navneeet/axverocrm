<?php

namespace App\Http\Controllers;

use App\Models\ExecutiveRetainerApplication;
use Illuminate\Http\Request;

class ExecutiveRetainerPaymentController extends Controller
{
    public function paymentSuccess(Request $request)
    {
        $application = ExecutiveRetainerApplication::where('txnid', $request->txnid)->firstOrFail();

        if ($application->payment_status !== 'success') {
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

            $application->update([
                'payment_status' => 'success',
                'payu_response' => $request->all(),
                'paid_at' => now(),
            ]);
        }

        return view('executive-retainer.payment-result', [
            'pageTitle' => 'Payment Successful',
            'status' => 'success',
            'heading' => 'Payment Successful!',
            'message' => 'Your Executive Retainer application #' . $application->id . ' has been submitted successfully.',
            'redirectUrl' => route('executive-retainer.my-applications'),
        ]);
    }

    public function paymentFailure(Request $request)
    {
        $application = ExecutiveRetainerApplication::where('txnid', $request->txnid)->first();
        if ($application) {
            $application->update([
                'payment_status' => 'failed',
                'payu_response' => $request->all(),
            ]);
        }

        return view('executive-retainer.payment-result', [
            'pageTitle' => 'Payment Failed',
            'status' => 'failure',
            'heading' => 'Payment Failed',
            'message' => 'Your payment could not be processed. Please try again or contact support.',
            'redirectUrl' => route('executive-retainer.create'),
        ]);
    }
}
