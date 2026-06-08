

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
<div class="container-fluid">

<div class="bg-white p-3 p-md-4 rounded shadow-sm">

    
<div class="row mb-3 align-items-center">

    <div class="col-md-6 col-12">
        <h4 class="mb-0">Sales Executive Report List</h4>
    </div>

    <div class="col-md-6 col-12 text-md-right mt-2 mt-md-0">
        <a href="<?php echo e(route('sales-executive')); ?>"
           class="btn btn-danger btn-sm">
            <i class="fas fa-plus mr-1"></i> Add New Report
        </a>
    </div>

</div>

    <hr>

    
    <form method="GET" action="<?php echo e(route('sales-executive.list')); ?>">
        <div class="form-row">

            <div class="col-12 col-md-2 mb-2">
                <input type="text" name="name"
                       value="<?php echo e(request('name')); ?>"
                       class="form-control"
                       placeholder="Name">
            </div>

            <div class="col-12 col-md-2 mb-2">
                <input type="text" name="mobile"
                       value="<?php echo e(request('mobile')); ?>"
                       class="form-control"
                       placeholder="Mobile">
            </div>

            <div class="col-12 col-md-2 mb-2">
                <input type="text" name="portal_id"
                       value="<?php echo e(request('portal_id')); ?>"
                       class="form-control"
                       placeholder="Portal ID">
            </div>

            <div class="col-12 col-md-2 mb-2">
                <input type="text" name="manager_name"
                       value="<?php echo e(request('manager_name')); ?>"
                       class="form-control"
                       placeholder="Manager Name">
            </div>

            <div class="col-6 col-md-2 mb-2">
                <input type="date" name="from_date"
                       value="<?php echo e(request('from_date')); ?>"
                       class="form-control">
            </div>

            <div class="col-6 col-md-2 mb-2">
                <input type="date" name="to_date"
                       value="<?php echo e(request('to_date')); ?>"
                       class="form-control">
            </div>

            <div class="col-12 mt-2">
                <div class="d-flex flex-column flex-md-row">
                    <button type="submit" class="btn btn-primary mr-md-2 mb-2 mb-md-0">
                        Filter
                    </button>

                    <a href="<?php echo e(route('sales-executive.list')); ?>"
                       class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>

        </div>
    </form>

    <hr>

    
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover mb-0">

            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Portal ID</th>
                    <th>Manager Name</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($reports->firstItem() + $key); ?></td>
                        <td><?php echo e($report->name); ?></td>
                        <td><?php echo e($report->mobile); ?></td>
                        <td><?php echo e($report->portal_id); ?></td>
                        <td><?php echo e($report->manager_name); ?></td>
                        <td><?php echo e($report->created_at->format('d-m-Y')); ?></td>
                        <td>
                            <a href="<?php echo e(route('sales-executive.pdf', $report->id)); ?>"
                               class="btn btn-sm btn-success btn-block btn-md-inline">
                                <i class="fas fa-download mr-1"></i> PDF
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            No Records Found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    
    <div class="mt-3">
        <?php echo e($reports->appends(request()->query())->links()); ?>

    </div>

</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/sales-executive-list.blade.php ENDPATH**/ ?>