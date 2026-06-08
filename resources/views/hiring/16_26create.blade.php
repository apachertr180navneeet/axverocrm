@extends('layouts.app')
@push('styles')
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .required:after {
      content: " *";
      color: red;
    }

    .price-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 10px;
      padding: 10px 15px;
      text-align: center;
      display: inline-block;
      width: auto;
    }

    .price-amount {
      font-size: 24px;
      font-weight: bold;
    }

    .readonly-field {
      background-color: #e9ecef;
      cursor: not-allowed;
    }

    .work-card {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      position: relative;
    }

    .section-title {
      background: #667eea;
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      margin: 0px 0 15px 0;
    }

    .terms-container {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      overflow: hidden;
    }

    .terms-header {
      background: #f8f9fa;
      padding: 12px 15px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
    }

    .terms-header:hover {
      background: #e9ecef;
    }

    .terms-header i {
      transition: transform 0.3s;
    }

    .terms-header i.rotated {
      transform: rotate(180deg);
    }

    .terms-content {
      padding: 0;
      max-height: 0;
      overflow: hidden;
      transition: all 0.3s ease;
      background: white;
    }

    .terms-content.show {
      padding: 15px;
      max-height: 600px;
      overflow-y: auto;
    }

    .agree-checkbox {
      margin-top: 15px;
      padding-top: 10px;
      border-top: 1px solid #dee2e6;
    }

    .terms-text {
      font-size: 13px;
      line-height: 1.6;
    }

    .terms-text ul {
      padding-left: 20px;
    }

    .terms-text li {
      margin-bottom: 8px;
    }
  </style>
