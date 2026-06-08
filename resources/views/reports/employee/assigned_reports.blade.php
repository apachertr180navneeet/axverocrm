@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <h4 class="mb-3">Assigned Reports</h4>

    <div class="bg-white rounded p-3 shadow-sm">
        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>Employee</th>
                    <th>Manager</th>
                    <th>Report Date</th>
                    <th>Report</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($assignedReports as $report)
                    <tr>
                        <td>{{ $report->user->name ?? 'N/A' }}</td>
                        <td>{{ $report->reportingPerson->name ?? 'N/A' }}</td>
                        <td>{{ $report->report_date ? \Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A') : 'N/A' }}</td>
                        <td class="d-flex">
                            {{-- Report Details --}}
                            <a href="{{ route('employee.report.details', $report->id) }}"
                               class="btn btn-sm btn-outline-danger mr-1">
                                Report Details
                            </a>

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
                        <td colspan="4" class="text-center">No assigned reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
