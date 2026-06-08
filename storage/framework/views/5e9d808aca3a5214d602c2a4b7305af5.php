<a href="<?php echo e($link); ?>" <?php echo e($attributes->merge(['class' => 'btn btn-secondary rounded f-14 p-2'])); ?>>
    <?php if($icon != ''): ?>
        <i class="fa fa-<?php echo e($icon); ?> mr-1"></i>
    <?php endif; ?>
    <?php echo e($slot); ?>

</a>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/components/forms/link-secondary.blade.php ENDPATH**/ ?>