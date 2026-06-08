@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="content-wrapper">

    <x-form id="save-employee-report-form"
            method="POST"
            action="{{ route('employee.report.store') }}"
            enctype="multipart/form-data">

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

                <!-- Upload File (OPTIONAL) -->
                <div class="col-md-6">
                    <x-forms.file
                        fieldLabel="Upload Report (Excel / PDF) (Optional)"
                        fieldName="report_file"
                        fieldId="report_file"
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

                <!-- Report Description (CKEditor) -->
                <div class="col-md-12 mt-3">
                    <x-forms.textarea
                        fieldLabel="Report Description"
                        fieldName="report_description"
                        fieldId="report_description"
                        fieldPlaceholder="Write report details here..."
                        fieldRequired="true"
                    />
                </div>

            </div>

            <hr class="my-4">

<h4 class="mb-0 f-21 font-weight-normal border-bottom-grey pb-3">
    Sales Report Form
</h4>

<div class="row mt-3">

    <!-- Full Name -->
    <div class="col-md-6">
        <x-forms.text
            fieldLabel="Full Name"
            fieldName="full_name"
            fieldId="full_name"
            fieldRequired="true"
        />
    </div>

    <!-- Today Sale -->
    <div class="col-md-6">
        <x-forms.number
            fieldLabel="Today Sale"
            fieldName="today_sale"
            fieldId="today_sale"
            fieldRequired="true"
        />
    </div>

    <!-- Today Team -->
    <div class="col-md-6">
        <x-forms.number
            fieldLabel="Today Team"
            fieldName="today_team"
            fieldId="today_team"
            fieldRequired="true"
        />
    </div>

    <!-- All Over Total Sale -->
    <div class="col-md-6">
        <x-forms.number
            fieldLabel="All Over Total Sale"
            fieldName="overall_total_sale"
            fieldId="overall_total_sale"
            fieldRequired="true"
        />
    </div>

    <!-- All Over Total Team -->
    <div class="col-md-6">
        <x-forms.number
            fieldLabel="All Over Total Team"
            fieldName="overall_total_team"
            fieldId="overall_total_team"
            fieldRequired="true"
        />
    </div>

    <!-- Today Marketing Work Done -->
    <div class="col-md-6">
        <label class="f-14 text-dark-grey mb-12">
            Today Marketing Work Done
        </label>

        <div class="d-flex mt-2">
            <div class="form-check mr-4">
                <input class="form-check-input"
                       type="radio"
                       name="marketing_work_done"
                       id="marketing_yes"
                       value="yes"
                       required>
                <label class="form-check-label" for="marketing_yes">
                    Yes
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="marketing_work_done"
                       id="marketing_no"
                       value="no">
                <label class="form-check-label" for="marketing_no">
                    No
                </label>
            </div>
        </div>
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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    $(document).ready(function() {

        // Flatpickr
        flatpickr("#report_date", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K",
            time_24hr: false,
            defaultDate: "{{ now('Asia/Kolkata')->format('Y-m-d h:i A') }}"
        });

        // CKEditor
        CKEDITOR.replace('report_description');

        // AJAX Submit
        $('#save-employee-report-btn').click(function(e) {
            e.preventDefault();

            // Update CKEditor data before submit
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.easyAjax({
                url: "{{ route('employee.report.store') }}",
                container: '#save-employee-report-form',
                type: "POST",
                file: true,
                blockUI: true,
                disableButton: true,
                buttonSelector: "#save-employee-report-btn",
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirectUrl ?? "{{ route('employee.reports.my') }}";
                    }
                }
            });
        });
    });
</script>
@endpush
