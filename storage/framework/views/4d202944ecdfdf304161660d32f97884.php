<?php $__env->startPush('datatable-styles'); ?>
<?php echo $__env->make('sections.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <h4 class="mb-3"><?php echo e($employee->name); ?> – Reports</h4>

    <?php
        $hasAssignedEmployees = \App\Models\EmployeeDetails::where('reporting_to', $employee->id)->exists();
    ?>


    
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row align-items-end">

                
                <div class="col-md-3">
                    <label class="f-14 font-weight-bold">Search Manager</label>
                    <input type="text"
                           id="nameSearch"
                           class="form-control py-2"
                           placeholder="Type manager name">
                </div>

                
                <div class="col-md-2">
                    <label class="f-14 font-weight-bold">Start Date</label>
                    <input type="date"
                           id="startDate"
                           class="form-control py-2"
                           placeholder="Start Date">
                </div>

                
                <div class="col-md-2">
                    <label class="f-14 font-weight-bold">End Date</label>
                    <input type="date"
                           id="endDate"
                           class="form-control py-2"
                           placeholder="End Date">
                </div>

                
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-filter mr-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                <?php if($hasAssignedEmployees): ?>
                    <a href="<?php echo e(route('employee.report.assigned', $employee->id)); ?>"
                       class="btn btn-sm btn-warning mb-1 py-2">
                        Assigned Employee
                    </a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table id="reportsTable" class="table table-bordered table-hover w-100">
        <thead class="thead-light">
        <tr>
            <th>Report Date</th>
            <th>Manager</th>
            <th>Sales Info</th>
            <th>Actions</th>
        </tr>
    </thead>

        <tbody>
           <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e(\Carbon\Carbon::parse($report->report_date)->format('Y-m-d')); ?></td>

    <td><?php echo e($report->reportingPerson->name ?? 'N/A'); ?></td>

    
    <td>
        <button class="btn btn-sm btn-outline-info"
                data-toggle="modal"
                data-target="#salesModal<?php echo e($report->id); ?>">
            View Sales
        </button>
    </td>

    
    <td class="d-flex align-items-center">
        <a href="<?php echo e(route('employee.report.details', $report->id)); ?>"
           class="btn btn-sm btn-outline-danger mr-1">
            Report Details
        </a>

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


<div class="modal fade" id="salesModal<?php echo e($report->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Sales Report Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo e($report->full_name); ?></td>
                    </tr>
                    <tr>
                        <th>Today Sale</th>
                        <td><?php echo e($report->today_sale); ?></td>
                    </tr>
                    <tr>
                        <th>Today Team</th>
                        <td><?php echo e($report->today_team); ?></td>
                    </tr>
                    <tr>
                        <th>Overall Total Sale</th>
                        <td><?php echo e($report->overall_total_sale); ?></td>
                    </tr>
                    <tr>
                        <th>Overall Total Team</th>
                        <td><?php echo e($report->overall_total_team); ?></td>
                    </tr>
                    <tr>
                        <th>Marketing Work Done</th>
                        <td>
                            <span class="badge badge-<?php echo e($report->marketing_work_done == 'yes' ? 'success' : 'danger'); ?>">
                                <?php echo e(ucfirst($report->marketing_work_done)); ?>

                            </span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
</div>


</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#reportsTable').DataTable({
    order: [[0, 'desc']],
    pageLength: 10,
    lengthChange: false,
    language: {
        emptyTable: "No reports found"
        }
    });


    // Search by Manager Name
    $('#nameSearch').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });

    // Date Filter
    $('.btn-primary').on('click', function () {

        let startDate = $('#startDate').val();
        let endDate   = $('#endDate').val();

        $.fn.dataTable.ext.search.push(function (settings, data) {
            let reportDate = data[0];

            if (
                (startDate === '' && endDate === '') ||
                (startDate === '' && reportDate <= endDate) ||
                (startDate <= reportDate && endDate === '') ||
                (startDate <= reportDate && reportDate <= endDate)
            ) {
                return true;
            }
            return false;
        });

        table.draw();
        $.fn.dataTable.ext.search.pop();
    });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u566596326/domains/hreomshopping.in/public_html/resources/views/reports/employee/employeedetailpage.blade.php ENDPATH**/ ?>