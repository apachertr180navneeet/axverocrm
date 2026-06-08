@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">
        <div class="m-3">
            {{-- Button redirects to assigned reports page --}}
            <a href="{{ route('employee.reports.assigned') }}" 
               class="btn btn-info btn-sm">
                View Assigned Reports
            </a>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>Employee</th>
                    <th>Manager</th>
                    <th>Report Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->reportingPerson->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A') }}</td>
                        <td class="d-flex">
                            {{-- Report Details --}}
                            @if($report->report_description)
                                <a href="{{ route('employee.report.details', $report->id) }}"
                                   class="btn btn-sm btn-outline-danger mr-1">
                                    Report Details
                                </a>
                            @endif
                            {{-- Only show View / Download if file exists --}}
                            @if($report->file)
                                <a href="https://view.officeapps.live.com/op/embed.aspx?src={{ url($report->file) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary mr-1">
                                    View
                                </a>

                                <a href="{{ asset($report->file) }}"
                                   download
                                   class="btn btn-sm btn-outline-success">
                                    Download
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
