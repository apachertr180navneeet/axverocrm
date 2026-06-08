

<style>

/* ===== Google Font ===== */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

/* ===== Base ===== */
html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
}

/* ===== Page BG ===== */
.offer-page-bg {
    height: 100vh;
    background: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    overflow: hidden;
}

/* ===== Card ===== */
.offer-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    padding: 28px 36px 22px;
    width: 100%;
    max-width: 860px;
}

/* ===== Title ===== */
.offer-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
    letter-spacing: -0.3px;
}

/* ===== Labels ===== */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

/* ===== Inputs & Selects ===== */
.form-control {
    height: 42px !important;
    border-radius: 8px !important;
    border: 1.5px solid #d1d5db !important;
    background: #ffffff !important;
    color: #111827 !important;
    font-size: 14px !important;
    font-family: 'DM Sans', sans-serif;
    padding: 0 14px !important;
    transition: border-color 0.18s, box-shadow 0.18s;
    width: 100%;
}

.form-control:focus {
    border-color: #5b4fd8 !important;
    box-shadow: 0 0 0 3px rgba(91,79,216,0.12) !important;
    outline: none !important;
}

/* ===== Select Arrow ===== */
select.form-control {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px !important;
    padding-right: 36px !important;
    cursor: pointer;
}

/* ===== Row Spacing ===== */
.form-row-gap {
    row-gap: 12px;
}

/* ===== Divider before buttons ===== */
.btn-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 18px 0 14px;
}

/* ===== Buttons ===== */
.btn-offer-cancel,
.btn-offer-preview {
    height: 42px;
    border-radius: 8px;
    padding: 0 22px;
    font-size: 14px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    border: 1.5px solid #d1d5db;
    background: #ffffff;
    color: #374151;
    transition: background 0.15s, border-color 0.15s, color 0.15s;
    cursor: pointer;
}

.btn-offer-cancel:hover,
.btn-offer-preview:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
}

.btn-offer-generate {
    height: 42px;
    border-radius: 8px;
    padding: 0 24px;
    font-size: 14px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    background: #4f46e5;
    border: none;
    color: #ffffff;
    transition: background 0.15s, transform 0.1s;
    cursor: pointer;
}

.btn-offer-generate:hover {
    background: #4338ca;
    transform: translateY(-1px);
}

.btn-offer-generate:active {
    transform: translateY(0);
}

/* ===== Flash Notification ===== */
.flash-notify {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 280px;
    max-width: 380px;
    padding: 14px 18px;
    border-radius: 10px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.13);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    animation: flashSlideIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.flash-notify.flash-success {
    background: #f0fdf4;
    border: 1.5px solid #86efac;
    color: #166534;
}

.flash-notify.flash-error {
    background: #fef2f2;
    border: 1.5px solid #fca5a5;
    color: #991b1b;
}

.flash-notify.flash-warning {
    background: #fffbeb;
    border: 1.5px solid #fcd34d;
    color: #92400e;
}

.flash-notify .flash-icon {
    font-size: 18px;
    flex-shrink: 0;
    margin-top: 1px;
}

.flash-notify .flash-body { flex: 1; }

.flash-notify .flash-title {
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 2px;
}

.flash-notify .flash-msg {
    font-size: 13px;
    font-weight: 400;
    opacity: 0.85;
}

.flash-notify .flash-close {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: inherit;
    opacity: 0.5;
    padding: 0;
    line-height: 1;
    flex-shrink: 0;
    transition: opacity 0.15s;
}

.flash-notify .flash-close:hover { opacity: 1; }

.flash-notify .flash-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    border-radius: 0 0 10px 10px;
    animation: flashBarShrink 5s linear forwards;
}

