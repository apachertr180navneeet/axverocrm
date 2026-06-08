@extends('layouts.app')

@push('datatable-styles')
@include('sections.datatable_css')
@endpush

@section('content')
<div class="content-wrapper">

    <h4 class="mb-3">{{ $employee->name }} – Reports</h4>

    @php
        $hasAssignedEmployees = \App\Models\EmployeeDetails::where('reporting_to', $employee->id)->exists();
    @endphp


    {{-- FILTER BOX --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row align-items-end">

                {{-- Manager Search --}}
                <div class="col-md-3">
                    <label class="f-14 font-weight-bold">Search Manager</label>
                    <input type="text"
                           id="nameSearch"
                           class="form-control py-2"
                           placeholder="Type manager name">
                </div>

                {{-- Start Date --}}
                <div class="col-md-2">
                    <label class="f-14 font-weight-bold">Start Date</label>
                    <input type="date"
                           id="startDate"
                           class="form-control py-2"
                           placeholder="Start Date">
                </div>

                {{-- End Date --}}
                <div class="col-md-2">
                    <label class="f-14 font-weight-bold">End Date</label>
                    <input type="date"
                           id="endDate"
                           class="form-control py-2"
                           placeholder="End Date">
                </div>

                {{-- Filter Button --}}
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-filter mr-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                @if($hasAssignedEmployees)
                    <a href="{{ route('employee.report.assigned', $employee->id) }}"
                       class="btn btn-sm btn-warning mb-1 py-2">
                        Assigned Employee
                    </a>
                @endif
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table id="reportsTable" class="table table-bordered table-hover w-100">
        <thead class="thead-light">
        <tr>
            <th>Report Date</th>
            <th>Manager</th>
            <th>Sales Info</th>
            <th>Actions</th>
        </tr>
    </thead>

        <tbody>
           @foreach($reports as $report)
<tr>
    <td>{{ \Carbon\Carbon::parse($report->report_date)->format('Y-m-d') }}</td>

    <td>{{ $report->reportingPerson->name ?? 'N/A' }}</td>

    {{-- Sales Info Button --}}
    <td>
        <button class="btn btn-sm btn-outline-info"
                data-toggle="modal"
                data-target="#salesModal{{ $report->id }}">
            View Sales
        </button>
    </td>

    {{-- Actions --}}
    <td class="d-flex align-items-center">
        <a href="{{ route('employee.report.details', $report->id) }}"
           class="btn btn-sm btn-outline-danger mr-1">
            Report Details
        </a>

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

{{-- SALES MODAL --}}
<div class="modal fade" id="salesModal{{ $report->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Sales Report Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $report->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Today Sale</th>
                        <td>{{ $report->today_sale }}</td>
                    </tr>
                    <tr>
                        <th>Today Team</th>
                        <td>{{ $report->today_team }}</td>
                    </tr>
                    <tr>
                        <th>Overall Total Sale</th>
                        <td>{{ $report->overall_total_sale }}</td>
                    </tr>
                    <tr>
                        <th>Overall Total Team</th>
                        <td>{{ $report->overall_total_team }}</td>
                    </tr>
                    <tr>
                        <th>Marketing Work Done</th>
                        <td>
                            <span class="badge badge-{{ $report->marketing_work_done == 'yes' ? 'success' : 'danger' }}">
                                {{ ucfirst($report->marketing_work_done) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
@endforeach

        </tbody>
    </table>
</div>


</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#reportsTable').DataTable({
    order: [[0, 'desc']],
    pageLength: 10,
    lengthChange: false,
    language: {
        emptyTable: "No reports found"
        }
    });


    // Search by Manager Name
    $('#nameSearch').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });

    // Date Filter
    $('.btn-primary').on('click', function () {

        let startDate = $('#startDate').val();
        let endDate   = $('#endDate').val();

        $.fn.dataTable.ext.search.push(function (settings, data) {
            let reportDate = data[0];

            if (
                (startDate === '' && endDate === '') ||
                (startDate === '' && reportDate <= endDate) ||
                (startDate <= reportDate && endDate === '') ||
                (startDate <= reportDate && reportDate <= endDate)
            ) {
                return true;
            }
            return false;
        });

        table.draw();
        $.fn.dataTable.ext.search.pop();
    });

});
</script>
@endpush
