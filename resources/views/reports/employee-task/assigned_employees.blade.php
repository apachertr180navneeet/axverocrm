@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <div class="bg-white p-3 rounded shadow-sm mb-3">
        <h5 class="mb-0">
            Assigned Employees – {{ $manager->name }}
        </h5>
    </div>

    <div class="bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>
                            <a href="{{ route('employee_task.reports.user', $employee->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                View Tasks
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            No assigned employees
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
        Back
    </a>

</div>
@endsection
