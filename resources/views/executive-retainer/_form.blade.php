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

  .remove-row {
    cursor: pointer;
    color: #dc3545;
    margin-top: 32px;
  }

  .field-error {
    color: #dc3545;
    font-size: 12px;
    margin-top: 4px;
  }

  @media (max-width:768px) {
    .remove-row {
      margin-top: 10px;
    }
  }
</style>

<x-form :method="$application ? 'PUT' : 'POST'"
  :action="$application ? route('executive-retainer.update', $application->id) : route('executive-retainer.store')"
  :spoofMethod="$application ? true : false">

  <div class="add-client bg-white rounded">

    <!-- Applicant Details -->
    <div class="row p-20">
      <div class="col-md-4">
        <x-forms.text fieldId="name" :fieldLabel="__('app.name')" fieldName="name" fieldRequired="true"
          :fieldPlaceholder="__('placeholders.name')" :fieldValue="old('name', $application->name ?? '')" />
        @error('name')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <x-forms.text fieldId="mobile" :fieldLabel="__('app.mobile')" fieldName="mobile" fieldRequired="true"
          :fieldPlaceholder="__('placeholders.mobile')" :fieldValue="old('mobile', $application->mobile ?? '')" />
        @error('mobile')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <x-forms.email fieldId="email" :fieldLabel="__('app.email')" fieldName="email" fieldRequired="true"
          :fieldPlaceholder="__('placeholders.email')" :fieldValue="old('email', $application->email ?? '')" />
        @error('email')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <x-forms.select fieldId="post" :fieldLabel="__('app.post')" fieldName="post" fieldRequired="true">
          <option value="">-- @lang('app.select') --</option>
          <option value="HR Executive" {{ old('post', $application->post ?? '') == 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
          <option value="Retainer" {{ old('post', $application->post ?? '') == 'Retainer' ? 'selected' : '' }}>@lang('app.retainer')</option>
        </x-forms.select>
        @error('post')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <x-forms.label fieldId="sectionToggle" :fieldLabel="__('app.jobpost')" fieldRequired="true" />
        <div class="d-flex">
          <x-forms.radio fieldId="section-hiring" :fieldLabel="__('app.hiring')" fieldName="section_type" fieldValue="hiring"
            :checked="old('section_type', 'hiring') == 'hiring'" />
          <x-forms.radio fieldId="section-retainer" :fieldLabel="__('app.retainer')" fieldName="section_type" fieldValue="retainer"
            :checked="old('section_type', '') == 'retainer'" />
        </div>
      </div>
      <div class="col-md-4">
        <x-forms.datepicker fieldId="date_of_joining" fieldPlaceholder="Select Date" :fieldLabel="__('app.dateOfJoining')" fieldName="date_of_joining" fieldRequired="true"
          :fieldValue="old('date_of_joining', isset($application) ? $application->date_of_joining->format('Y-m-d') : date('Y-m-d'))" />
        @error('date_of_joining')<div class="field-error">{{ $message }}</div>@enderror
      </div>
    </div>

    <!-- Job Post Section (Hiring / Retainers) -->
    <div class="row p-20" id="jobPostSection">
      <div class="col-sm-12">
        <div class="form-section">
          <h4 id="jobPostHeading"><i class="fa fa-users mr-2 text-success"></i><span id="jobPostTitle">@lang('app.hireExecutives')</span> <small class="text-muted font-weight-normal">(@lang('app.max') 4)</small></h4>

          <!-- Hiring fields -->
          <div id="hiringFields" style="{{ old('section_type', 'hiring') == 'retainer' ? 'display:none;' : '' }}">
            <div id="executiveRows">
              @php $hired = old('hired_executives', $application->hired_executives ?? [['name' => '', 'mobile' => '', 'joining_date' => '']]); @endphp
              @foreach($hired as $index => $exec)
                <div class="row mb-2 executive-row align-items-end">
                  <div class="col-md-4 mb-2">
                    @if($loop->first)<x-forms.label fieldId="executive-name-{{ $index }}" :fieldLabel="__('app.executiveName')" />@endif
                    <select name="hired_executives[{{ $index }}][name]" class="form-control height-35 f-14 executive-name-select" data-index="{{ $index }}">
                      <option value="">-- @lang('app.select') --</option>
                      @foreach($executives as $exe)
                        <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old("hired_executives.$index.name", $exec['name'] ?? '') == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                      @endforeach
                    </select>
                    @error('hired_executives.' . $index . '.name')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="executive-mobile-{{ $index }}" :fieldLabel="__('app.mobile')" />@endif
                    <input type="text" name="hired_executives[{{ $index }}][mobile]" class="form-control height-35 f-14 executive-mobile" data-index="{{ $index }}"
                      value="{{ old("hired_executives.$index.mobile", $exec['mobile'] ?? '') }}" readonly placeholder="@lang('placeholders.autoFilled')">
                    @error('hired_executives.' . $index . '.mobile')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="executive-date-{{ $index }}" :fieldLabel="__('app.joiningDate')" />@endif
                    <input type="date" name="hired_executives[{{ $index }}][joining_date]" class="form-control height-35 f-14"
                      value="{{ old("hired_executives.$index.joining_date", $exec['joining_date'] ?? date('Y-m-d')) }}">
                    @error('hired_executives.' . $index . '.joining_date')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="executive-date-{{ $index }}" :fieldLabel="__('app.jobpost')" />@endif
                    <input type="text" name="hired_executives[{{ $index }}][job_post]" class="form-control height-35 f-14"
                      value="{{ old("hired_executives.$index.job_post", $exec['job_post'] ?? '') }}">
                    @error('hired_executives.' . $index . '.job_post')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-2 mb-2 text-center">
                    @if(!$loop->first)
                      <button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
            <button type="button" id="addExecutiveRow" class="btn btn-sm btn-outline-success rounded f-12 mt-2">
              <i class="fa fa-plus-circle mr-1"></i> @lang('app.addAnotherExecutive')
            </button>
            <small class="text-muted d-block mt-1">@lang('app.maxEntries', ['count' => 4])</small>
          </div>

          <!-- Retainer fields -->
          <div id="retainerFields" style="{{ old('section_type', '') == 'retainer' ? '' : 'display:none;' }}">
            <div id="retainerRows">
              @php $retainers = old('hired_retainers', $application->hired_retainers ?? [['name' => '', 'mobile' => '', 'joining_date' => '']]); @endphp
              @foreach($retainers as $index => $ret)
                <div class="row mb-2 retainer-row align-items-end">
                  <div class="col-md-4 mb-2">
                    @if($loop->first)<x-forms.label fieldId="retainer-name-{{ $index }}" :fieldLabel="__('app.retainerName')" />@endif
                    <select name="hired_retainers[{{ $index }}][name]" class="form-control height-35 f-14 retainer-name-select" data-index="{{ $index }}">
                      <option value="">-- @lang('app.select') --</option>
                      @foreach($executives as $exe)
                        <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old("hired_retainers.$index.name", $ret['name'] ?? '') == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                      @endforeach
                    </select>
                    @error('hired_retainers.' . $index . '.name')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="retainer-mobile-{{ $index }}" :fieldLabel="__('app.mobile')" />@endif
                    <input type="text" name="hired_retainers[{{ $index }}][mobile]" class="form-control height-35 f-14 retainer-mobile" data-index="{{ $index }}"
                      value="{{ old("hired_retainers.$index.mobile", $ret['mobile'] ?? '') }}" readonly placeholder="@lang('placeholders.autoFilled')">
                    @error('hired_retainers.' . $index . '.mobile')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="retainer-date-{{ $index }}" :fieldLabel="__('app.joiningDate')" />@endif
                    <input type="date" name="hired_retainers[{{ $index }}][joining_date]" class="form-control height-35 f-14"
                      value="{{ old("hired_retainers.$index.joining_date", $ret['joining_date'] ?? date('Y-m-d')) }}">
                    @error('hired_retainers.' . $index . '.joining_date')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3 mb-2">
                    @if($loop->first)<x-forms.label fieldId="retainer-jobpost-{{ $index }}" :fieldLabel="__('app.jobpost')" />@endif
                    <input type="text" name="hired_retainers[{{ $index }}][job_post]" class="form-control height-35 f-14"
                      value="{{ old("hired_retainers.$index.job_post", $ret['job_post'] ?? '') }}">
                    @error('hired_retainers.' . $index . '.job_post')<div class="field-error">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-2 mb-2 text-center">
                    @if(!$loop->first)
                      <button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
            <button type="button" id="addRetainerRow" class="btn btn-sm btn-outline-info rounded f-12 mt-2">
              <i class="fa fa-plus-circle mr-1"></i> @lang('app.addAnotherRetainer')
            </button>
            <small class="text-muted d-block mt-1">@lang('app.maxEntries', ['count' => 4])</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Retainer Join Detail (single) - shown only if post = Retainer -->
    <div class="row p-20" id="retainerJoinSection" style="{{ old('post', $application->post ?? '') == 'Retainer' ? '' : 'display:none;' }}">
      <div class="col-sm-12">
        <div class="form-section">
          <h4><i class="fa fa-handshake mr-2 text-warning"></i>@lang('app.retainerJoinDetail')</h4>
          <div class="row">
            <div class="col-md-4 mb-2">
              <x-forms.label fieldId="retainerNameSelect" :fieldLabel="__('app.retainerName')" />
              <select name="retainer_detail[name]" id="retainerNameSelect" class="form-control height-35 f-14">
                <option value="">-- @lang('app.select') Retainer --</option>
                @foreach($executives as $exe)
                  <option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}" {{ old('retainer_detail.name', $application->retainer_detail['name'] ?? '') == $exe->name ? 'selected' : '' }}>{{ $exe->name }}</option>
                @endforeach
              </select>
              @error('retainer_detail.name')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-2">
              <x-forms.label fieldId="retainerMobile" :fieldLabel="__('app.mobile')" />
              <input type="text" name="retainer_detail[mobile]" id="retainerMobile" class="form-control height-35 f-14"
                value="{{ old('retainer_detail.mobile', $application->retainer_detail['mobile'] ?? '') }}" readonly placeholder="@lang('placeholders.autoFilled')">
              @error('retainer_detail.mobile')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-2">
              <x-forms.label fieldId="retainerDetailDate" :fieldLabel="__('app.joiningDate')" />
              <input type="date" name="retainer_detail[joining_date]" id="retainerDetailDate" class="form-control height-35 f-14"
                value="{{ old('retainer_detail.joining_date', $application->retainer_detail['joining_date'] ?? date('Y-m-d')) }}">
              @error('retainer_detail.joining_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Info & Terms -->
    @if($showPayment ?? true)
    <div class="row p-20">
      <div class="col-sm-12">
        <div class="form-section">
          <h4><i class="fa fa-credit-card mr-2 text-primary"></i>Payment</h4>
          <div class="d-flex align-items-center flex-wrap">
            <div class="price-card mr-4 mb-2" style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;border-radius:12px;padding:12px 24px;">
              <span style="font-size:22px;font-weight:700;">₹299</span>
              <small class="d-block">PayU Secure Payment</small>
            </div>
            <div class="form-check d-flex align-items-center mb-2">
              <input type="checkbox" name="terms_accepted" id="terms" class="form-check-input mr-2" value="1" required>
              <label for="terms" class="form-check-label mb-0 f-14">
                @lang('app.acceptTerms')
                <a href="https://axvero.in/Advance-terms--conditions" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Form Actions -->
    <div class="w-100 border-top-grey d-block d-lg-flex d-md-flex justify-content-start px-4 py-3">
      <button type="submit" class="btn-primary rounded f-14 p-2 mr-3">
        @if($showPayment ?? true)
          <i class="fa fa-credit-card mr-1"></i> @lang('app.proceedToPay', ['amount' => '₹299'])
        @else
          <i class="fa fa-check mr-1"></i> @lang('app.update')
        @endif
      </button>
      <x-forms.button-cancel :link="route('executive-retainer.index')" class="border-0">
        @lang('app.cancel')
      </x-forms.button-cancel>
    </div>
  </div>
</x-form>

<script>
  let executiveCount = {{ count(old('hired_executives', $application->hired_executives ?? [[]])) }};
  const maxExecutives = 4;
  $('#addExecutiveRow').click(function () {
    if (executiveCount >= maxExecutives) { alert('@lang('messages.maxEntries', ['count' => 4])'); return; }
    let idx = executiveCount;
    let newRow = `<div class="row mb-2 executive-row align-items-end"><div class="col-md-4 mb-2"><select name="hired_executives[${idx}][name]" class="form-control height-35 f-14 executive-name-select" data-index="${idx}"><option value="">-- @lang('app.select') HR Executive --</option>@foreach($executives as $exe)<option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}">{{ $exe->name }}</option>@endforeach</select></div><div class="col-md-3 mb-2"><input type="text" name="hired_executives[${idx}][mobile]" class="form-control height-35 f-14 executive-mobile" data-index="${idx}" readonly placeholder="@lang('placeholders.autoFilled')"></div><div class="col-md-3 mb-2"><input type="date" name="hired_executives[${idx}][joining_date]" class="form-control height-35 f-14" value="{{ date('Y-m-d') }}"></div><div class="col-md-2 mb-2 text-center"><button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button></div></div>`;
    $('#executiveRows').append(newRow);
    executiveCount++;
  });
  $(document).on('click', '.remove-executive', function () {
    if ($('.executive-row').length === 1) { alert('@lang('messages.atLeastOneRow')'); return; }
    $(this).closest('.executive-row').remove();
    executiveCount--;
  });
  $(document).on('change', '.executive-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.executive-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  let retainerCount = {{ count(old('hired_retainers', $application->hired_retainers ?? [[]])) }};
  const maxRetainers = 4;
  $('#addRetainerRow').click(function () {
    if (retainerCount >= maxRetainers) { alert('@lang('messages.maxEntries', ['count' => 4])'); return; }
    let idx = retainerCount;
    let newRow = `<div class="row mb-2 retainer-row align-items-end"><div class="col-md-4 mb-2"><select name="hired_retainers[${idx}][name]" class="form-control height-35 f-14 retainer-name-select" data-index="${idx}"><option value="">-- @lang('app.select') HR Retainer --</option>@foreach($executives as $exe)<option value="{{ $exe->name }}" data-mobile="{{ $exe->mobile }}">{{ $exe->name }}</option>@endforeach</select></div><div class="col-md-3 mb-2"><input type="text" name="hired_retainers[${idx}][mobile]" class="form-control height-35 f-14 retainer-mobile" data-index="${idx}" readonly placeholder="@lang('placeholders.autoFilled')"></div><div class="col-md-3 mb-2"><input type="date" name="hired_retainers[${idx}][joining_date]" class="form-control height-35 f-14" value="{{ date('Y-m-d') }}"></div><div class="col-md-2 mb-2 text-center"><button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button></div></div>`;
    $('#retainerRows').append(newRow);
    retainerCount++;
  });
  $(document).on('click', '.remove-retainer', function () {
    if ($('.retainer-row').length === 1) { alert('@lang('messages.atLeastOneRow')'); return; }
    $(this).closest('.retainer-row').remove();
    retainerCount--;
  });
  $(document).on('change', '.retainer-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.retainer-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  if ($('#retainerFields').is(':hidden')) {
    $('#retainerFields').find('input, select, button').prop('disabled', true);
  }
  if ($('#hiringFields').is(':hidden')) {
    $('#hiringFields').find('input, select, button').prop('disabled', true);
  }

  $('form').on('submit', function () {
    $('.executive-row').each(function () {
      var name = $(this).find('.executive-name-select').val();
      if (!name) { $(this).remove(); }
    });
    $('.retainer-row').each(function () {
      var name = $(this).find('.retainer-name-select').val();
      if (!name) { $(this).remove(); }
    });
  });

  $('input[name="section_type"]').change(function () {
    if ($(this).val() === 'retainer') {
      $('#hiringFields').slideUp();
      $('#hiringFields').find('input, select, button').prop('disabled', true);
      $('#retainerFields').slideDown();
      $('#retainerFields').find('input, select, button').prop('disabled', false);
      $('#jobPostTitle').text('@lang('app.hireRetainers')');
      $('#jobPostHeading i').attr('class', 'fa fa-user-friends mr-2 text-info');
    } else {
      $('#hiringFields').slideDown();
      $('#hiringFields').find('input, select, button').prop('disabled', false);
      $('#retainerFields').slideUp();
      $('#retainerFields').find('input, select, button').prop('disabled', true);
      $('#jobPostTitle').text('@lang('app.hireExecutives')');
      $('#jobPostHeading i').attr('class', 'fa fa-users mr-2 text-success');
    }
  });

  $('#post').change(function () {
    if ($(this).val() === 'Retainer') $('#retainerJoinSection').slideDown();
    else $('#retainerJoinSection').slideUp();
  });
  $('#retainerNameSelect').change(function () {
    $('#retainerMobile').val($(this).find(':selected').data('mobile') || '');
  });
</script>
