

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="d-flex flex-column w-tables rounded mt-4 bg-white">

        <div class="p-3">
            <h5>
                Task Assigned Employees – <?php echo e($manager->name ?? 'N/A'); ?>

            </h5>
        </div>

        <table class="table table-hover border-0 w-100">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Manager</th>
                    <th>Task Report Date</th>
                    <th>Task</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($employee->name ?? 'N/A'); ?></td>
                        <td><?php echo e($manager->name ?? 'N/A'); ?></td>
                        <td>
                            <?php echo e(optional($employee->employeeTaskReports->first())->report_date
                                ? \Carbon\Carbon::parse($employee->employeeTaskReports->first()->report_date)->format('d M, Y h:i A')
                                : 'N/A'); ?>

                        </td>
                    
                        <td class="d-flex">
                            
                            <?php
                                $report = $employee->employeeTaskReports->first();
                            ?>
                            
                            <?php if($report): ?>
                                <a href="<?php echo e(route('employee_task.task.reports.details', $report->id)); ?>"
                                   class="btn btn-sm btn-outline-danger mr-1">
                                    Task Details
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No Report</span>
                            <?php endif; ?>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center">
                            No employees assigned.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/reports/employee-task/assigned_task.blade.php ENDPATH**/ ?>