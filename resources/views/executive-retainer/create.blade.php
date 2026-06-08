@extends('layouts.app')

@push('styles')
<style>
  .form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    border: 1px solid #e9ecef;
  }

  .form-section h4 {
    font-size: 15px;
    font-weight: 600;
    color: #343a40;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
  }

  label {
    font-size: 13px;
    font-weight: 500;
    color: #495057;
  }

  .required:after {
    content: " *";
    color: #dc3545;
  }

  .price-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    padding: 15px 25px;
    display: inline-block;
  }

  .btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 12px;
    width: 100%;
  }

  .btn-gradient:hover {
    opacity: 0.9;
    color: white;
  }

  .executive-row,
  .retainer-row {
    align-items: flex-end;
  }

  @media (max-width: 768px) {
    .executive-row,
    .retainer-row {
      align-items: stretch;
    }
  }

  label.form-check-label.mb-0 {
      margin-left: 1% !important;
  }
</style>
@endpush

@section('content')
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <i class="fa fa-user-tie mr-2 text-primary"></i>@lang('app.menu.applyExecutiveRetainer')
        <span class="badge badge-primary ml-2">₹299</span>
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('executive-retainer.store') }}" id="applicationForm">
            @csrf

            <!-- Applicant Details -->
            <div class="form-section">
              <h4><i class="fa fa-user-circle mr-2 text-primary"></i>@lang('app.applicantDetails')</h4>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="required">@lang('app.name')</label>
                  <input type="text" name="name" class="form-control f-14" value="{{ old('name') }}" required placeholder="@lang('placeholders.name')">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required">@lang('app.mobile')</label>
                  <input type="text" name="mobile" class="form-control f-14" value="{{ old('mobile') }}" required placeholder="@lang('placeholders.mobile')">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required">@lang('app.email')</label>
                  <input type="email" name="email" class="form-control f-14" value="{{ old('email') }}" required placeholder="@lang('placeholders.email')">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required">@lang('app.post')</label>
                  <select name="post" id="post" class="form-control f-14" required>
                    <option value="">-- @lang('app.select') --</option>
                    <option value="HR Executive" {{ old('post') == 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
                    <option value="Retainer" {{ old('post') == 'Retainer' ? 'selected' : '' }}>@lang('app.retainer')</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required">@lang('app.dateOfJoining')</label>
                  <input type="date" name="date_of_joining" class="form-control f-14" value="{{ old('date_of_joining', date('Y-m-d')) }}" required>
                </div>
              </div>
            </div>

            <!-- SECTION 1: Hire HR Executive Details (Max 4) -->
            <div class="form-section">
              <h4><i class="fa fa-users mr-2 text-success"></i>@lang('app.hireExecutives') <small class="text-muted font-weight-normal">(@lang('app.max') 4)</small></h4>
              <div id="executiveRows">
                @php $oldHired = old('hired_executives', [['name' => '', 'mobile' => '', 'joining_date' => '']]); @endphp
                @foreach($oldHired as $index => $exec)
                  <div class="row mb-2 executive-row align-items-end">
                    <div class="col-md-4 mb-2">
                      @if($loop->first)<label>@lang('app.executiveName')</label>@endif
                      <select name="hired_executives[{{ $index }}][name]" class="form-control f-14 executive-name-select" data-index="{{ $index }}">
                        <option value="">-- @lang('app.select') HR Executive --</option>
                        @foreach($executives as $exe)
                          <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old("hired_executives.$index.name", $exec['name']) == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3 mb-2">
                      @if($loop->first)<label>@lang('app.mobile')</label>@endif
                      <input type="text" name="hired_executives[{{ $index }}][mobile]" class="form-control f-14 executive-mobile" data-index="{{ $index }}" value="{{ old("hired_executives.$index.mobile", $exec['mobile']) }}" readonly placeholder="@lang('placeholders.autoFilled')">
                    </div>
                    <div class="col-md-3 mb-2">
                      @if($loop->first)<label>@lang('app.joiningDate')</label>@endif
                      <input type="date" name="hired_executives[{{ $index }}][joining_date]" class="form-control f-14" value="{{ old("hired_executives.$index.joining_date", $exec['joining_date'] ?? date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                      @if(!$loop->first)
                        <button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
              <button type="button" id="addExecutiveRow" class="btn btn-sm btn-outline-success rounded f-12 mt-2"><i class="fa fa-plus-circle mr-1"></i> @lang('app.addAnotherExecutive')</button>
              <small class="text-muted d-block mt-1">@lang('app.maxEntries', ['count' => 4])</small>
            </div>

            <!-- SECTION 2: Hire HR Retainer Details (Max 4) -->
            <div class="form-section">
              <h4><i class="fa fa-user-friends mr-2 text-info"></i>@lang('app.hireRetainers') <small class="text-muted font-weight-normal">(@lang('app.max') 4)</small></h4>
              <div id="retainerRows">
                @php $oldRetainers = old('hired_retainers', [['name' => '', 'mobile' => '', 'joining_date' => '']]); @endphp
                @foreach($oldRetainers as $index => $ret)
                  <div class="row mb-2 retainer-row align-items-end">
                    <div class="col-md-4 mb-2">
                      @if($loop->first)<label>@lang('app.retainerName')</label>@endif
                      <select name="hired_retainers[{{ $index }}][name]" class="form-control f-14 retainer-name-select" data-index="{{ $index }}">
                        <option value="">-- @lang('app.select') HR Retainer --</option>
                        @foreach($executives as $exe)
                          <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old("hired_retainers.$index.name", $ret['name']) == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3 mb-2">
                      @if($loop->first)<label>@lang('app.mobile')</label>@endif
                      <input type="text" name="hired_retainers[{{ $index }}][mobile]" class="form-control f-14 retainer-mobile" data-index="{{ $index }}" value="{{ old("hired_retainers.$index.mobile", $ret['mobile']) }}" readonly placeholder="@lang('placeholders.autoFilled')">
                    </div>
                    <div class="col-md-3 mb-2">
                      @if($loop->first)<label>@lang('app.joiningDate')</label>@endif
                      <input type="date" name="hired_retainers[{{ $index }}][joining_date]" class="form-control f-14" value="{{ old("hired_retainers.$index.joining_date", $ret['joining_date'] ?? date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                      @if(!$loop->first)
                        <button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
              <button type="button" id="addRetainerRow" class="btn btn-sm btn-outline-info rounded f-12 mt-2"><i class="fa fa-plus-circle mr-1"></i> @lang('app.addAnotherRetainer')</button>
              <small class="text-muted d-block mt-1">@lang('app.maxEntries', ['count' => 4])</small>
            </div>

            <!-- SECTION 3: Retainer Join Detail (shown only if post = Retainer) -->
            <div class="form-section" id="retainerSection" style="{{ old('post') == 'Retainer' ? '' : 'display:none;' }}">
              <h4><i class="fa fa-handshake mr-2 text-warning"></i>@lang('app.retainerJoinDetail')</h4>
              <div class="row">
                <div class="col-md-4 mb-2">
                  <label>@lang('app.retainerName')</label>
                  <select name="retainer_detail[name]" id="retainerNameSelect" class="form-control f-14">
                    <option value="">-- @lang('app.select') Retainer --</option>
                    @foreach($executives as $exe)
                      <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old('retainer_detail.name') == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-2">
                  <label>@lang('app.mobile')</label>
                  <input type="text" name="retainer_detail[mobile]" id="retainerMobile" class="form-control f-14" value="{{ old('retainer_detail.mobile') }}" readonly placeholder="@lang('placeholders.autoFilled')">
                </div>
                <div class="col-md-3 mb-2">
                  <label>@lang('app.joiningDate')</label>
                  <input type="date" name="retainer_detail[joining_date]" class="form-control f-14" value="{{ old('retainer_detail.joining_date', date('Y-m-d')) }}">
                </div>
              </div>
            </div>

            <!-- Payment & Terms -->
            <div class="w-100 border-top-grey d-block d-lg-flex d-md-flex justify-content-start px-4 py-3">
              <div class="text-center w-100">
                <div class="price-card d-inline-block mb-3">
                  <div class="price-amount" style="font-size:24px;font-weight:700;">₹ 299</div>
                  <small>PayU Secure Payment</small>
                </div>

                <div class="form-check d-flex mb-4">
                  <input type="checkbox" name="terms_accepted" id="terms" class="form-check-input mr-2" value="1" required>
                  <label for="terms" class="form-check-label mb-0">
                    @lang('app.acceptTerms')
                    <a href="https://axvero.in/Advance-terms--conditions" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
                  </label>
                </div>

                <button type="submit" class="btn btn-gradient">
                  <i class="fa fa-credit-card mr-2"></i> Proceed to Pay ₹299
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  let executiveCount = {{ count(old('hired_executives', [['name' => '']])) }};
  const maxExecutives = 4;

  $('#addExecutiveRow').click(function () {
    if (executiveCount >= maxExecutives) {
      Swal.fire('@lang('app.limitReached')', '@lang('messages.maxEntries', ['count' => 4])', 'warning');
      return;
    }
    let idx = executiveCount;
    let newRow = `
      <div class="row mb-2 executive-row align-items-end">
        <div class="col-md-4 mb-2">
          <select name="hired_executives[${idx}][name]" class="form-control f-14 executive-name-select" data-index="${idx}">
            <option value="">-- @lang('app.select') HR Executive --</option>
            @foreach($executives as $exe)
              <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}">{{ $exe->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <input type="text" name="hired_executives[${idx}][mobile]" class="form-control f-14 executive-mobile" data-index="${idx}" readonly placeholder="@lang('placeholders.autoFilled')">
        </div>
        <div class="col-md-3 mb-2">
          <input type="date" name="hired_executives[${idx}][joining_date]" class="form-control f-14" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-2 mb-2 text-center">
          <button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
        </div>
      </div>`;
    $('#executiveRows').append(newRow);
    executiveCount++;
  });

  $(document).on('click', '.remove-executive', function () {
    if ($('.executive-row').length === 1) {
      Swal.fire('@lang('app.cannotDelete')', '@lang('messages.atLeastOneRow')', 'info');
      return;
    }
    $(this).closest('.executive-row').remove();
    executiveCount--;
  });

  $(document).on('change', '.executive-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.executive-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  let retainerCount = {{ count(old('hired_retainers', [['name' => '']])) }};
  const maxRetainers = 4;

  $('#addRetainerRow').click(function () {
    if (retainerCount >= maxRetainers) {
      Swal.fire('@lang('app.limitReached')', '@lang('messages.maxEntries', ['count' => 4])', 'warning');
      return;
    }
    let idx = retainerCount;
    let newRow = `
      <div class="row mb-2 retainer-row align-items-end">
        <div class="col-md-4 mb-2">
          <select name="hired_retainers[${idx}][name]" class="form-control f-14 retainer-name-select" data-index="${idx}">
            <option value="">-- @lang('app.select') HR Retainer --</option>
            @foreach($executives as $exe)
              <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}">{{ $exe->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <input type="text" name="hired_retainers[${idx}][mobile]" class="form-control f-14 retainer-mobile" data-index="${idx}" readonly placeholder="@lang('placeholders.autoFilled')">
        </div>
        <div class="col-md-3 mb-2">
          <input type="date" name="hired_retainers[${idx}][joining_date]" class="form-control f-14" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-2 mb-2 text-center">
          <button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
        </div>
      </div>`;
    $('#retainerRows').append(newRow);
    retainerCount++;
  });

  $(document).on('click', '.remove-retainer', function () {
    if ($('.retainer-row').length === 1) {
      Swal.fire('@lang('app.cannotDelete')', '@lang('messages.atLeastOneRow')', 'info');
      return;
    }
    $(this).closest('.retainer-row').remove();
    retainerCount--;
  });

  $(document).on('change', '.retainer-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.retainer-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  $('#post').change(function () {
    if ($(this).val() === 'Retainer') $('#retainerSection').slideDown();
    else $('#retainerSection').slideUp();
  });

  $('#retainerNameSelect').change(function () {
    $('#retainerMobile').val($(this).find(':selected').data('mobile') || '');
  });
</script>
@endpush
