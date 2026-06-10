<div class="table-responsive">

<table class="table-simple">
    <thead>
        <tr>
            <th>#</th>
            <th>Senior Name</th>
            <th>Mobile</th>
            <th>Portal ID</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

    <?php $__empty_1 = true; $__currentLoopData = $refferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <tr>
            <td>
                <?php echo e(($refferences->currentPage() - 1) * $refferences->perPage() + $loop->iteration); ?>

            </td>

            <td><?php echo e($row->senior_name); ?></td>

            <td><?php echo e($row->senior_mobile); ?></td>

            <td><?php echo e($row->user_id); ?></td>

            <td>
                <a href="<?php echo e(route('refference.pdf', $row->id)); ?>" target="_blank" class="pdf-btn">
                    PDF
                </a>
            </td>
        </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5">No data found</td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>

</div>


<?php if($refferences->hasPages()): ?>
<div class="mt-2">
    <?php echo e($refferences->links()); ?>

</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/refference/list_table.blade.php ENDPATH**/ ?>