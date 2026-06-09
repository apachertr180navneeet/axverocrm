@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('content')
<div class="content-wrapper">
    @php $app = $application; @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <x-app-title class="d-block d-lg-none" :pageTitle="$pageTitle"></x-app-title>
        <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block">{{ $pageTitle }} #{{ $app->id }}</h4>
        <div class="d-flex">
            <a href="{{ route('executive-retainer.edit', $app->id) }}" class="btn btn-primary rounded f-14 p-2 mr-2">
                <i class="fa fa-edit mr-1"></i> @lang('app.edit')
            </a>
            <a href="{{ route('executive-retainer.index') }}" class="btn btn-secondary rounded f-14 p-2">
                <i class="fa fa-arrow-left mr-1"></i> @lang('app.back')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-cards.data :title="__('app.applicantDetails')">
                <x-cards.data-row :label="__('app.name')" :value="$app->name" />
                <x-cards.data-row :label="__('app.mobile')" :value="$app->mobile" />
                <x-cards.data-row :label="__('app.email')" :value="$app->email" />
                <x-cards.data-row :label="__('app.jobpost')" :value="$app->post == 'HR Executive' ? __('app.hireExecutives') : __('app.retainer')" />
                <x-cards.data-row :label="__('app.dateOfJoining')" :value="$app->date_of_joining->format('d-m-Y')" />
                <x-cards.data-row :label="__('app.amount')" :value="'&#x20B9;' . number_format($app->amount, 2)" />
                <x-cards.data-row :label="__('app.paymentStatus')" :value="ucfirst($app->payment_status)" />
                <x-cards.data-row :label="__('app.txnid')" :value="$app->txnid ?? '--'" />
                @if($app->paid_at)
                    <x-cards.data-row :label="__('app.paidAt')" :value="$app->paid_at->format('d-m-Y h:i A')" />
                @endif
            </x-cards.data>
        </div>
    </div>

    @if($app->hired_executives)
    <div class="row mt-4">
        <div class="col-sm-12">
            <x-cards.data :title="__('app.hireExecutives')">
                <div class="table-responsive">
                    <x-table>
                        <x-slot name="thead">
                            <th>#</th>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.mobile')</th>
                            <th>@lang('app.joiningDate')</th>
                        </x-slot>
                        @foreach($app->hired_executives as $index => $exec)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $exec['name'] ?? '--' }}</td>
                                <td>{{ $exec['mobile'] ?? '--' }}</td>
                                <td>{{ isset($exec['joining_date']) ? \Carbon\Carbon::parse($exec['joining_date'])->format('d-m-Y') : '--' }}</td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </x-cards.data>
        </div>
    </div>
    @endif

    @if($app->hired_retainers)
    <div class="row mt-4">
        <div class="col-sm-12">
            <x-cards.data :title="__('app.hireRetainers')">
                <div class="table-responsive">
                    <x-table>
                        <x-slot name="thead">
                            <th>#</th>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.mobile')</th>
                            <th>@lang('app.joiningDate')</th>
                        </x-slot>
                        @foreach($app->hired_retainers as $index => $ret)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ret['name'] ?? '--' }}</td>
                                <td>{{ $ret['mobile'] ?? '--' }}</td>
                                <td>{{ isset($ret['joining_date']) ? \Carbon\Carbon::parse($ret['joining_date'])->format('d-m-Y') : '--' }}</td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </x-cards.data>
        </div>
    </div>
    @endif

    @if($app->retainer_detail)
    <div class="row mt-4">
        <div class="col-sm-12">
            <x-cards.data :title="__('app.retainerJoinDetail')">
                <x-cards.data-row :label="__('app.name')" :value="$app->retainer_detail['name'] ?? '--'" />
                <x-cards.data-row :label="__('app.mobile')" :value="$app->retainer_detail['mobile'] ?? '--'" />
                <x-cards.data-row :label="__('app.joiningDate')" :value="isset($app->retainer_detail['joining_date']) ? \Carbon\Carbon::parse($app->retainer_detail['joining_date'])->format('d-m-Y') : '--'" />
            </x-cards.data>
        </div>
    </div>
    @endif

    @if($app->payu_response)
    <div class="row mt-4">
        <div class="col-sm-12">
            <x-cards.data :title="__('app.payuResponse')">
                <pre class="mb-0 f-14">{{ json_encode($app->payu_response, JSON_PRETTY_PRINT) }}</pre>
            </x-cards.data>
        </div>
    </div>
    @endif
</div>
@endsection