@endpush
@section('content')

  <div class="container mt-2">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card">
          {{-- <div class="card-header bg-primary text-white">
            <h4>Advance Income Application Form</h4>
          </div> --}}
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('hiring.store') }}" id="hiringForm">
              @csrf

              <!-- Personal Details -->
              <div class="section-title"><i class="fas fa-user"></i> Personal Details</div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="required">Full Name</label>
                  <input type="text" name="name" class="form-control readonly-field"
                    value="{{ old('name', $userData['name'] ?? '') }}" readonly required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Mobile Number</label>
                  <input type="text" name="mobile" class="form-control readonly-field"
                    value="{{ old('mobile', $userData['mobile'] ?? '') }}" readonly required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Portal Email ID</label>
                  <input type="email" name="portal_email" class="form-control readonly-field"
                    value="{{ old('portal_email', $userData['portal_email'] ?? '') }}" readonly required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Joining Date</label>
                  <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date') }}"
                    required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Designation</label>
                  <input type="text" name="designation" class="form-control"
                    value="{{ old('designation', $userData['designation'] ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Department</label>
                  <input type="text" name="department" class="form-control"
                    value="{{ old('department', $userData['department'] ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Senior Manager Name</label>
                  <input type="text" name="senior_manager_name" class="form-control"
                    value="{{ old('senior_manager_name', $userData['senior_manager_name'] ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="required">Senior Manager Mobile</label>
                  <input type="text" name="senior_manager_mobile" class="form-control"
                    value="{{ old('senior_manager_mobile', $userData['senior_manager_mobile'] ?? '') }}" required>
                </div>
              </div>

              <!-- Hiring Work Details - Fixed 3 Cards -->
              <div class="section-title"><i class="fas fa-briefcase"></i> Hiring Work Details</div>

              <!-- Hiring Detail #1 -->
              <div class="work-card">
                <h6>Hiring Detail #1</h6>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label>Name</label>
                    <input type="text" name="hiring_work_details[0][name]" class="form-control"
                      value="{{ old('hiring_work_details.0.name') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Mobile</label>
                    <input type="text" name="hiring_work_details[0][mobile]" class="form-control"
                      placeholder="9876543210" value="{{ old('hiring_work_details.0.mobile') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Portal Email ID</label>
                    <input type="email" name="hiring_work_details[0][portal_email]" class="form-control"
                      value="{{ old('hiring_work_details.0.portal_email') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Joining Date</label>
                    <input type="date" name="hiring_work_details[0][joining_date]" class="form-control"
                      value="{{ old('hiring_work_details.0.joining_date') }}">
                  </div>
                </div>
              </div>

              <!-- Hiring Detail #2 -->
              <div class="work-card">
                <h6>Hiring Detail #2</h6>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label>Name</label>
                    <input type="text" name="hiring_work_details[1][name]" class="form-control"
                      value="{{ old('hiring_work_details.1.name') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Mobile</label>
                    <input type="text" name="hiring_work_details[1][mobile]" class="form-control"
                      placeholder="9876543210" value="{{ old('hiring_work_details.1.mobile') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Portal Email ID</label>
                    <input type="email" name="hiring_work_details[1][portal_email]" class="form-control"
                      value="{{ old('hiring_work_details.1.portal_email') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Joining Date</label>
                    <input type="date" name="hiring_work_details[1][joining_date]" class="form-control"
                      value="{{ old('hiring_work_details.1.joining_date') }}">
                  </div>
                </div>
              </div>

              <!-- Hiring Detail #3 -->
              <div class="work-card">
                <h6>Hiring Detail #3</h6>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label>Name</label>
                    <input type="text" name="hiring_work_details[2][name]" class="form-control"
                      value="{{ old('hiring_work_details.2.name') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Mobile</label>
                    <input type="text" name="hiring_work_details[2][mobile]" class="form-control"
                      placeholder="9876543210" value="{{ old('hiring_work_details.2.mobile') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Portal Email ID</label>
                    <input type="email" name="hiring_work_details[2][portal_email]" class="form-control"
                      value="{{ old('hiring_work_details.2.portal_email') }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Joining Date</label>
                    <input type="date" name="hiring_work_details[2][joining_date]" class="form-control"
                      value="{{ old('hiring_work_details.2.joining_date') }}">
                  </div>
                </div>
              </div>

              <!-- Price Section - Smaller -->
              {{-- <div class="text-center mb-3">
                <div class="price-card">
                  <div class="price-amount">₹ {{ config('services.payu.amount') }}</div>
                  <small>Application Fee</small>
                </div>
                <input type="hidden" name="advance_amount" value="{{ config('services.payu.amount') }}">
              </div> --}}

              <!-- Terms & Conditions -->
              <div class="terms-container mb-3">
                <div class="terms-header" id="termsHeader">
                  <span><i class="fas fa-file-alt"></i> Advance Income Form – Terms and Conditions</span>
                  <i class="fas fa-chevron-down" id="toggleIcon"></i>
                </div>
                <div class="terms-content" id="termsContent">
                  <div class="terms-text">
                    <p>This facility is provided by the Company solely as a form of <strong>financial
                        assistance</strong> and is entirely <strong>optional</strong> in nature.</p>

                    <ul>
                      <li>This form may only be submitted by individuals who have completed a minimum of <strong>seven
                          (7) days of attendance</strong>.</li>
                      <li>Attendance shall be calculated with effect from <strong>27 April 2026</strong>.</li>
                      <li>The applicant must ensure that within <strong>four (4) days from the date of joining</strong>,
                        a minimum of <strong>three (3) HR Executives</strong> are successfully onboarded, and all such
                        individuals must be in <strong>active and proper working status</strong>.</li>
                      <li>The Company shall provide an advance amount not exceeding <strong>thirty percent
                          (30%)</strong> of the applicant's monthly income.</li>
                      <li>Upon submission of the form, the Company shall require <strong>four (4) to five (5) working
                          days</strong> for verification.</li>
                      <li>Upon approval, the sanctioned amount shall be <strong>disbursed within three (3) working
                          days</strong> to the applicant's designated account.</li>
                      <li>The <strong>sole and absolute right of approval or rejection</strong> of any application shall
                        remain vested with the Company.</li>
                      <li>The applicant shall bear the <strong>application charges</strong>, which shall be
                        <strong>non-refundable</strong> in the event of rejection. Applicants are advised to review all
                        terms carefully prior to submission.</li>
                      <li>In the event that the applicant is found to be involved, directly or indirectly, in any
                        <strong>defamation, negative publicity, misconduct, or activities against the Company</strong>,
                        the application shall be <strong>rejected with immediate effect</strong>, and the Company
                        reserves the right to take <strong>appropriate disciplinary or legal action</strong>.</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="agree-checkbox mb-3">
                  <input type="checkbox" name="terms_accepted" id="termsCheckbox" value="1" required>
                  <label for="termsCheckbox"> I have read and agree to the above Terms & Conditions</label>
              </div>

              <button type="submit" class="btn btn-primary w-100 mt-3" id="submitBtn" disabled>Proceed to Pay</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      let isExpanded = false;
      $('#termsHeader').click(function () {
        if (!isExpanded) {
          $('#termsContent').addClass('show');
          $('#toggleIcon').addClass('rotated');
          isExpanded = true;
        } else {
          $('#termsContent').removeClass('show');
          $('#toggleIcon').removeClass('rotated');
          isExpanded = false;
        }
      });

      $('#termsCheckbox').change(function () {
        $('#submitBtn').prop('disabled', !$(this).is(':checked'));
      });

      @if(old('terms_accepted'))
        $('#termsContent').addClass('show');
        $('#toggleIcon').addClass('rotated');
        isExpanded = true;
        $('#submitBtn').prop('disabled', false);
      @endif
    });
  </script> --}}

@push('scripts')
<script>
    $(document).ready(function () {
      let isExpanded = false;
      $('#termsHeader').click(function () {
        if (!isExpanded) {
          $('#termsContent').addClass('show');
          $('#toggleIcon').addClass('rotated');
          isExpanded = true;
        } else {
          $('#termsContent').removeClass('show');
          $('#toggleIcon').removeClass('rotated');
          isExpanded = false;
        }
      });

      $('#termsCheckbox').change(function () {
        $('#submitBtn').prop('disabled', !$(this).is(':checked'));
      });

      @if(old('terms_accepted'))
        $('#termsContent').addClass('show');
        $('#toggleIcon').addClass('rotated');
        isExpanded = true;
        $('#submitBtn').prop('disabled', false);
      @endif
    });
  </script>
@endpush
@endsection
