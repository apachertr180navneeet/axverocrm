@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">

        <div class="m-3">
            <a href="{{ route('employee_task.task.reports.assigned')}}" class="btn btn-info btn-sm">
                View Assigned Reports
            </a>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>Employee</th>
                    <th>Manager</th>
                    <th>Report Date</th>
                    <th>Status</th>
                    <th>Task</th>
                    <th>Report</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ $report->user->name ?? 'N/A' }}</td>
                        <td>{{ $report->reportingPerson->name ?? 'N/A' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A') }}
                        </td>
                        <td>{{ $report->status ?? 'N/A' }}</td>
                        <td>{!! \Illuminate\Support\Str::limit(strip_tags($report->reports), 50) !!}</td>
                        <td>
                            <a href=""
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                View
                            </a>

                            <a href="">
                                Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No reports found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection

