<button type="button" <?php if($disabled): ?> disabled <?php endif; ?> <?php echo e($attributes->merge(['class' => 'btn-primary rounded f-14 p-2'])); ?>>
    <?php if($icon != ''): ?>
        <i class="fa fa-<?php echo e($icon); ?> mr-1"></i>
    <?php endif; ?>
    <?php echo e($slot); ?>

</button>

<?php echo $__env->make('sections.password-autocomplete-hide', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/components/forms/button-primary.blade.php ENDPATH**/ ?>