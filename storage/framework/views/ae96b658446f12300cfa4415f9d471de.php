<table <?php echo e($attributes->merge(['class' => 'table', 'id' => 'example' ])); ?>>
    <?php if(isset($thead)): ?>
        <thead class="<?php echo e($headType); ?>">
            <tr>
                <?php echo $thead; ?>

            </tr>
        </thead>
    <?php endif; ?>
    <tbody>
        <?php echo e($slot); ?>

    </tbody>
    <?php if(isset($tfoot)): ?>
        <tfoot>
            <?php echo e($tfoot); ?>

        </tfoot>
    <?php endif; ?>
</table>
<?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/components/table.blade.php ENDPATH**/ ?>