<?php

namespace App\Http\Controllers;

use App\Models\ExecutiveRetainerApplication;
use App\Models\HrExecutiveReport;
use App\Http\Requests\ExecutiveRetainerRequest;

class ExecutiveRetainerController extends AccountBaseController
{
    public function create()
    {
        abort_403(!in_array('employee', user_roles()));
        $executives = HrExecutiveReport::select('name', 'mobile')->distinct()->orderBy('name')->get();
        $pageTitle = __('app.menu.applyExecutiveRetainer');
        return view('executive-retainer.create', array_merge($this->data, compact('executives', 'pageTitle')));
    }

    public function store(ExecutiveRetainerRequest $request)
    {
        abort_403(!in_array('employee', user_roles()));
        $txnid = 'ERT' . time() . rand(1000, 9999);

        // Process hired executives (max 4)
        $hiredExecutives = [];
        if ($request->has('hired_executives')) {
            foreach ($request->hired_executives as $exec) {
                if (!empty($exec['name']) && !empty($exec['mobile'])) {
                    $hiredExecutives[] = [
                        'name' => $exec['name'],
                        'mobile' => $exec['mobile'],
                        'joining_date' => $exec['joining_date'] ?? null,
                    ];
                }
            }
        }

        // Process hired retainers (max 4) – NEW
        $hiredRetainers = [];
        if ($request->has('hired_retainers')) {
            foreach ($request->hired_retainers as $ret) {
                if (!empty($ret['name']) && !empty($ret['mobile'])) {
                    $hiredRetainers[] = [
                        'name' => $ret['name'],
                        'mobile' => $ret['mobile'],
                        'joining_date' => $ret['joining_date'] ?? null,
                    ];
                }
            }
        }

        // Process single retainer detail (for "Retainer" post)
        $retainerDetail = null;
        if ($request->post === 'Retainer' && $request->has('retainer_detail')) {
            $retainerDetail = [
                'name' => $request->retainer_detail['name'],
                'mobile' => $request->retainer_detail['mobile'],
                'joining_date' => $request->retainer_detail['joining_date'],
            ];
        }

        $application = ExecutiveRetainerApplication::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'post' => $request->post,
            'date_of_joining' => $request->date_of_joining,
            'hired_executives' => $hiredExecutives,
            'hired_retainers' => $hiredRetainers,
            'retainer_detail' => $retainerDetail,
            'txnid' => $txnid,
            'amount' => 299,
            'payment_status' => 'pending',
        ]);

        return $this->redirectToPayU($application);
    }

    private function redirectToPayU($application)
    {
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        $user = auth()->user();

        $hashString = $key . '|' . $application->txnid . '|' . $application->amount . '|Executive Retainer Fee|' .
            $user->name . '|' . $user->email . '|||||||||||' . $salt;

        $hash = strtolower(hash('sha512', $hashString));

        return view('executive-retainer.payu_redirect', array_merge($this->data, [
            'application' => $application,
            'user' => $user,
            'hash' => $hash,
            'key' => $key,
        ]));
    }

    public function myApplications()
    {
        abort_403(!in_array('employee', user_roles()));
        $applications = ExecutiveRetainerApplication::where('mobile', auth()->user()->mobile)
            ->orWhere('email', auth()->user()->email)
            ->latest()->paginate(10);
        return view('executive-retainer.my-applications', array_merge($this->data, compact('applications') + ['pageTitle' => 'My Applications']));
    }
}