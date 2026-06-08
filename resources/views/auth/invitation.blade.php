
<x-auth>
    <x-form  id="acceptInviteForm">
        <input type="hidden" name="send_mail_to_admin" value="yes">

        <h3 class=" mb-4 f-w-500">@lang('app.signUp')</h3>

        <div class="alert alert-success m-t-10 d-none" id="success-msg"></div>
            <div class=" text-left text-primary">
                <p>Employee Id - {{$lastEmployeeID+1}}</p>
            </div>
        <div class="group">
            <div class="form-group text-left">
                <label for="user-name">@lang('modules.employees.fullName')<sup
                        class="f-14">*</sup></label>
                <input type="text" name="name" class="form-control height-50 f-15 light_text"
                       placeholder="@lang('placeholders.name')" id="user-name">
            </div>

            @if (!is_null($invite->email_restriction))
                <div class="form-group text-left">
                    <x-forms.label fieldId="user-email" :fieldLabel="__('app.email')">
                    </x-forms.label>
                    <x-forms.input-group>
                        <input type="text" name="email_address" id="email_address"
                               class="form-control height-50 f-15 light_text">
                        <x-slot name="append">
                        <span class="input-group-text height-50 border bg-white">

                            {{$lastEmployeeID+1}}{{ '@'.$invite->email_restriction }}</span>
                        </x-slot>
                    </x-forms.input-group>
                    <input type="hidden" name="email_domain" id="email_domain"
                           value="{{$lastEmployeeID+1}}{{ '@'.$invite->email_restriction }}">
                    <input type="hidden" name="email" id="user-email">
                </div>
            @else
                <div class="form-group text-left">
                    <label for="user-email">@lang('app.email')<sup class="f-14">*</sup></label>
                    <input type="email" name="email" class="form-control height-50 f-15 light_text"
                           placeholder="@lang('placeholders.email')" id="user-email">
                </div>
            @endif

            <div class="row">

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile"
                   class="form-control height-50 f-15 light_text"
                   id="mobile" placeholder="Enter mobile number">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="joining_date">Joining Date</label>
            <input type="date" name="joining_date"
                   class="form-control height-50 f-15 light_text"
                   id="joining_date"
                   value="{{ now()->format('Y-m-d') }}" >
        </div>
    </div>

</div>


<div class="row">

   <div class="col-md-6">
    <div class="form-group text-left">
        <label for="department">Department</label>

        <select class="form-control height-50 f-15 light_text" id="department" >
            
            
    @if($invite->department_id == 5)
        <option value="5" selected>
            Human Resource
        </option>
    @else
        <option value="6" {{ $invite->department_id == 6 ? 'selected' : '' }}>
            Retainer Sales & Marketing
        </option>

        <option value="7" {{ $invite->department_id == 7 ? 'selected' : '' }}>
            Retainer Sales
        </option>
    @endif
            <!--<option value="5" {{ $invite->department_id == 5 ? 'selected' : '' }}>-->
            <!--    Human Resource-->
            <!--</option>-->
            

            <!--<option value="6" {{ $invite->department_id == 6 ? 'selected' : '' }}>-->
            <!--    Retainer Sales & Marketing-->
            <!--</option>-->
            
            <!--   <option value="7" {{ $invite->department_id == 7 ? 'selected' : '' }}>-->
            <!--    Retainer Sales-->
            <!--</option>-->
            
        </select>

        <!-- Actual value that will be submitted -->
        <input type="hidden" name="department" value="{{ $invite->department_id }}">
    </div>
</div>

    <div class="col-md-6">
    <div class="form-group text-left">
        <label for="designation">Designation</label>

        <select class="form-control height-50 f-15 light_text"
                id="designation" name="designation">

         
    @if($invite->department_id == 5)

        <option value="49" {{ $invite->designation_id == 49 ? 'selected' : '' }}>
            Hr Executive
        </option>

        <option value="48" {{ $invite->designation_id == 48 ? 'selected' : '' }}>
            HR Manager
        </option>

    @else

        <option value="47" {{ $invite->designation_id == 47 ? 'selected' : '' }}>
            Retainer Relationship Manager
        </option>

        <option value="52" {{ $invite->designation_id == 52 ? 'selected' : '' }}>
            Retainer
        </option>

        <option value="58" {{ $invite->designation_id == 58 ? 'selected' : '' }}>
            Sales Executive
        </option>

        <option value="45" {{ $invite->designation_id == 45 ? 'selected' : '' }}>
            Sales Manager
        </option>

    @endif
            
         

        </select>

        <!-- Hidden input so value gets submitted -->
        {{-- <input type="hidden" name="designation" value="{{ $invite->designation_id }}"> --}}
    </div>