.flash-success .flash-bar { background: #22c55e; }
.flash-error   .flash-bar { background: #ef4444; }
.flash-warning .flash-bar { background: #f59e0b; }

.flash-notify.flash-hiding {
    opacity: 0;
    transform: translateX(30px);
}

@keyframes flashSlideIn {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes flashBarShrink {
    from { width: 100%; }
    to   { width: 0%; }
}

/* ===== Dark Mode ===== */
body.dark .offer-page-bg   { background: #0f1117; }
body.dark .offer-card      { background: #1c1f2e; box-shadow: 0 4px 24px rgba(0,0,0,0.35); }
body.dark .offer-card h3   { color: #f9fafb; }
body.dark .form-label      { color: #9ca3af; }
body.dark .form-control    { background: #111827 !important; border-color: #374151 !important; color: #f3f4f6 !important; }
body.dark .btn-divider     { border-color: #374151; }
body.dark .btn-offer-cancel,
body.dark .btn-offer-preview { background: #1c1f2e; border-color: #374151; color: #d1d5db; }
body.dark .btn-offer-cancel:hover,
body.dark .btn-offer-preview:hover { background: #374151; color: #f9fafb; }

/* ===== Mobile ===== */
@media (max-width: 576px) {
    .offer-page-bg { height: auto; min-height: 100vh; overflow: auto; align-items: flex-start; padding: 20px 12px; }
    .offer-card    { padding: 22px 16px 18px; }
    .offer-card h3 { font-size: 17px; margin-bottom: 16px; }
    .btn-area      { flex-direction: column !important; gap: 10px !important; }
    .btn-offer-cancel, .btn-offer-preview, .btn-offer-generate { width: 100% !important; height: 44px; border-radius: 10px; }
    .flash-notify  { top: 12px; right: 12px; left: 12px; max-width: 100%; }
}

</style>

<?php $__env->startSection('content'); ?>



<?php if(session('success')): ?>
<div class="flash-notify flash-success" id="flashMsg">
    <span class="flash-icon">✅</span>
    <div class="flash-body">
        <div class="flash-title">Success!</div>
        <div class="flash-msg"><?php echo e(session('success')); ?></div>
    </div>
    <button class="flash-close" onclick="dismissFlash()">✕</button>
    <div class="flash-bar"></div>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="flash-notify flash-error" id="flashMsg">
    <span class="flash-icon">❌</span>
    <div class="flash-body">
        <div class="flash-title">Error!</div>
        <div class="flash-msg"><?php echo e(session('error')); ?></div>
    </div>
    <button class="flash-close" onclick="dismissFlash()">✕</button>
    <div class="flash-bar"></div>
</div>
<?php endif; ?>

<?php if(session('warning')): ?>
<div class="flash-notify flash-warning" id="flashMsg">
    <span class="flash-icon">⚠️</span>
    <div class="flash-body">
        <div class="flash-title">Warning!</div>
        <div class="flash-msg"><?php echo e(session('warning')); ?></div>
    </div>
    <button class="flash-close" onclick="dismissFlash()">✕</button>
    <div class="flash-bar"></div>
</div>
<?php endif; ?>



<div class="offer-page-bg">
    <div class="offer-card">

        <h3>Generate New Offer Letter</h3>

        <form method="POST" action="<?php echo e(route('offer.store')); ?>" id="offerForm">
            <?php echo csrf_field(); ?>

            <div class="row form-row-gap">

                
                <div class="col-md-3 col-12">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                
                <div class="col-md-9 col-12">
                    <label class="form-label">Candidate Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name"
                           value="<?php echo e(old('full_name')); ?>">
                </div>

                
                <div class="col-md-6 col-12">
                    <label class="form-label">Candidate Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com"
                           value="<?php echo e(old('email')); ?>">
                </div>
                

                
                <div class="col-md-6 d-none d-md-block"></div>
                
                <div class="col-md-6 col-12">
                    <label class="form-label">Employment Type</label>
                    <select name="employment_type" class="form-control">
                        <option value="">-- Select Type --</option>
                        <option value="Internship" <?php echo e(old('employment_type') == 'Internship' ? 'selected' : ''); ?>>Internship</option>
                        <option value="Employee" <?php echo e(old('employment_type') == 'Employee' ? 'selected' : ''); ?>>Employee</option>
                    </select>
                </div>

                
                <div class="col-md-6 col-12">
                    <label class="form-label">Designation</label>
                    <select name="designation" class="form-control">
                        <option value="">-- Select Designation --</option>
                        <?php $__currentLoopData = ['Sales Manager','Assistant Sales Manager','Agent Relationship Manager','HR Manager','HR Executive','IT Executive','Sales Executive','IT Sales Manager','IT Manager','Social Media Manager','Trainer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($d); ?>" <?php echo e(old('designation') == $d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-md-6 col-12">
                    <label class="form-label">Monthly Salary (INR)</label>
                    <input type="number" name="salary" class="form-control" placeholder="e.g. 50000"
                           value="<?php echo e(old('salary')); ?>">
                </div>

                
                <div class="col-md-6 col-12">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" class="form-control"
                           value="<?php echo e(old('joining_date')); ?>">
                </div>

            </div>

            
            <?php if($errors->any()): ?>
            <div class="mt-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <small class="text-danger d-block" style="font-size:12px;">⚠ <?php echo e($error); ?></small>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            
            <hr class="btn-divider">

            
            <div class="d-flex justify-content-end align-items-center btn-area flex-wrap" style="gap: 10px;">

                <button type="button" class="btn-offer-cancel"
                        onclick="window.history.back()">
                    Cancel
                </button>

                <button type="button" class="btn-offer-preview" id="previewBtn">
                    Preview
                </button>

                <button type="submit" class="btn-offer-generate" id="generateBtn">
                    Generate &amp; Send
                </button>

            </div>

        </form>

    </div>
</div>

<script>

// ── Flash dismiss ─────────────────────────────────────────────────────────
function dismissFlash() {
    const el = document.getElementById('flashMsg');
    if (el) {
        el.classList.add('flash-hiding');
        setTimeout(() => el.remove(), 400);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('flashMsg');
    if (el) setTimeout(() => dismissFlash(), 5000);
});

// ── Preview button ────────────────────────────────────────────────────────
document.getElementById('previewBtn').addEventListener('click', function () {

   const fieldNames = ['gender', 'full_name', 'email', 'employment_type', 'designation', 'salary', 'joining_date'];
    const fields = {};

    // Clear previous errors
    document.querySelectorAll('.preview-error').forEach(e => e.remove());
    document.querySelectorAll('.form-control').forEach(e => e.style.removeProperty('border-color'));

    let hasError = false;

    fieldNames.forEach(key => {
        const el = document.querySelector(`[name="${key}"]`);
        fields[key] = el;
        if (!el || !el.value.trim()) {
            hasError = true;
            el.style.borderColor = '#ef4444';
            const err = document.createElement('small');
            err.className = 'preview-error text-danger d-block mt-1';
            err.style.fontSize = '11px';
            err.textContent = 'This field is required';
            el.parentNode.appendChild(err);
        }
    });

    if (hasError) return;

    // Build hidden form and submit to new tab
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(route("offer-letters.preview")); ?>';
    form.target = '_blank';

    const csrf = document.createElement('input');
    csrf.type  = 'hidden';
    csrf.name  = '_token';
    csrf.value = '<?php echo e(csrf_token()); ?>';
    form.appendChild(csrf);

    fieldNames.forEach(key => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = key;
        input.value = fields[key].value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
});

// ── Generate & Send — loading state ──────────────────────────────────────
document.getElementById('offerForm').addEventListener('submit', function () {
    const btn = document.getElementById('generateBtn');
    btn.disabled    = true;
    btn.textContent = 'Sending...';
    btn.style.opacity = '0.75';
});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/offer-letter/generate.blade.php ENDPATH**/ ?>