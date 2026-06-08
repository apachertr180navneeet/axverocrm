

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">

        <div class="m-3">
            <a href="<?php echo e(route('employee_task.task.reports.assigned')); ?>" class="btn btn-info btn-sm">
                View Assigned Reports
            </a>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>Employee</th>
                    <th>Manager</th>
                    <th>Report Date</th>
                    <th>Status</th>
                    <th>Task</th>
                    <th>Report</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($report->user->name ?? 'N/A'); ?></td>
                        <td><?php echo e($report->reportingPerson->name ?? 'N/A'); ?></td>
                        <td>
                            <?php echo e(\Carbon\Carbon::parse($report->report_date)->format('d M, Y h:i A')); ?>

                        </td>
                        <td><?php echo e($report->status ?? 'N/A'); ?></td>
                        <td><?php echo \Illuminate\Support\Str::limit(strip_tags($report->reports), 50); ?></td>
                        <td>
                            <a href=""
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                View
                            </a>

                            <a href="">
                                Download
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            No reports found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/reports/employee-task/my_reports.blade.php ENDPATH**/ ?>