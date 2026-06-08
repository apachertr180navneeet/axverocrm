@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="content-wrapper">

    <x-form id="save-training-attendance-form"
            method="POST"
            action="{{ route('training.attendance.store') }}"
            enctype="multipart/form-data">

        <div class="bg-white rounded p-20 mb-20">
            <h4 class="mb-0 f-21 font-weight-normal border-bottom-grey pb-3">
                Training Attendance
            </h4>

            <div class="row mt-3">

                <!-- Company Email -->
                <div class="col-md-6">
                    <x-forms.email
                        fieldLabel="Company Email ID"
                        fieldName="company_email"
                        fieldId="company_email"
                        fieldValue="{{ user()->email }}"
                        fieldPlaceholder="Enter company email"
                        fieldRequired="true"
                    />

                </div>

                <!-- Senior Name (Reporting To Person) -->
                <div class="col-md-6">
                   <x-forms.text
                        fieldLabel="Senior Name"
                        fieldName="senior_name"
                        fieldId="senior_name"
                        fieldValue="{{ $reportingTo->name ?? '' }}"
                        fieldPlaceholder="Senior Name"
                        readonly
                    />
                </div>

                <!-- Training Date -->
                <div class="col-md-6 mt-3">
                    <x-forms.text
                        fieldLabel="Training Date"
                        fieldName="training_date"
                        fieldId="training_date"
                        fieldPlaceholder="Select training date"
                        fieldRequired="true"
                    />
                </div>

                <!-- Upload Image -->
                <div class="col-md-6 mt-3">
                    <x-forms.file
                        fieldLabel="Upload Training Image"
                        fieldName="training_image"
                        fieldId="training_image"
                        fieldRequired="true"
                    />
                </div>

            </div>

            <x-form-actions class="mt-4">
                <x-forms.button-primary id="save-training-attendance-btn" icon="check">
                    Save
                </x-forms.button-primary>
            </x-form-actions>
        </div>

    </x-form>

</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function () {

    flatpickr("#training_date", {
        dateFormat: "Y-m-d"
    });

    $('#save-training-attendance-btn').click(function (e) {
        e.preventDefault();

        $.easyAjax({
            url: "{{ route('training.attendance.store') }}",
            container: '#save-training-attendance-form',
            type: "POST",
            file: true,
            blockUI: true,
            disableButton: true,
            buttonSelector: "#save-training-attendance-btn",
            success: function (response) {
                if (response.status === 'success') {
                    window.location.href = response.redirectUrl;
                }
            }
        });
    });

});
</script>
@endpush
