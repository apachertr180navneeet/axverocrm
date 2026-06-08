<?php $__env->startSection('style'); ?>
    <style>
        .button.disabled {
            pointer-events: none;
            cursor: not-allowed;
            background: #c2c2c2;
        }
        .hide{
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', trans('installer_messages.permissions.title')); ?>
<?php $__env->startSection('container'); ?>
    <?php if(isset($permissions['errors'])): ?>
        <div class="alert alert-danger">Please fix the below error and then click
            <?php echo e(trans('installer_messages.checkPermissionAgain')); ?></div>
    <?php endif; ?>
    <ul class="list">
        <?php $__currentLoopData = $permissions['permissions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list__item list__item--permissions <?php echo e($permission['isSet'] ? 'success' : 'error'); ?>">
                <?php echo e($permission['folder']); ?>

                <span>
                    <i class="fa fa-fw fa-<?php echo e($permission['isSet'] ? 'check-circle-o' : 'exclamation-circle'); ?>"></i>
                    <?php echo e($permission['permission']); ?>

                </span>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul>

    <?php if(isset($permissions['errors'])): ?>
        <span>If you have terminal access, run the following command on terminal</span>
        <p style="background: #f7f7f9;padding: 10px;">
            chmod -R 775 storage/app/ storage/framework/ storage/logs/ bootstrap/cache/
        </p>
    <?php endif; ?>

    <div class="buttons">
        <ul  class="hide" id="messageWait">
            <ol>Please wait a few moments as the application prepares for you. </ol>
        </ul>
        <?php if(!isset($permissions['errors'])): ?>
            <a class="button" href="<?php echo e(route('LaravelInstaller::database')); ?>">
                <?php echo e(trans('installer_messages.next')); ?>

            </a>
        <?php else: ?>

            <a class="button" href="javascript:window.location.href='';">
                <?php echo e(trans('installer_messages.checkPermissionAgain')); ?>

            </a>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('installer/js/jQuery-2.2.0.min.js')); ?>"></script>

    <script>
        $('.button').click(function () {
            const button = $('.button');

            const text = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting..';

            $(button).addClass('disabled');
            $('#messageWait').show()
            button.html(text);
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('vendor.installer.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/vendor/installer/permissions.blade.php ENDPATH**/ ?>