

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .candidate-card {
        background: #f8f9ff;
        border: 1px solid #e0e3ff;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
        position: relative;
    }

    .candidate-card:first-child .remove-btn {
        display: none !important;
    }

    .badge-number {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        padding: 0;
    }

    .add-more-btn {
        border: 2px dashed #667eea;
        color: #667eea;
        background: transparent;
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .add-more-btn:hover {
        background: #667eea;
        color: white;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 10px 35px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.2);
    }

    .readonly-field {
        background-color: #f0f0f7 !important;
        cursor: not-allowed;
    }

    .gender-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 4px;
        display: block;
    }

    .gender-group .btn {
        border-radius: 6px !important;
        font-size: 13px;
        padding: 6px 14px;
    }

    .gender-group .btn-check:checked + .btn-outline-primary,
    .gender-group .active-gender {
        background-color: #667eea;
        border-color: #667eea;
        color: white;
    }

    @media (max-width: 768px) {
        .form-label-hide label {
            display: none;
        }

        .candidate-card {
            padding: 12px;
        }
    }

    /* Alert animations */
    .alert-fixed {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        border-radius: 10px;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { transform: translateX(100px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .is-invalid-custom {
        border-color: #dc3545 !important;
    }

    .invalid-feedback-custom {
        color: #dc3545;
        font-size: 12px;
        margin-top: 3px;
        display: none;
    }

    .show-error .invalid-feedback-custom {
        display: block;
    }
</style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
<div class="content-wrapper py-4">
<div class="container-fluid">


<?php if(session('success')): ?>
<div id="success-alert" class="alert alert-success alert-dismissible alert-fixed">
    <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div id="error-alert" class="alert alert-danger alert-dismissible alert-fixed">
    <i class="fas fa-exclamation-circle mr-2"></i> <?php echo e(session('error')); ?>

    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0" style="border-radius:12px; overflow:hidden;">

    
    <div class="card-header card-header-custom py-3">
        <h4 class="mb-0 font-weight-bold">
            <i class="fas fa-user-friends mr-2"></i> Reference Form
        </h4>
    </div>

    <div class="card-body p-4">

        <form method="POST" action="<?php echo e(route('refference.store')); ?>" id="referenceForm" novalidate>
        <?php echo csrf_field(); ?>

        
        <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0" style="border-radius:8px;">
            <strong><i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following errors:</strong>
            <ul class="mb-0 mt-1 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li style="font-size:14px;"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        
        <p class="section-title mb-3">
            <i class="fas fa-id-badge mr-1"></i> Senior Details
        </p>

        <div class="row">

            <div class="col-12 col-md-4 mb-3">
                <label class="font-weight-600" style="font-size:13px;">Senior Name</label>
                <input type="text" name="senior_name"
                       value="<?php echo e($user->name); ?>"
                       class="form-control">
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label class="font-weight-600" style="font-size:13px;">Mobile Number</label>
                <input type="text" name="senior_mobile"
                       value="<?php echo e($user->mobile); ?>"
                       class="form-control">
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label class="font-weight-600" style="font-size:13px;">Portal ID</label>
                <input type="number" name="portal_id"
                       class="form-control">
            </div>

        </div>

        <hr class="my-4">

        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="section-title mb-0">
                <i class="fas fa-users mr-1"></i> Reference Candidates Details
            </p>
            <small class="text-muted">Add upto multiple candidates</small>
        </div>

        <div id="candidates-wrapper">

            
            <div class="candidate-card candidate-row">

                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeCandidate(this)" title="Remove">
                    <i class="fas fa-times"></i>
                </button>

                <div class="d-flex align-items-center mb-2">
                    <span class="badge-number row-number">1</span>
                    <span style="font-size:13px; font-weight:600; color:#667eea;">Candidate</span>
                </div>

                <div class="row">

                    <div class="col-12 col-md-4 mb-2">
                        <label style="font-size:13px;">Name <span class="text-danger">*</span></label>
                        <input type="text" name="candidate_name[]"
                               class="form-control candidate-name-input"
                               placeholder="Enter full name"
                               value="<?php echo e(old('candidate_name.0')); ?>">
                        <div class="invalid-feedback-custom">Name is required.</div>
                    </div>

                    <div class="col-12 col-md-4 mb-2">
                        <label style="font-size:13px;">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" name="candidate_mobile[]"
                               class="form-control candidate-mobile-input"
                               placeholder="Enter 10-digit number"
                               maxlength="10"
                               value="<?php echo e(old('candidate_mobile.0')); ?>">
                        <div class="invalid-feedback-custom">Valid 10-digit number required.</div>
                    </div>

                    <div class="col-12 col-md-4 mb-2">
                        <label style="font-size:13px;">Gender <span class="text-danger">*</span></label>
                        <select name="candidate_gender[]" class="form-control candidate-gender-select">
                            <option value="">-- Select Gender --</option>
                            <option value="Male"   <?php echo e(old('candidate_gender.0') == 'Male'   ? 'selected' : ''); ?>>Male</option>
                            <option value="Female" <?php echo e(old('candidate_gender.0') == 'Female' ? 'selected' : ''); ?>>Female</option>
                            <option value="Other"  <?php echo e(old('candidate_gender.0') == 'Other'  ? 'selected' : ''); ?>>Other</option>
                        </select>
                        <div class="invalid-feedback-custom">Please select gender.</div>
                    </div>

                </div>
            </div>

        </div>

        
        <div class="text-center mt-2 mb-4">
            <button type="button" class="add-more-btn" onclick="addCandidate()">
                <i class="fas fa-plus mr-1"></i> Add More Candidate
            </button>
        </div>

        <hr>

        
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary submit-btn text-white">
                <i class="fas fa-paper-plane mr-2"></i> Submit Reference
            </button>
        </div>

        </form>

    </div>
</div>

</div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

// ── Auto dismiss alerts ────────────────────────────
$(document).ready(function () {
    setTimeout(function () {
        $('#success-alert, #error-alert').fadeOut('slow');
    }, 4000);
});

// ── Add Candidate Row ──────────────────────────────
function addCandidate() {
    let wrapper   = document.getElementById('candidates-wrapper');
    let original  = wrapper.querySelector('.candidate-row');
    let clone     = original.cloneNode(true);

    // Clear all inputs in clone
    clone.querySelectorAll('input').forEach(i => i.value = '');
    clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    clone.querySelectorAll('.invalid-feedback-custom').forEach(e => e.style.display = 'none');
    clone.querySelectorAll('.is-invalid-custom').forEach(e => e.classList.remove('is-invalid-custom'));

    // Show remove button
    clone.querySelector('.remove-btn').style.display = 'flex';

    wrapper.appendChild(clone);
    updateRowNumbers();
}

// ── Remove Candidate Row ───────────────────────────
function removeCandidate(btn) {
    let wrapper = document.getElementById('candidates-wrapper');
    if (wrapper.querySelectorAll('.candidate-row').length <= 1) return;
    btn.closest('.candidate-row').remove();
    updateRowNumbers();
}

// ── Update Row Serial Numbers ──────────────────────
function updateRowNumbers() {
    document.querySelectorAll('.candidate-row').forEach(function (row, index) {
        row.querySelector('.row-number').textContent = index + 1;
    });
}

// ── Client-side Validation ─────────────────────────
document.getElementById('referenceForm').addEventListener('submit', function (e) {

    let valid = true;

    // Collect all mobile numbers to check duplicates
    let allMobiles = [];

    document.querySelectorAll('.candidate-row').forEach(function (row, index) {

        let nameInput   = row.querySelector('.candidate-name-input');
        let mobileInput = row.querySelector('.candidate-mobile-input');
        let genderSel   = row.querySelector('.candidate-gender-select');

        // Reset errors
        [nameInput, mobileInput, genderSel].forEach(el => {
            el.classList.remove('is-invalid-custom');
            el.nextElementSibling.style.display = 'none';
        });

        // Name validation
        if (!nameInput.value.trim()) {
            nameInput.classList.add('is-invalid-custom');
            nameInput.nextElementSibling.style.display = 'block';
            nameInput.nextElementSibling.textContent = 'Name is required.';
            valid = false;
        }

        // Mobile validation
        let mob = mobileInput.value.trim();
        if (!mob || !/^\d{10}$/.test(mob)) {
            mobileInput.classList.add('is-invalid-custom');
            mobileInput.nextElementSibling.style.display = 'block';
            mobileInput.nextElementSibling.textContent = 'Enter a valid 10-digit mobile number.';
            valid = false;
        } else if (allMobiles.includes(mob)) {
            mobileInput.classList.add('is-invalid-custom');
            mobileInput.nextElementSibling.style.display = 'block';
            mobileInput.nextElementSibling.textContent = 'This number is already used above. All numbers must be unique.';
            valid = false;
        } else {
            allMobiles.push(mob);
        }

        // Gender validation
        if (!genderSel.value) {
            genderSel.classList.add('is-invalid-custom');
            genderSel.nextElementSibling.style.display = 'block';
            genderSel.nextElementSibling.textContent = 'Please select gender.';
            valid = false;
        }

    });

    if (!valid) {
        e.preventDefault();

        // Show error toast
        let toast = $('<div class="alert alert-danger alert-dismissible alert-fixed">' +
            '<i class="fas fa-exclamation-circle mr-2"></i> Please fix the errors before submitting.' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        $('body').append(toast);
        setTimeout(() => toast.fadeOut('slow', function(){ $(this).remove(); }), 4000);

        // Scroll to first error
        let firstError = document.querySelector('.is-invalid-custom');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
});

// ── Allow only digits in mobile fields (live) ──────
document.getElementById('candidates-wrapper').addEventListener('input', function (e) {
    if (e.target.classList.contains('candidate-mobile-input')) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
    }
});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/refference/create.blade.php ENDPATH**/ ?>