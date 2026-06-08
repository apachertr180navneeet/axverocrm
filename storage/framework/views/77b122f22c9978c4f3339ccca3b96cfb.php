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
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/components/table.blade.php ENDPATH**/ ?>