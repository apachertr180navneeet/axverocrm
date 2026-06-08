<?php $__env->startSection('title', trans('installer_messages.final.title')); ?>
<?php $__env->startSection('container'); ?>
    <p class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'alert alert-success',
            'alert-danger'=> session()->has('message') && session('message')['status'] !=='success',
        ]); ?>"
       style="text-align: center;"><?php echo e(session()->has('message')? session('message')['message']:trans('installer_messages.final.finished')); ?></p>
    <div class="buttons">
        <a href="<?php echo e(url('/')); ?>" class="button"><?php echo e(trans('installer_messages.final.exit')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/vendor/installer/finished.blade.php ENDPATH**/ ?>