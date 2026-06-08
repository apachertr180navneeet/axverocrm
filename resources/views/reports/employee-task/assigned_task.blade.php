@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">

        <div class="p-3">
            <h5>
                Task Assigned Employees – {{ $manager->name ?? 'N/A' }}
            </h5>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Manager</th>
                    <th>Task Report Date</th>
                    <th>Task</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->name ?? 'N/A' }}</td>
                        <td>{{ $manager->name ?? 'N/A' }}</td>
                        <td>
                            {{ optional($employee->employeeTaskReports->first())->report_date
                                ? \Carbon\Carbon::parse($employee->employeeTaskReports->first()->report_date)->format('d M, Y h:i A')
                                : 'N/A'
                            }}
                        </td>
                    
                        <td class="d-flex">
                            {{-- Report Details --}}
                            @php
                                $report = $employee->employeeTaskReports->first();
                            @endphp
                            
                            @if($report)
                                <a href="{{ route('employee_task.task.reports.details', $report->id) }}"
                                   class="btn btn-sm btn-outline-danger mr-1">
                                    Task Details
                                </a>
                            @else
                                <span class="text-muted">No Report</span>
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            No employees assigned.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
