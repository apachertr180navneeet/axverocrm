<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $globalSetting->favicon_url }}">
    <link rel="manifest" href="{{ $globalSetting->favicon_url }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ $globalSetting->favicon_url }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/all.min.css') }}" defer="defer">

    <!-- Template CSS -->
    <link href="{{ asset('vendor/froiden-helper/helper.css') }}" rel="stylesheet" defer="defer">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('css/main.css') }}">

    <title>CRM Axvero</title>


    @stack('styles')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    @include('sections.theme_css')
    @if(file_exists(public_path().'/css/login-custom.css'))
        <link href="{{ asset('css/login-custom.css') }}" rel="stylesheet">
    @endif
    <style>
        .auth-bg {
            background: url('{{ asset('img/login-bg.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-container {
            display: flex;
            background: rgba(40, 40, 40, 0.4);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 20px;
            color: #fff;
        }
        .glass-left {
            flex: 1;
            padding: 40px;
            background: rgba(80, 100, 60, 0.4); /* Greenish overlay */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .glass-right {
            flex: 1;
            padding: 40px;
            background: rgba(30, 30, 30, 0.6); /* Darker grey overlay */
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .glass-logo {
            height: 80px;
            margin-bottom: 20px;
            object-fit: contain;
        }
        
        @media (max-width: 768px) {
            .glass-container {
                flex-direction: column;
                width: 95%;
            }
            .glass-left {
                display: none; 
            }
            .glass-right {
                padding: 20px;
            }
        }
    </style>
</head>

<body
    class="{{ $globalSetting->auth_theme == 'dark' ? 'dark-theme' : '' }} {{ isRtl() ? (session('changedRtl') === false ? '' : 'rtl') : (session('changedRtl') == true ? 'rtl' : '') }}">

<section class="auth-bg">
    <div class="glass-container">
        @if(isset($leftPane))
            <div class="glass-left">
                {{ $leftPane }}
            </div>
        @endif
        <div class="glass-right @if(!isset($leftPane)) w-100 @endif">
            <div class="w-100 d-flex justify-content-center">
                <img class="glass-logo" src="{{ asset('img/axvero-logo-white.jpeg') }}" alt="Logo">
            </div>
            
            {{ $slot }}

            {{ $outsideLoginBox ?? '' }}
            
            @if($languages->count() > 1)
                <div class="my-3 d-flex flex-column flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        @foreach($languages->take(4) as $index => $language)
                            <span class="mx-3 my-10 f-12">
                                <a href="javascript:;" class="text-white change-lang d-flex align-items-center"
                                   data-lang="{{ $language->language_code }}">
                                    <span class="mr-2 flag-icon flag-icon-{{ $language->flag_code === 'en' ? 'gb' : $language->flag_code }} flag-icon-squared"></span>
                                    {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name }}
                                </a>
                            </span>
                        @endforeach

                        @if($languages->count() > 4)
                            <div class="dropdown" style="z-index:10000">
                                <a class="btn btn-lg f-14 px-2 py-1 text-white rounded dropdown-toggle"
                                   type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                     aria-labelledby="languageDropdown" style="max-height: 600px; overflow-y: auto;">
                                    @foreach($languages->slice(4) as $language)
                                        <a class="dropdown-item change-lang" href="javascript:;"
                                           data-lang="{{ $language->language_code }}">
                                            <span class="mr-2 flag-icon flag-icon-{{ $language->flag_code === 'en' ? 'gb' : $language->flag_code }} flag-icon-squared"></span>
                                            {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Font Awesome -->
<script src="{{ asset('vendor/jquery/all.min.js') }}" defer="defer"></script>

<!-- Template JS -->
<script src="{{ asset('js/main.js') }}"></script>
<script>
    document.loading = '@lang('app.loading')';
    const MODAL_DEFAULT = '#myModalDefault';
    const MODAL_LG = '#myModal';
    const MODAL_XL = '#myModalXl';
    const MODAL_HEADING = '#modelHeading';
    const RIGHT_MODAL = '#task-detail-1';
    const RIGHT_MODAL_CONTENT = '#right-modal-content';
    const RIGHT_MODAL_TITLE = '#right-modal-title';

    const dropifyMessages = {
        default: "@lang('app.dragDrop')",
        replace: "@lang('app.dragDropReplace')",
        remove: "@lang('app.remove')",
        error: "@lang('messages.errorOccured')",
    };
    $('.change-lang').click(function (event) {
        const locale = $(this).data("lang");
        event.preventDefault();
        let url = "{{ route('front.changeLang', ':locale') }}";
        url = url.replace(':locale', locale);
        $.easyAjax({
            url: url,
            container: '#login-form',
            blockUI: true,
            type: "GET",
            success: function (response) {
                if (response.status === 'success') {
                    window.location.reload();
                }
            }
        })
    });
</script>

{{ $scripts }}

</body>

</html>
