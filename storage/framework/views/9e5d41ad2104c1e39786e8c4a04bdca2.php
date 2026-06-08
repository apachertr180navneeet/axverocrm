

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">
        <div class="m-3">
            
            <a href="<?php echo e(route('employee.reports.assigned')); ?>" 
               class="btn btn-info btn-sm">
                View Assigned Reports
            </a>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>Employee</th>
                    <th>Manager</th>
                    <th>Report Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($report->user->name); ?></td>
                        <td><?php echo e($report->reportingPerson->name ?? 'N/A'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A')); ?></td>
                        <td class="d-flex">
                            
                            <?php if($report->report_description): ?>
                                <a href="<?php echo e(route('employee.report.details', $report->id)); ?>"
                                   class="btn btn-sm btn-outline-danger mr-1">
                                    Report Details
                                </a>
                            <?php endif; ?>
                            
                            <?php if($report->file): ?>
                                <a href="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo e(url($report->file)); ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary mr-1">
                                    View
                                </a>

                                <a href="<?php echo e(asset($report->file)); ?>"
                                   download
                                   class="btn btn-sm btn-outline-success">
                                    Download
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">No reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u566596326/domains/hreomshopping.in/public_html/resources/views/reports/employee/my_reports.blade.php ENDPATH**/ ?>