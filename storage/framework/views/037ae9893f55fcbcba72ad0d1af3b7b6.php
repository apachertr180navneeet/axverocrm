

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4 px-3 px-md-4">

    
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="row align-items-center g-3">

                
                <div class="col-12 col-md-auto">
                    <h5 class="fw-bold mb-0">My Generated Letters</h5>
                    <small class="text-muted">Manage offer letters you have created.</small>
                </div>

                
                <div class="col-12 col-md ms-md-auto">
                <form method="GET" action="<?php echo e(route('letter.list')); ?>" class="row g-2 justify-content-md-end">

                        
                        <div class="col-12 col-sm col-md-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control border-start-0 bg-light"
                                    placeholder="Search candidate..."
                                    value="<?php echo e(request('search')); ?>"
                                >
                            </div>
                        </div>

                        
                        <div class="col-6 col-sm-auto">
                            <select name="designation" class="form-select form-select-sm bg-light">
                                <option value="">All Designations</option>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($designation); ?>" <?php echo e(request('designation') == $designation ? 'selected' : ''); ?>>
                                        <?php echo e($designation); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-6 col-sm-auto">
                            <select name="status" class="form-select form-select-sm bg-light">
                                <option value="">All Status</option>
                                <option value="sent"    <?php echo e(request('status') == 'sent'    ? 'selected' : ''); ?>>Sent</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            </select>
                        </div>

                        
                        <div class="col-auto d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-funnel"></i>
                                <span class="d-none d-sm-inline ms-1">Filter</span>
                            </button>
                            <?php if(request()->hasAny(['search', 'designation', 'status'])): ?>
                           <a href="<?php echo e(route('letter.list')); ?>" class="btn btn-sm btn-outline-danger" title="Clear filters">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            <?php endif; ?>
                        </div>

                        
                            <?php if(in_array('admin', user_roles())  || (int) user()->letter_status === 1): ?>
                        <div class="col-auto">
                            <a href="<?php echo e(route('generate')); ?>" class="btn btn-sm btn-primary fw-semibold px-3">
                                <i class="bi bi-plus-lg me-1"></i>Create New Letter
                            </a>
                        </div>
                        <?php endif; ?>

                    </form>
                </div>

            </div>
        </div>

        
        <?php if($offerLetters->count()): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase text-muted fw-semibold small ps-4" style="font-size:11px; letter-spacing:.6px;">Candidate</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Designation</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Date</th>
                        <th class="text-uppercase text-muted fw-semibold small"       style="font-size:11px; letter-spacing:.6px;">Status</th>
                        <th class="text-uppercase text-muted fw-semibold small text-end pe-4" style="font-size:11px; letter-spacing:.6px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $offerLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-semibold"><?php echo e($letter->full_name); ?></span>
                            <span class="text-muted"> (<?php echo e($letter->id); ?>)</span>
                        </td>
                        <td class="text-muted"><?php echo e($letter->designation); ?></td>
                        <td class="text-muted"><?php echo e(\Carbon\Carbon::parse($letter->joining_date)->format('M d, Y')); ?></td>
                        <td>
                            <?php if($letter->status === 'sent'): ?>
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2" style="font-size:11px; letter-spacing:.4px;">
                                    ● SENT
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2" style="font-size:11px; letter-spacing:.4px;">
                                    ● PENDING
                                </span>
                            <?php endif; ?>
                        </td>
                      <td class="text-end pe-4">
                        <a href="<?php echo e(route('offer-letters.download', $letter->id)); ?>"
                           class="text-primary fw-semibold text-decoration-none small">
                            <i class="bi bi-download me-1"></i>Download PDF
                        </a>
                    </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <?php if($offerLetters->hasPages()): ?>
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                <small class="text-muted">
                    Showing <?php echo e($offerLetters->firstItem()); ?>–<?php echo e($offerLetters->lastItem()); ?>

                    of <?php echo e($offerLetters->total()); ?> results
                </small>
                <div>
                    <?php echo e($offerLetters->appends(request()->query())->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-file-earmark-text display-4 d-block mb-3 opacity-25"></i>
            <p class="fw-semibold mb-1">No offer letters found.</p>
            <small>Try adjusting your search or filters.</small>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/offer-letter/list.blade.php ENDPATH**/ ?>