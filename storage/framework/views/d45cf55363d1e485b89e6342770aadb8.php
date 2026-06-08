<div class="table-container">
    <div class="section-header">
        <i class="fas fa-credit-card me-2"></i> PayU Hiring Applications
    </div>

    <div class="filter-card">
        <div class="filter-title"><i class="fas fa-filter me-2"></i> Filter PayU Applications</div>
        <form method="GET" action="<?php echo e(route('dashboard')); ?>" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                    placeholder="Search by Name, Email, Mobile, TXN ID" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-control">
                    <option value="">All Status</option>
                    <option value="success" <?php echo e(request('payment_status')=='success' ? 'selected' : ''); ?>>✅ Success
                    </option>
                    <option value="pending" <?php echo e(request('payment_status')=='pending' ? 'selected' : ''); ?>">⏳ Pending
                    </option>
                    <option value="failed" <?php echo e(request('payment_status')=='failed' ? 'selected' : ''); ?>">❌ Failed
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="btn-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-search me-1"></i> Search</button>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary"><i class="fas fa-sync me-1"></i>
                        Reset</a>
                    <a href="<?php echo e(route('export.payu.excel', request()->query())); ?>" class="btn-success"><i
                            class="fas fa-file-excel me-1"></i> Excel</a>
                    <a href="<?php echo e(route('export.payu.pdf', request()->query())); ?>" class="btn-danger"><i
                            class="fas fa-file-pdf me-1"></i> PDF</a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $hiringSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>#<?php echo e($submission->id); ?></td>
                    <td><strong><?php echo e($submission->name); ?></strong></td>
                    <td><?php echo e($submission->mobile); ?></td>
                    <td><?php echo e($submission->email); ?></td>
                    <td><?php echo e($submission->designation); ?></td>
                    <td>₹<?php echo e(number_format($submission->amount, 2)); ?></td>
                    <td>
                        <?php if($submission->payment_status == 'success'): ?>
                        <span class="status-paid">✅ PAID</span>
                        <?php elseif($submission->payment_status == 'pending'): ?>
                        <span class="status-pending">⏳ PENDING</span>
                        <?php else: ?>
                        <span class="status-failed">❌ FAILED</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($submission->created_at->format('d-m-Y H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">No PayU applications found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($hiringSubmissions->appends(request()->query())->links()); ?>

</div><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/dashboard/employee/widgets/advance_income_list.blade.php ENDPATH**/ ?>