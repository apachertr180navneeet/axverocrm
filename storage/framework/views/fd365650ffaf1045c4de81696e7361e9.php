<form name="payuForm" action="<?php echo e(config('services.payu.url')); ?>" method="POST">
  <input type="hidden" name="key" value="<?php echo e($key); ?>">
  <input type="hidden" name="txnid" value="<?php echo e($submission->txnid); ?>">
  <input type="hidden" name="amount" value="<?php echo e($submission->amount); ?>">
  <input type="hidden" name="productinfo" value="Form Payment">
  <input type="hidden" name="firstname" value="<?php echo e($user->name); ?>">
  <input type="hidden" name="email" value="<?php echo e($user->email); ?>">
  <input type="hidden" name="hash" value="<?php echo e($hash); ?>">
  <input type="hidden" name="surl" value="<?php echo e(route('payu.success')); ?>">
  <input type="hidden" name="furl" value="<?php echo e(route('payu.failure')); ?>">
</form>

<script>
  document.payuForm.submit();
</script><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/hiring/payu_redirect.blade.php ENDPATH**/ ?>