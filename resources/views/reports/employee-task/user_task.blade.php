@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    {{-- HEADER --}}
    <div class="bg-white p-3 rounded shadow-sm mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            {{ $employee->name }} – Task detail
        </h5>

        @if($hasAssignedEmployees)
            <a href="{{ route('employee_task.assigned.by.manager', $employee->id) }}"
               class="btn btn-primary btn-sm">
                Assigned Employees
            </a>
        @endif

    </div>

    @forelse($tasks as $task)
        <div class="bg-white p-3 rounded shadow-sm mb-3">
    
            <div class="row mb-2">
                <div class="col-md-4">
                    <strong>Task Date:</strong><br>
                    {{ \Carbon\Carbon::parse($task->report_date)->format('d M, Y h:i A') }}
                </div>
    
                <div class="col-md-4">
                    <strong>Status:</strong><br>
                    <span class="badge badge-info">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
    
                <div class="col-md-4">
                    <strong>Reporting To:</strong><br>
                    {{ $task->reportingPerson->name ?? 'N/A' }}
                </div>
            </div>
    
            <div class="mt-2">
                <strong>Task Description:</strong>
                <div class="border p-2 rounded bg-light mt-1">
                    {!! $task->reports ?? 'No description provided' !!}
                </div>
            </div>
    
        </div>
    @empty
        <div class="bg-white p-4 rounded shadow-sm text-center">
            No task found
        </div>
    @endforelse

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
        Back
    </a>

</div>
@endsection
