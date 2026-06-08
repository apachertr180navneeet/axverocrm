@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="content-wrapper">

    <x-form id="save-employee-report-form"
            method="POST"
            action="{{ route('employee_task.report.store') }}">

        <div class="add-client bg-white rounded p-20 mb-20">
            <h4 class="mb-0 f-21 font-weight-normal border-bottom-grey pb-3">
                Employee Report Details
            </h4>

            <div class="row mt-3">
                <!-- Employee Name -->
                <div class="col-md-6">
                    <x-forms.text
                        fieldLabel="Employee Name"
                        fieldName="employee_name"
                        fieldId="employee_name"
                        fieldValue="{{ $user->name }}"
                        readonly
                    />
                </div>

                <!-- Reporting To -->
                <div class="col-md-6">
                    <x-forms.text
                        fieldLabel="Reporting To"
                        fieldName="reporting_to_name"
                        fieldId="reporting_to_name"
                        fieldValue="{{ $reportingTo->name ?? 'N/A' }}"
                        readonly
                    />
                </div>
                <div class="col-md-6">
                    <x-forms.select
                        fieldId="status"
                        fieldLabel="{{ __('app.status') }}"
                        fieldName="status"
                        search="true"
                    >
                        <option value="incomplete"
                            {{ old('status') == 'incomplete' ? 'selected' : '' }}
                            data-content="<i class='fa fa-circle mr-2 text-red'></i> {{ __('app.incomplete') }}">
                            {{ __('app.incomplete') }}
                        </option>
                        
                        <option value="to_do"
                            {{ old('status') == 'to_do' ? 'selected' : '' }}
                            data-content="<i class='fa fa-circle mr-2 text-yellow'></i> To Do">
                            To Do
                        </option>
                
                        <option value="doing"
                            {{ old('status') == 'doing' ? 'selected' : '' }}
                            data-content="<i class='fa fa-circle mr-2 text-blue'></i> Doing">
                            Doing
                        </option>
                
                        <option value="completed"
                            {{ old('status') == 'completed' ? 'selected' : '' }}
                            data-content="<i class='fa fa-circle mr-2 text-dark-green'></i> {{ __('app.completed') }}">
                            {{ __('app.completed') }}
                        </option>
                
                        
                    </x-forms.select>
                </div>




                <!-- Reports -->
                <div class="col-md-6">
                    <x-forms.textarea
                        fieldLabel="Reports"
                        fieldName="reports"
                        fieldId="report_text"
                        fieldRequired="true"
                        rows="5"
                    />
                </div>

                <!-- Report Date & Time -->
                <div class="col-md-6">
                    <x-forms.text
                        fieldLabel="Report Date & Time"
                        fieldName="report_date"
                        fieldId="report_date"
                        fieldType="text"
                        fieldValue="{{ now('Asia/Kolkata')->format('Y-m-d h:i A') }}"
                        fieldRequired="true"
                    />
                </div>
            </div>

            <x-form-actions class="mt-3">
                <x-forms.button-primary id="save-employee-report-btn" icon="check">
                    Save Report
                </x-forms.button-primary>
            </x-form-actions>
        </div>

    </x-form>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        // Initialize Flatpickr
        flatpickr("#report_date", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K", // 12-hour format with AM/PM
            time_24hr: false,
            defaultDate: "{{ now('Asia/Kolkata')->format('Y-m-d h:i A') }}"
        });

        // Optional: AJAX submit like TimeLog
        $('#save-employee-report-btn').click(function(e) {
            e.preventDefault(); // prevent normal form submit
            const url = "{{ route('employee_task.report.store') }}";

            $.easyAjax({
                url: url,
                container: '#save-employee-report-form',
                type: "POST",
                file: true,
                blockUI: true,
                disableButton: true,
                buttonSelector: "#save-employee-report-btn",
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirectUrl ?? "{{ route('employee.report.index') }}";
                    }
                }
            });
        });
    });
</script>
@endpush
