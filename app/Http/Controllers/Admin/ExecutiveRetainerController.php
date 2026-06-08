<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AccountBaseController;
use App\Models\ExecutiveRetainerApplication;
use App\Models\HrExecutiveReport;
use App\Http\Requests\ExecutiveRetainerRequest;
use Illuminate\Http\Request;

class ExecutiveRetainerController extends AccountBaseController
{
    public function index(Request $request)
    {
        abort_403(!in_array('admin', user_roles()));
        $query = ExecutiveRetainerApplication::query();

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
        if ($request->filled('trashed')) {
            $query->onlyTrashed();
        }

        $applications = $query->latest()->paginate(15);
        $pageTitle = 'Executive & Retainer Applications';
        return view('admin.executive-retainer.index', array_merge($this->data, compact('applications', 'pageTitle')));
    }

    public function create()
    {
        abort_403(!in_array('admin', user_roles()));
        $executives = HrExecutiveReport::select('name', 'mobile')->distinct()->orderBy('name')->get();
        $pageTitle = 'Add Application';
        return view('admin.executive-retainer.create', array_merge($this->data, compact('executives', 'pageTitle')));
    }

    public function store(ExecutiveRetainerRequest $request)
    {
        abort_403(!in_array('admin', user_roles()));
        $txnid = 'ERT' . time() . rand(1000, 9999);

        $hiredExecutives = $this->processHiredExecutives($request);
        $hiredRetainers = $this->processHiredRetainers($request);
        $retainerDetail = $this->processRetainerDetail($request);

        ExecutiveRetainerApplication::create([
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
            'payment_status' => 'success',
            'paid_at' => now(),
        ]);

        return redirect()->route('admin.executive-retainer.index')->with('success', 'Application created.');
    }

    public function edit($id)
    {
        abort_403(!in_array('admin', user_roles()));
        $application = ExecutiveRetainerApplication::findOrFail($id);
        $executives = HrExecutiveReport::select('name', 'mobile')->distinct()->orderBy('name')->get();
        $pageTitle = 'Edit Application';
        return view('admin.executive-retainer.edit', array_merge($this->data, compact('application', 'executives', 'pageTitle')));
    }

    public function update(ExecutiveRetainerRequest $request, $id)
    {
        abort_403(!in_array('admin', user_roles()));
        $application = ExecutiveRetainerApplication::findOrFail($id);

        $hiredExecutives = $this->processHiredExecutives($request);
        $hiredRetainers = $this->processHiredRetainers($request);
        $retainerDetail = $this->processRetainerDetail($request);

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

        return redirect()->route('admin.executive-retainer.index')->with('success', 'Application updated.');
    }

    public function destroy($id)
    {
        abort_403(!in_array('admin', user_roles()));
        $application = ExecutiveRetainerApplication::findOrFail($id);
        $application->delete();
        return redirect()->route('admin.executive-retainer.index')->with('success', 'Soft deleted.');
    }

    public function restore($id)
    {
        abort_403(!in_array('admin', user_roles()));
        $application = ExecutiveRetainerApplication::withTrashed()->findOrFail($id);
        $application->restore();
        return redirect()->route('admin.executive-retainer.index')->with('success', 'Restored.');
    }

    public function forceDelete($id)
    {
        abort_403(!in_array('admin', user_roles()));
        $application = ExecutiveRetainerApplication::withTrashed()->findOrFail($id);
        $application->forceDelete();
        return redirect()->route('admin.executive-retainer.index')->with('success', 'Permanently deleted.');
    }

    private function processHiredExecutives($request)
    {
        $hired = [];
        if ($request->has('hired_executives')) {
            foreach ($request->hired_executives as $exec) {
                if (!empty($exec['name']) && !empty($exec['mobile'])) {
                    $hired[] = [
                        'name' => $exec['name'],
                        'mobile' => $exec['mobile'],
                        'joining_date' => $exec['joining_date'] ?? null,
                    ];
                }
            }
        }
        return $hired;
    }

    private function processHiredRetainers($request)   // NEW
    {
        $hired = [];
        if ($request->has('hired_retainers')) {
            foreach ($request->hired_retainers as $ret) {
                if (!empty($ret['name']) && !empty($ret['mobile'])) {
                    $hired[] = [
                        'name' => $ret['name'],
                        'mobile' => $ret['mobile'],
                        'joining_date' => $ret['joining_date'] ?? null,
                    ];
                }
            }
        }
        return $hired;
    }

    private function processRetainerDetail($request)
    {
        if ($request->post === 'Retainer' && $request->has('retainer_detail') && !empty($request->retainer_detail['name'])) {
            return [
                'name' => $request->retainer_detail['name'],
                'mobile' => $request->retainer_detail['mobile'],
                'joining_date' => $request->retainer_detail['joining_date'],
            ];
        }
        return null;
    }
}