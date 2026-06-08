<?php $__env->startSection('content'); ?>
  <div class="content-wrapper">
    <div class="add-client bg-white rounded text-center py-5">
      <div class="row p-20">
        <div class="col-sm-12">
          <i class="fa fa-times-circle fa-5x text-danger mb-4"></i>
          <h2 class="f-21 font-weight-normal"><?php echo app('translator')->get('app.paymentFailed'); ?></h2>
          <p class="text-muted"><?php echo app('translator')->get('messages.paymentFailedDesc'); ?></p>
          <a href="<?php echo e(route('executive-retainer.create')); ?>" class="btn btn-warning rounded f-14 p-2">
            <i class="fa fa-redo mr-1"></i> <?php echo app('translator')->get('app.tryAgain'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/executive-retainer/failure.blade.php ENDPATH**/ ?>