<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="https://kactto.com/uploads/all/p2jgTo0PYictPm70zRh4rs3dq8odmeo46Xu02a36.png">

    <!--<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e($globalSetting->favicon_url); ?>">-->
    <link rel="manifest" href="<?php echo e($globalSetting->favicon_url); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e($globalSetting->favicon_url); ?>">
    <meta name="theme-color" content="#ffffff">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/all.min.css')); ?>" defer="defer">

    <!-- Template CSS -->
    <link href="<?php echo e(asset('vendor/froiden-helper/helper.css')); ?>" rel="stylesheet" defer="defer">
    <link type="text/css" rel="stylesheet" media="all" href="<?php echo e(asset('css/main.css')); ?>">

    <title>CRM Kactto</title>


    <?php echo $__env->yieldPushContent('styles'); ?>
    <script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>

    <style defer="defer">
        .login_header {
            background-color: <?php echo e($globalSetting->logo_background_color); ?>         !important;
        }

    </style>
    <?php echo $__env->make('sections.theme_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(file_exists(public_path().'/css/login-custom.css')): ?>
        <link href="<?php echo e(asset('css/login-custom.css')); ?>" rel="stylesheet">
    <?php endif; ?>

    <?php if($globalSetting->sidebar_logo_style == 'full'): ?>
        <style>
            .login_header img {
                max-width: 80px;
            }
        </style>
    <?php endif; ?>
<style>
    .box_login{
        width:550px;
        padding:20px;
    }

    @media (max-width:768px){
        .box_login{
            width:95%;
        }
    }
</style>
</head>

<body
    class="<?php echo e($globalSetting->auth_theme == 'dark' ? 'dark-theme' : ''); ?> <?php echo e(isRtl() ? (session('changedRtl') === false ? '' : 'rtl') : (session('changedRtl') == true ? 'rtl' : '')); ?>">

<header class="px-4 bg-white sticky-top d-flex justify-content-center align-items-center login_header">
    <img class="mr-2 rounded" src="<?php echo e(asset('img/kactto-logo.jpg')); ?>" alt="KACTTO Logo" style="height: 90px !important; max-height: none !important;">
    <!--<h3 class="mb-0 pl-1">-->
    <!--    KACTTO-->
    <!--</h3>-->
</header>



<section class="py-3 bg-grey login_section">
         
         <div>
    <div class="container">
        <div class="row">
            <div class="text-center col-md-12">

                <div class="mx-auto text-center bg-white rounded box_login">
                    <?php echo e($slot); ?>

                </div>

                <?php echo e($outsideLoginBox ?? ''); ?>

                <?php if($languages->count() > 1): ?>
                    <div class="my-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <?php $__currentLoopData = $languages->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="mx-3 my-10 f-12">
                                    <a href="javascript:;" class="text-dark-grey change-lang d-flex align-items-center"
                                       data-lang="<?php echo e($language->language_code); ?>">
                                        <span class="mr-2 flag-icon flag-icon-<?php echo e($language->flag_code === 'en' ? 'gb' : $language->flag_code); ?> flag-icon-squared"></span>
                                        <?php echo e(\App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name); ?>

                                    </a>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($languages->count() > 4): ?>
                                <div class="dropdown" style="z-index:10000">
                                    <a class="btn btn-lg f-14 px-2 py-1 text-dark-grey  rounded dropdown-toggle"
                                       type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                         aria-labelledby="languageDropdown" style="max-height: 600px; overflow-y: auto;">
                                        <?php $__currentLoopData = $languages->slice(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="dropdown-item change-lang" href="javascript:;"
                                               data-lang="<?php echo e($language->language_code); ?>">
                                                <span class="mr-2 flag-icon flag-icon-<?php echo e($language->flag_code === 'en' ? 'gb' : $language->flag_code); ?> flag-icon-squared"></span>
                                                <?php echo e(\App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</section>

<!-- Font Awesome -->
<script src="<?php echo e(asset('vendor/jquery/all.min.js')); ?>" defer="defer"></script>

<!-- Template JS -->
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script>
    document.loading = '<?php echo app('translator')->get('app.loading'); ?>';
    const MODAL_DEFAULT = '#myModalDefault';
    const MODAL_LG = '#myModal';
    const MODAL_XL = '#myModalXl';
    const MODAL_HEADING = '#modelHeading';
    const RIGHT_MODAL = '#task-detail-1';
    const RIGHT_MODAL_CONTENT = '#right-modal-content';
    const RIGHT_MODAL_TITLE = '#right-modal-title';

    const dropifyMessages = {
        default: "<?php echo app('translator')->get('app.dragDrop'); ?>",
        replace: "<?php echo app('translator')->get('app.dragDropReplace'); ?>",
        remove: "<?php echo app('translator')->get('app.remove'); ?>",
        error: "<?php echo app('translator')->get('messages.errorOccured'); ?>",
    };
    $('.change-lang').click(function (event) {
        const locale = $(this).data("lang");
        event.preventDefault();
        let url = "<?php echo e(route('front.changeLang', ':locale')); ?>";
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

<?php echo e($scripts); ?>


</body>

</html>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/components/auth.blade.php ENDPATH**/ ?>