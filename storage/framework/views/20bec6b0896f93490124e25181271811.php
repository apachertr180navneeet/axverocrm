        
        
        <?php $__env->startPush('styles'); ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
        .table-responsive {
            overflow-x: auto;
        }
        </style>
        <?php $__env->stopPush(); ?>
        
        
        <?php $__env->startSection('content'); ?>
        <div class="content-wrapper">
        <div class="container-fluid">
        
        <div class="bg-white p-4 rounded">
        
            
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h4 class="mb-2"><?php echo e($pageTitle ?? 'Report Manager'); ?></h4>
                <a href="<?php echo e(route('dailyreport')); ?>" class="btn btn-primary btn-sm">
                        + Create New
                        </a>
            
            </div>
        
            
            <?php if(session('success')): ?>
                <div id="success-alert" class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>
        
            
<div class="d-none d-md-block">
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <!--<th>Total Sales Executive</th>-->
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($reports->firstItem() + $key); ?></td>
                    <td><?php echo e($report->report_date); ?></td>
                    <td><?php echo e($report->portal_email); ?></td>
                    <td><?php echo e($report->name); ?></td>
                    <td><?php echo e($report->mobile); ?></td>
                    <!--<td><?php echo e($report->total_joined_retainer); ?></td>-->
                    <td>
                        <a href="<?php echo e(route('daily-report.pdf', $report->id)); ?>"
                           class="btn btn-secondary btn-sm">
                           PDF
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">No reports found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<div class="d-block d-md-none">
    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body p-3">

                <p class="mb-1"><strong>Date:</strong><br>
                    <?php echo e($report->report_date); ?>

                </p>

                <p class="mb-1"><strong>Email:</strong><br>
                    <?php echo e($report->portal_email); ?>

                </p>

                <p class="mb-1"><strong>Name:</strong><br>
                    <?php echo e($report->name); ?>

                </p>

                <p class="mb-1"><strong>Mobile:</strong><br>
                    <?php echo e($report->mobile); ?>

                </p>

                <p class="mb-2"><strong>Total Retainer:</strong><br>
                    <?php echo e($report->total_joined_retainer); ?>

                </p>

                <a href="<?php echo e(route('daily-report.pdf', $report->id)); ?>"
                   class="btn btn-secondary btn-block">
                   Download PDF
                </a>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center">No reports found</div>
    <?php endif; ?>
</div>
        
            
            <div class="mt-3">
                <?php echo e($reports->links()); ?>

            </div>
        
        </div>
        </div>
        </div>
        <?php $__env->stopSection(); ?>
        
        
        <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
        $(document).ready(function() {
            setTimeout(function() {
                let alertBox = $('#success-alert');
                if(alertBox.length){
                    alertBox.fadeOut('slow');
                }
            }, 3000);
        });
        </script>
        <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/daily-report-list.blade.php ENDPATH**/ ?>