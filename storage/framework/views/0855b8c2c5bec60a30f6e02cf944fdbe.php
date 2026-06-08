            
            
            <?php $__env->startSection('content'); ?>
            
            <div class="container mt-4">
            
            <!--<h4 class="mb-4">HR Executive Reports</h4>-->
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Executive Report</h4>

                <a href="<?php echo e(route('hr.executive.report')); ?>" 
                   class="btn btn-primary btn-sm">
                   + Add New
                </a>
          
            </div>
            
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
            
            <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>HR Manager</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
            
            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($report->report_date->format('d/m/Y')); ?></td>
                <td><?php echo e($report->name); ?></td>
                <td><?php echo e($report->mobile); ?></td>
                <td><?php echo e($report->hr_manager_name); ?></td>
                <td>
                    <a href="<?php echo e(route('hr.executive.report.pdf',$report->id)); ?>"
                       class="btn btn-sm btn-primary">
                       View More
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
            <td colspan="5" class="text-center">No Reports Found</td>
            </tr>
            <?php endif; ?>
            
            </tbody>
            </table>
            </div>
            
            <?php echo e($reports->links()); ?>

            
            </div>
            
            <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/hr-report-list.blade.php ENDPATH**/ ?>