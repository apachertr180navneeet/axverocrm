@extends('layouts.app')
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')
<x-filters.filter-box>
    <!-- SEARCH -->
    <div class="task-search d-flex py-1 px-lg-3 px-0 align-items-center w-30">
        <form class="w-100">
            <div class="input-group bg-grey rounded">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-additional-grey">
                        <i class="fa fa-search f-13 text-dark-grey"></i>
                    </span>
                </div>
                <input
                    type="text"
                    class="form-control f-14 p-1 border-additional-grey"
                    id="employee-search"
                    placeholder="@lang('app.startTyping')">
            </div>
        </form>
    </div>
</x-filters.filter-box>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="bg-white rounded p-3 mt-4">
        <table class="table table-bordered table-hover w-100" id="employees-table">
            <thead class="thead-light">
                <tr>
                    <th>Employee Name</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('employee_task.reports.user', $employee->user_id) }}"
                               class="btn btn-sm btn-success">
                                View Reports
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">No employees found</td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function () {

        let table = $('#employees-table').DataTable({
            paging: true,
            info: true,
            searching: true,
            ordering: true,          // ↑ ↓ arrows
            lengthChange: false,
            pageLength: 10,
            order: [[0, 'asc']],     // default sort
            dom: 'rt<"row"<"col-md-6"i><"col-md-6"p>>',
            language: {
                search: ""
            }
        });

        // Custom top search
        $('#employee-search').on('keyup', function () {
            table.search(this.value).draw();
        });

    });
</script>
@endpush

