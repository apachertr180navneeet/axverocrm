<?php

namespace App\Http\Controllers;

use App\Models\ExecutiveRetainerApplication;
use App\Models\HrExecutiveReport;
use App\Http\Requests\ExecutiveRetainerRequest;
use Illuminate\Http\Request;

class ExecutiveRetainerController extends AccountBaseController
{
    public function index(Request $request)
    {
        abort_403(!in_array('employee', user_roles()));
        $query = ExecutiveRetainerApplication::where('mobile', auth()->user()->mobile)
            ->orWhere('email', auth()->user()->email);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->filled('post')) {
            $query->where('post', $request->post);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $applications = $query->latest()->paginate(15);
        $pageTitle = 'Advance Income Form';

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('payment_status', 'pending')->count(),
            'success' => (clone $query)->where('payment_status', 'success')->count(),
            'failed' => (clone $query)->where('payment_status', 'failed')->count(),
        ];

        return view('executive-retainer.index', array_merge($this->data, compact('applications', 'pageTitle', 'stats')));
    }

    public function create()
    {
        abort_403(!in_array('employee', user_roles()));
        $executives = HrExecutiveReport::select('name', 'mobile')->distinct()->orderBy('name')->get();
        $pageTitle = 'Advance Income Form';
        return view('executive-retainer.create', array_merge($this->data, compact('executives', 'pageTitle')));
    }

    public function store(ExecutiveRetainerRequest $request)
    {
        abort_403(!in_array('employee', user_roles()));
        $txnid = 'ERT' . time() . rand(1000, 9999);

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

    public function show($id)
    {
        abort_403(!in_array('employee', user_roles()));
        $application = ExecutiveRetainerApplication::where('mobile', auth()->user()->mobile)
            ->orWhere('email', auth()->user()->email)
            ->findOrFail($id);
        $pageTitle = __('app.applicationDetails');
        return view('executive-retainer.show', array_merge($this->data, compact('application', 'pageTitle')));
    }

    public function edit($id)
    {
        abort_403(!in_array('employee', user_roles()));
        $application = ExecutiveRetainerApplication::where('mobile', auth()->user()->mobile)
            ->orWhere('email', auth()->user()->email)
            ->findOrFail($id);
        $executives = HrExecutiveReport::select('name', 'mobile')->distinct()->orderBy('name')->get();
        $pageTitle = 'Edit Application';
        return view('executive-retainer.edit', array_merge($this->data, compact('application', 'executives', 'pageTitle')));
    }

    public function update(ExecutiveRetainerRequest $request, $id)
    {
        abort_403(!in_array('employee', user_roles()));
        $application = ExecutiveRetainerApplication::where('mobile', auth()->user()->mobile)
            ->orWhere('email', auth()->user()->email)
            ->findOrFail($id);

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

        $retainerDetail = null;
        if ($request->post === 'Retainer' && $request->has('retainer_detail')) {
            $retainerDetail = [
                'name' => $request->retainer_detail['name'],
                'mobile' => $request->retainer_detail['mobile'],
                'joining_date' => $request->retainer_detail['joining_date'],
            ];
        }

        $application->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'post' => $request->post,
            'date_of_joining' => $request->date_of_joining,
            'hired_executives' => $hiredExecutives,
            'hired_retainers' => $hiredRetainers,
            'retainer_detail' => $retainerDetail,
        ]);

        return redirect()->route('executive-retainer.index')->with('success', 'Application updated.');
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
}
