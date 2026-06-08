<form name="payuForm" action="<?php echo e(config('services.payu.url')); ?>" method="POST">
  <input type="hidden" name="key" value="<?php echo e($key); ?>">
  <input type="hidden" name="txnid" value="<?php echo e($application->txnid); ?>">
  <input type="hidden" name="amount" value="<?php echo e($application->amount); ?>">
  <input type="hidden" name="productinfo" value="Executive Retainer Fee">
  <input type="hidden" name="firstname" value="<?php echo e($user->name); ?>">
  <input type="hidden" name="email" value="<?php echo e($user->email); ?>">
  <input type="hidden" name="hash" value="<?php echo e($hash); ?>">
  <input type="hidden" name="surl" value="<?php echo e(route('executive-retainer.payment.success')); ?>">
  <input type="hidden" name="furl" value="<?php echo e(route('executive-retainer.payment.failure')); ?>">
</form>
<script>document.payuForm.submit();</script><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/executive-retainer/payu_redirect.blade.php ENDPATH**/ ?>