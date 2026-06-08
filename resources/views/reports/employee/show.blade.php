@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="bg-white p-3 rounded shadow-sm">

        <h4 class="mb-3">Report Details</h4>

        <div class="mb-3">
            <strong>Employee Name:</strong> {{ $report->user->name }}
        </div>

        <div class="mb-3">
            <strong>Manager Name:</strong> {{ $report->reportingPerson->name ?? 'N/A' }}
        </div>

        <div class="mb-3">
            <strong>Report Date:</strong> {{ \Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A') }}
        </div>

        <div class="mb-3">
            <strong>Report Description:</strong>
            <div class="border p-2 rounded bg-light">
                {!! $report->report_description ?? 'No description provided' !!}
            </div>
        </div>

{{-- SALES REPORT DETAILS --}}
<hr class="my-4">

<h5 class="mb-3">Sales Report Details</h5>

<div class="row">

    <div class="col-md-6 mb-2">
        <strong>Full Name:</strong>
        <span>{{ $report->full_name ?? 'N/A' }}</span>
    </div>

    <div class="col-md-6 mb-2">
        <strong>Today Sale:</strong>
        <span>{{ $report->today_sale ?? 0 }}</span>
    </div>

    <div class="col-md-6 mb-2">
        <strong>Today Team:</strong>
        <span>{{ $report->today_team ?? 0 }}</span>
    </div>

    <div class="col-md-6 mb-2">
        <strong>Overall Total Sale:</strong>
        <span>{{ $report->overall_total_sale ?? 0 }}</span>
    </div>

    <div class="col-md-6 mb-2">
        <strong>Overall Total Team:</strong>
        <span>{{ $report->overall_total_team ?? 0 }}</span>
    </div>

    <div class="col-md-6 mb-2">
        <strong>Marketing Work Done:</strong>
        <span class="badge badge-{{ $report->marketing_work_done === 'yes' ? 'success' : 'danger' }}">
            {{ ucfirst($report->marketing_work_done ?? 'no') }}
        </span>
    </div>

</div>

        {{-- Show file buttons if available --}}
        @if($report->file)
        <div class="mb-3">
            <a href="https://view.officeapps.live.com/op/embed.aspx?src={{ url($report->file) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary mr-1">
                View File
            </a>
            <a href="{{ asset($report->file) }}"
               download
               class="btn btn-sm btn-outline-success">
                Download File
            </a>
        </div>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
