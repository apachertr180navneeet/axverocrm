<div class="taskEmployeeImg rounded-circle mr-1">
    <a href="<?php echo e(route('employees.show', $user->id)); ?>">
        <img data-toggle="tooltip" data-original-title="<?php echo e($user->name); ?>"
            src="<?php echo e($user->image_url); ?>">
    </a>
</div>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/components/employee-image.blade.php ENDPATH**/ ?>