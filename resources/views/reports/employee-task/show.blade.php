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
                {!! $report->reports ?? 'No description provided' !!}
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
