<?php $__env->startSection('title', trans('installer_messages.requirements.title')); ?>
<?php $__env->startSection('container'); ?>
    <ul class="list">
        <li class="list__item <?php echo e($phpSupportInfo['supported'] ? 'success' : 'error'); ?>">PHP Version >=
            <?php echo e($phpSupportInfo['minimum']); ?> <i
                class="fa fa-fw fa-<?php echo e($phpSupportInfo['supported'] ? 'check-circle-o' : 'exclamation-circle'); ?> row-icon"
                aria-hidden="true"></i></li>

        <?php $__currentLoopData = $requirements['requirements']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extention => $enabled): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list__item <?php echo e($enabled ? 'success' : 'error'); ?>"><?php echo e($extention); ?> <i
                    class="fa fa-fw fa-<?php echo e($enabled ? 'check-circle-o' : 'exclamation-circle'); ?> row-icon"
                    aria-hidden="true"></i></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php if(!isset($requirements['errors']) && $phpSupportInfo['supported'] == 'success'): ?>
        <div class="buttons">
            <a class="button" href="<?php echo e(route('LaravelInstaller::permissions')); ?>">
                <?php echo e(trans('installer_messages.next')); ?>

            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('installer/js/jQuery-2.2.0.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/vendor/installer/requirements.blade.php ENDPATH**/ ?>