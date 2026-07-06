<x-auth>
    <x-slot name="leftPane">
        <h1 class="f-w-700 mb-4" style="font-size: 2.5rem; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">Take Control of Your Workforce Management</h1>
        <p class="f-16" style="line-height: 1.6; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">Log in to a secure and intuitive HRMS that helps you manage your people, streamline internal processes, track performance, and make data-driven decisions that strengthen your teams and culture.</p>
    </x-slot>

    <style>
        #login-form .form-control {
            background: rgba(255, 255, 255, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
        }
        #login-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        #login-form label, #login-form p, #login-form a, #login-form h3, #login-form .text-light, #login-form h1 {
            color: #fff !important;
        }
        #login-form .btn-primary {
            background-color: #fff !important;
            color: #333 !important;
            border: none !important;
            font-weight: 600 !important;
        }
        #login-form .btn-primary:hover {
            background-color: #f0f0f0 !important;
        }
        #login-form .toggle-password {
            background: rgba(255, 255, 255, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-left: none !important;
            color: #fff !important;
        }
        #login-form .invalid-feedback {
            color: #ffb3b3 !important;
        }
        #login-form input[type="checkbox"] {
            accent-color: #fff;
        }
    </style>

    <form id="login-form" action="{{ route('login') }}" class="ajax-form" method="POST">
        {{ csrf_field() }}
        <h3 class="mb-1 f-w-500">Welcome Back!</h3>
        <p class="mb-4 text-light">Sign in to manage your workforce.</p>

        <script>
            const facebook = "{{ route('social_login', 'facebook') }}";
            const google = "{{ route('social_login', 'google') }}";
            const twitter = "{{ route('social_login', 'twitter-oauth-2') }}";
            const linkedin = "{{ route('social_login', 'linkedin-openid') }}";
        </script>

        @if ($socialAuthSettings->google_status == 'enable')
            <a class="mb-3 height_50 rounded f-w-500" onclick="window.location.href = google;">
                <span><img src="{{ asset('img/google.png') }}" alt="Google"/></span>
                @lang('auth.signInGoogle')</a>
        @endif
        @if ($socialAuthSettings->facebook_status == 'enable')
            <a class="mb-3 height_50 rounded f-w-500" onclick="window.location.href = facebook;">
                <span><img src="{{ asset('img/fb.png') }}" alt="Google"/></span>
                @lang('auth.signInFacebook')
            </a>
        @endif
        @if ($socialAuthSettings->twitter_status == 'enable')
            <a class="mb-3 height_50 rounded f-w-500" onclick="window.location.href = twitter;">
                <span><img src="{{ asset('img/twitter.png') }}" alt="Google"/></span>
                @lang('auth.signInTwitter')
            </a>
        @endif
        @if ($socialAuthSettings->linkedin_status == 'enable')
            <a class="mb-3 height_50 rounded f-w-500" onclick="window.location.href = linkedin;">
                <span><img src="{{ asset('img/linkedin.png') }}" alt="Google"/></span>
                @lang('auth.signInLinkedin')
            </a>
        @endif

        @if ($socialAuthSettings->social_auth_enable)
            <p class="position-relative my-4">@lang('auth.useEmail')</p>
        @endif

        <div class="form-group text-left">
            <label for="email">@lang('auth.email')</label>
            <input tabindex="1" type="email" name="email"
                   class="form-control height-50 f-15 light_text @error('email') is-invalid @enderror"
                   autofocus
                   value="{{request()->old('email')}}"
                   placeholder="example@gmail.com" id="email">
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
            @if ($socialAuthSettings->social_auth_enable_count>1)
                <div class="forgot_pswd mt-2" id="forget-pass-email-section">
                    <a href="{{ url('forgot-password') }}">@lang('app.forgotPassword')</a>
                </div>
            @endif
        </div>

        @if ($socialAuthSettings->social_auth_enable_count>1 && !$errors->has('g-recaptcha-response'))
            <button type="submit" id="submit-next"
                    class="btn-primary f-w-500 rounded w-100 height-50 f-18"> @lang('auth.next') <i
                    class="fa fa-arrow-right pl-1"></i></button>

            @if ($company->allow_client_signup)
                <a href="{{ route('register') }}" id="signup-client-next"
                   class="btn-secondary f-w-500 rounded w-100 height-50 f-15 mt-3">
                    @lang('app.signUpAsClient')
                </a>
            @endif

        @endif

        <div id="password-section"
             @if ($socialAuthSettings->social_auth_enable_count > 1 && !$errors->has('g-recaptcha-response')) class="d-none" @endif>
            <div class="form-group text-left">
                <label for="password">@lang('app.password')</label>
                <x-forms.input-group>
                    <input type="password" name="password" id="password"
                           placeholder="@lang('placeholders.password')" tabindex="3"
                           class="form-control height-50 f-15 light_text @error('password') is-invalid @enderror">

                    <x-slot name="append">
                        <button type="button" data-toggle="tooltip"
                                data-original-title="@lang('app.viewPassword')"
                                class="btn btn-outline-secondary border-grey height-50 toggle-password">
                            <i
                                class="fa fa-eye"></i></button>
                    </x-slot>

                </x-forms.input-group>
                @if ($errors->has('password'))
                    <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-group text-left mb-0">
                    <input id="checkbox-signup" class="cursor-pointer" type="checkbox" name="remember">
                    <label for="checkbox-signup" class="cursor-pointer mb-0">@lang('app.rememberMe')</label>
                </div>
                <div class="forgot_pswd">
                    <a href="{{ url('forgot-password') }}" class="text-decoration-underline" style="text-underline-offset: 3px;">@lang('app.forgotPassword')</a>
                </div>
            </div>

            @if ($globalSetting->google_recaptcha_status == 'active')
                <div class="form-group" id="captcha_container"></div>
            @endif

            <input type="hidden" id="g_recaptcha" name="g_recaptcha">

            @if ($errors->has('g-recaptcha-response'))
                <div
                    class="invalid-feedback  d-block text-left">{{ $errors->first('g-recaptcha-response') }}
                </div>
            @endif

            <button type="submit" id="submit-login"
                    class="btn-primary f-w-500 rounded w-100 height-50 f-18">
                @lang('app.login') <i class="fa fa-arrow-right pl-1"></i>
            </button>

            @if ($company->allow_client_signup)
                <a href="{{ route('register') }}"
                   class="btn-secondary f-w-500 rounded w-100 height-50 f-15 mt-3">
                    @lang('app.signUpAsClient')
                </a>
            @endif
        </div>

        <input type="hidden" name="locale" value="{{ session()->has('locale') ? session('locale') : global_setting()->locale }}">
        <input type="hidden" id="current-latitude" name="current_latitude">
        <input type="hidden" id="current-longitude" name="current_longitude">
    </form>

    <x-slot name="scripts">

        <script>
            @if (isWorksuite() && ($company->attendance_status == 'active' && ($company->attendance_setting->radius_check == 'yes' || $company->attendance_setting->save_current_location == 'yes') ))
                function setCurrentLocation() {
                    const currentLatitude = document.getElementById("current-latitude");
                    const currentLongitude = document.getElementById("current-longitude");

                    function getLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showPosition);
                        }
                    }

                    function showPosition(position) {
                        currentLatitude.value = position.coords.latitude;
                        currentLongitude.value = position.coords.longitude;
                    }
                    getLocation();

                }
                setCurrentLocation();
            @endif
        </script>

        @if ($globalSetting->google_recaptcha_status == 'active' && $globalSetting->google_recaptcha_v2_status == 'active')
            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async
                    defer></script>
            <script>
                var gcv3;
                var onloadCallback = function () {
                    // Renders the HTML element with id 'captcha_container' as a reCAPTCHA widget.
                    // The id of the reCAPTCHA widget is assigned to 'gcv3'.
                    gcv3 = grecaptcha.render('captcha_container', {
                        'sitekey': '{{ $globalSetting->google_recaptcha_v2_site_key }}',
                        'theme': 'light',
                        'callback': function (response) {
                            if (response) {
                                $('#g_recaptcha').val(response);
                            }
                        },
                    });
                };
            </script>
        @endif
        @if ($globalSetting->google_recaptcha_status == 'active' && $globalSetting->google_recaptcha_v3_status == 'active')
            <script
                src="https://www.google.com/recaptcha/api.js?render={{ $globalSetting->google_recaptcha_v3_site_key }}"></script>
            <script>
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ $globalSetting->google_recaptcha_v3_site_key }}').then(function (token) {
                        // Add your logic to submit to your backend server here.
                        $('#g_recaptcha').val(token);
                    });
                });
            </script>
        @endif

        <script>

            $(document).ready(function () {

                $("form#login-form").submit(function () {
                    const button = $('form#login-form').find('#submit-login');

                    const text = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{__('app.loading')}}';

                    button.prop("disabled", true);
                    button.html(text);
                });

                function handleFormSubmit(e) {
                    e.preventDefault();
                }

                $('#submit-next').click(function (event) {
                    event.preventDefault();
                    document.addEventListener('click', handleFormSubmit, false);

                    const url = "{{ route('check_email') }}";
                    $.easyAjax({
                        url: url,
                        container: '#login-form',
                        disableButton: true,
                        buttonSelector: "#submit-next",
                        type: "POST",
                        data: $('#login-form').serialize(),
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#submit-next, #signup-client-next').remove();
                                $('#password-section').removeClass('d-none');
                                $('#forget-pass-email-section').remove();
                                $("#password").focus();
                                document.removeEventListener('click', handleFormSubmit);
                            }
                        }
                    })
                });

                @if (session('message'))
                Swal.fire({
                    icon: 'error',
                    text: '{{ session('message') }}',
                    showConfirmButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                })
                @endif

            });
        </script>
    </x-slot>

</x-auth>