</div>

</div>


<div class="row">

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="dob">Date of Birth</label>
            <input type="date" name="date_of_birth"
                   class="form-control height-50 f-15 light_text"
                   id="dob">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="marital_status">Marital Status</label>
            <select name="marital_status"
                    class="form-control height-50 f-15 light_text"
                    id="marital_status">
                <option value="">Select Status</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="widowed">Widowed</option>
                <option value="divorced">Divorced</option>
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="reporting_to">Reporting To</label>
            <select name="reporting_to" 
                    id="reporting_to" 
                    class="form-control height-50 f-15 light_text select-picker" 
                    data-live-search="true"
                    data-size="8">
                <option value="">-- Select Reporting Person --</option>
                @foreach ($employees as $item)
                    <x-user-option :user="$item" />
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="salary">Salary</label>
            <input type="number" 
                   name="salary" 
                   id="salary" 
                   class="form-control height-50 f-15 light_text" 
                   placeholder="Enter Salary">
        </div>
    </div>
</div>
<div class="form-group text-left">
    <label for="address">Address</label>
    <textarea name="address"
              id="address"
              rows="3"
              class="form-control f-15 light_text"
              placeholder="Enter address"></textarea>
</div>


            <div class="form-group text-left">
                <label for="password">@lang('app.password')<sup class="f-14">*</sup></label>
                <input type="text" name="password" class="form-control height-50 f-15 light_text"
                       placeholder="@lang('placeholders.password')" id="password" value="Axveronew@2026#" readonly>
            </div>

            @if ($globalSetting->sign_up_terms == 'yes')
                <div class="form-group text-left" >
                    <input autocomplete="off" id="read_agreement"
                        name="terms_and_conditions" type="checkbox" >
                    <label for="read_agreement">@lang('app.acceptTerms') <a href="{{ $globalSetting->terms_link }}" target="_blank" id="terms_link" >@lang('app.termsAndCondition')</a></label>
                </div>
            @endif

            <button type="button" id="submit-signup"
                    class="btn-primary f-w-500 rounded w-100 height-50 f-18">
                @lang('app.signUp') <i class="fa fa-arrow-right pl-1"></i>
            </button>
        </div>
        <div class="forgot_pswd mt-3">
            <a href="{{ route('login') }}" class="justify-content-center">@lang('app.login')</a>
        </div>
        <input type="hidden" name="locale" value="{{ session()->has('locale') ? session('locale') : global_setting()->locale }}">
    </x-form>

    <x-slot name="scripts">
        <script>
            $('#email_address').change(function () {
                var email = $('#email_address').val() + $('#email_domain').val();
                $('#user-email').val(email);
            });

            $('#submit-signup').click(function () {
                console.log($('#acceptInviteForm').serialize());
                var url = "{{ route('accept_invite') . '?invite=' . $invite->invitation_code }}";
                $.easyAjax({
                    url: url,
                    container: '#acceptInviteForm',
                    disableButton: true,
                    buttonSelector: "#submit-signup",
                    type: "POST",
                    blockUI: true,
                    messagePosition: 'inline',
                    data: $('#acceptInviteForm').serialize(),
                    success: function (response) {
                        $('#success-msg').removeClass('d-none');
                        $('#success-msg').html(response.message);
                        $('.group').remove();
                        setTimeout(() => {
                            window.location.href = "{{ route('dashboard') }}"
                        }, 20000);
                    },
                })
            });

         $('#user-name').on('keyup change', function () {

    let name = $(this).val();   // original name

    let emailName = name.toLowerCase();      // lowercase
    emailName = emailName.replace(/\s+/g,''); // remove spaces

    $('#email_address').val(emailName);
       let email = emailName + $('#email_domain').val();

    $('#user-email').val(email);

});
$(document).ready(function () {
    $('#reporting_to').selectpicker('destroy'); // pehle destroy karo agar pehle se laga ho
    $('#reporting_to').selectpicker({
        liveSearch: true,
        liveSearchPlaceholder: 'Search...',
        size: 8
    });
});
        </script>
    </x-slot>

</x-auth>
