<?php $__env->startPush('styles'); ?>
<style>
  .form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    border: 1px solid #e9ecef;
  }

  .form-section h4 {
    font-size: 15px;
    font-weight: 600;
    color: #343a40;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
  }

  label {
    font-size: 13px;
    font-weight: 500;
    color: #495057;
  }

  .required:after {
    content: " *";
    color: #dc3545;
  }

  .price-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    padding: 15px 25px;
    display: inline-block;
  }

  .btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 12px;
    width: 100%;
  }

  .btn-gradient:hover {
    opacity: 0.9;
    color: white;
  }

  .executive-row,
  .retainer-row {
    align-items: flex-end;
  }

  @media (max-width: 768px) {
    .executive-row,
    .retainer-row {
      align-items: stretch;
    }
  }

  label.form-check-label.mb-0 {
      margin-left: 1% !important;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <i class="fa fa-user-tie mr-2 text-primary"></i><?php echo app('translator')->get('app.menu.applyExecutiveRetainer'); ?>
        <span class="badge badge-primary ml-2">₹299</span>
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          <?php if($errors->any()): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?php echo e(route('executive-retainer.store')); ?>" id="applicationForm">
            <?php echo csrf_field(); ?>

            <!-- Applicant Details -->
            <div class="form-section">
              <h4><i class="fa fa-user-circle mr-2 text-primary"></i><?php echo app('translator')->get('app.applicantDetails'); ?></h4>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="required"><?php echo app('translator')->get('app.name'); ?></label>
                  <input type="text" name="name" class="form-control f-14" value="<?php echo e(old('name')); ?>" required placeholder="<?php echo app('translator')->get('placeholders.name'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required"><?php echo app('translator')->get('app.mobile'); ?></label>
                  <input type="text" name="mobile" class="form-control f-14" value="<?php echo e(old('mobile')); ?>" required placeholder="<?php echo app('translator')->get('placeholders.mobile'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required"><?php echo app('translator')->get('app.email'); ?></label>
                  <input type="email" name="email" class="form-control f-14" value="<?php echo e(old('email')); ?>" required placeholder="<?php echo app('translator')->get('placeholders.email'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required"><?php echo app('translator')->get('app.post'); ?></label>
                  <select name="post" id="post" class="form-control f-14" required>
                    <option value="">-- <?php echo app('translator')->get('app.select'); ?> --</option>
                    <option value="HR Executive" <?php echo e(old('post') == 'HR Executive' ? 'selected' : ''); ?>>HR Executive</option>
                    <option value="Retainer" <?php echo e(old('post') == 'Retainer' ? 'selected' : ''); ?>><?php echo app('translator')->get('app.retainer'); ?></option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="required"><?php echo app('translator')->get('app.dateOfJoining'); ?></label>
                  <input type="date" name="date_of_joining" class="form-control f-14" value="<?php echo e(old('date_of_joining', date('Y-m-d'))); ?>" required>
                </div>
              </div>
            </div>

            <!-- SECTION 1: Hire HR Executive Details (Max 4) -->
            <div class="form-section">
              <h4><i class="fa fa-users mr-2 text-success"></i><?php echo app('translator')->get('app.hireExecutives'); ?> <small class="text-muted font-weight-normal">(<?php echo app('translator')->get('app.max'); ?> 4)</small></h4>
              <div id="executiveRows">
                <?php $oldHired = old('hired_executives', [['name' => '', 'mobile' => '', 'joining_date' => '']]); ?>
                <?php $__currentLoopData = $oldHired; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $exec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="row mb-2 executive-row align-items-end">
                    <div class="col-md-4 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.executiveName'); ?></label><?php endif; ?>
                      <select name="hired_executives[<?php echo e($index); ?>][name]" class="form-control f-14 executive-name-select" data-index="<?php echo e($index); ?>">
                        <option value="">-- <?php echo app('translator')->get('app.select'); ?> HR Executive --</option>
                        <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($exe->name); ?>" data-mobile="<?php echo e($exe->mobile); ?>" <?php echo e(old("hired_executives.$index.name", $exec['name']) == $exe->name ? 'selected' : ''); ?>><?php echo e($exe->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="col-md-3 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.mobile'); ?></label><?php endif; ?>
                      <input type="text" name="hired_executives[<?php echo e($index); ?>][mobile]" class="form-control f-14 executive-mobile" data-index="<?php echo e($index); ?>" value="<?php echo e(old("hired_executives.$index.mobile", $exec['mobile'])); ?>" readonly placeholder="<?php echo app('translator')->get('placeholders.autoFilled'); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.joiningDate'); ?></label><?php endif; ?>
                      <input type="date" name="hired_executives[<?php echo e($index); ?>][joining_date]" class="form-control f-14" value="<?php echo e(old("hired_executives.$index.joining_date", $exec['joining_date'] ?? date('Y-m-d'))); ?>">
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                      <?php if(!$loop->first): ?>
                        <button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <button type="button" id="addExecutiveRow" class="btn btn-sm btn-outline-success rounded f-12 mt-2"><i class="fa fa-plus-circle mr-1"></i> <?php echo app('translator')->get('app.addAnotherExecutive'); ?></button>
              <small class="text-muted d-block mt-1"><?php echo app('translator')->get('app.maxEntries', ['count' => 4]); ?></small>
            </div>

            <!-- SECTION 2: Hire HR Retainer Details (Max 4) -->
            <div class="form-section">
              <h4><i class="fa fa-user-friends mr-2 text-info"></i><?php echo app('translator')->get('app.hireRetainers'); ?> <small class="text-muted font-weight-normal">(<?php echo app('translator')->get('app.max'); ?> 4)</small></h4>
              <div id="retainerRows">
                <?php $oldRetainers = old('hired_retainers', [['name' => '', 'mobile' => '', 'joining_date' => '']]); ?>
                <?php $__currentLoopData = $oldRetainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ret): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="row mb-2 retainer-row align-items-end">
                    <div class="col-md-4 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.retainerName'); ?></label><?php endif; ?>
                      <select name="hired_retainers[<?php echo e($index); ?>][name]" class="form-control f-14 retainer-name-select" data-index="<?php echo e($index); ?>">
                        <option value="">-- <?php echo app('translator')->get('app.select'); ?> HR Retainer --</option>
                        <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($exe->name); ?>" data-mobile="<?php echo e($exe->mobile); ?>" <?php echo e(old("hired_retainers.$index.name", $ret['name']) == $exe->name ? 'selected' : ''); ?>><?php echo e($exe->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="col-md-3 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.mobile'); ?></label><?php endif; ?>
                      <input type="text" name="hired_retainers[<?php echo e($index); ?>][mobile]" class="form-control f-14 retainer-mobile" data-index="<?php echo e($index); ?>" value="<?php echo e(old("hired_retainers.$index.mobile", $ret['mobile'])); ?>" readonly placeholder="<?php echo app('translator')->get('placeholders.autoFilled'); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                      <?php if($loop->first): ?><label><?php echo app('translator')->get('app.joiningDate'); ?></label><?php endif; ?>
                      <input type="date" name="hired_retainers[<?php echo e($index); ?>][joining_date]" class="form-control f-14" value="<?php echo e(old("hired_retainers.$index.joining_date", $ret['joining_date'] ?? date('Y-m-d'))); ?>">
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                      <?php if(!$loop->first): ?>
                        <button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <button type="button" id="addRetainerRow" class="btn btn-sm btn-outline-info rounded f-12 mt-2"><i class="fa fa-plus-circle mr-1"></i> <?php echo app('translator')->get('app.addAnotherRetainer'); ?></button>
              <small class="text-muted d-block mt-1"><?php echo app('translator')->get('app.maxEntries', ['count' => 4]); ?></small>
            </div>

            <!-- SECTION 3: Retainer Join Detail (shown only if post = Retainer) -->
            <div class="form-section" id="retainerSection" style="<?php echo e(old('post') == 'Retainer' ? '' : 'display:none;'); ?>">
              <h4><i class="fa fa-handshake mr-2 text-warning"></i><?php echo app('translator')->get('app.retainerJoinDetail'); ?></h4>
              <div class="row">
                <div class="col-md-4 mb-2">
                  <label><?php echo app('translator')->get('app.retainerName'); ?></label>
                  <select name="retainer_detail[name]" id="retainerNameSelect" class="form-control f-14">
                    <option value="">-- <?php echo app('translator')->get('app.select'); ?> Retainer --</option>
                    <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($exe->name); ?>" data-mobile="<?php echo e($exe->mobile); ?>" <?php echo e(old('retainer_detail.name') == $exe->name ? 'selected' : ''); ?>><?php echo e($exe->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="col-md-3 mb-2">
                  <label><?php echo app('translator')->get('app.mobile'); ?></label>
                  <input type="text" name="retainer_detail[mobile]" id="retainerMobile" class="form-control f-14" value="<?php echo e(old('retainer_detail.mobile')); ?>" readonly placeholder="<?php echo app('translator')->get('placeholders.autoFilled'); ?>">
                </div>
                <div class="col-md-3 mb-2">
                  <label><?php echo app('translator')->get('app.joiningDate'); ?></label>
                  <input type="date" name="retainer_detail[joining_date]" class="form-control f-14" value="<?php echo e(old('retainer_detail.joining_date', date('Y-m-d'))); ?>">
                </div>
              </div>
            </div>

            <!-- Payment & Terms -->
            <div class="w-100 border-top-grey d-block d-lg-flex d-md-flex justify-content-start px-4 py-3">
              <div class="text-center w-100">
                <div class="price-card d-inline-block mb-3">
                  <div class="price-amount" style="font-size:24px;font-weight:700;">₹ 299</div>
                  <small>PayU Secure Payment</small>
                </div>

                <div class="form-check d-flex mb-4">
                  <input type="checkbox" name="terms_accepted" id="terms" class="form-check-input mr-2" value="1" required>
                  <label for="terms" class="form-check-label mb-0">
                    <?php echo app('translator')->get('app.acceptTerms'); ?>
                    <a href="https://axvero.in/Advance-terms--conditions" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
                  </label>
                </div>

                <button type="submit" class="btn btn-gradient">
                  <i class="fa fa-credit-card mr-2"></i> Proceed to Pay ₹299
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  let executiveCount = <?php echo e(count(old('hired_executives', [['name' => '']]))); ?>;
  const maxExecutives = 4;

  $('#addExecutiveRow').click(function () {
    if (executiveCount >= maxExecutives) {
      Swal.fire('<?php echo app('translator')->get('app.limitReached'); ?>', '<?php echo app('translator')->get('messages.maxEntries', ['count' => 4]); ?>', 'warning');
      return;
    }
    let idx = executiveCount;
    let newRow = `
      <div class="row mb-2 executive-row align-items-end">
        <div class="col-md-4 mb-2">
          <select name="hired_executives[${idx}][name]" class="form-control f-14 executive-name-select" data-index="${idx}">
            <option value="">-- <?php echo app('translator')->get('app.select'); ?> HR Executive --</option>
            <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($exe->name); ?>" data-mobile="<?php echo e($exe->mobile); ?>"><?php echo e($exe->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <input type="text" name="hired_executives[${idx}][mobile]" class="form-control f-14 executive-mobile" data-index="${idx}" readonly placeholder="<?php echo app('translator')->get('placeholders.autoFilled'); ?>">
        </div>
        <div class="col-md-3 mb-2">
          <input type="date" name="hired_executives[${idx}][joining_date]" class="form-control f-14" value="<?php echo e(date('Y-m-d')); ?>">
        </div>
        <div class="col-md-2 mb-2 text-center">
          <button type="button" class="btn btn-sm btn-danger remove-executive rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
        </div>
      </div>`;
    $('#executiveRows').append(newRow);
    executiveCount++;
  });

  $(document).on('click', '.remove-executive', function () {
    if ($('.executive-row').length === 1) {
      Swal.fire('<?php echo app('translator')->get('app.cannotDelete'); ?>', '<?php echo app('translator')->get('messages.atLeastOneRow'); ?>', 'info');
      return;
    }
    $(this).closest('.executive-row').remove();
    executiveCount--;
  });

  $(document).on('change', '.executive-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.executive-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  let retainerCount = <?php echo e(count(old('hired_retainers', [['name' => '']]))); ?>;
  const maxRetainers = 4;

  $('#addRetainerRow').click(function () {
    if (retainerCount >= maxRetainers) {
      Swal.fire('<?php echo app('translator')->get('app.limitReached'); ?>', '<?php echo app('translator')->get('messages.maxEntries', ['count' => 4]); ?>', 'warning');
      return;
    }
    let idx = retainerCount;
    let newRow = `
      <div class="row mb-2 retainer-row align-items-end">
        <div class="col-md-4 mb-2">
          <select name="hired_retainers[${idx}][name]" class="form-control f-14 retainer-name-select" data-index="${idx}">
            <option value="">-- <?php echo app('translator')->get('app.select'); ?> HR Retainer --</option>
            <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($exe->name); ?>" data-mobile="<?php echo e($exe->mobile); ?>"><?php echo e($exe->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <input type="text" name="hired_retainers[${idx}][mobile]" class="form-control f-14 retainer-mobile" data-index="${idx}" readonly placeholder="<?php echo app('translator')->get('placeholders.autoFilled'); ?>">
        </div>
        <div class="col-md-3 mb-2">
          <input type="date" name="hired_retainers[${idx}][joining_date]" class="form-control f-14" value="<?php echo e(date('Y-m-d')); ?>">
        </div>
        <div class="col-md-2 mb-2 text-center">
          <button type="button" class="btn btn-sm btn-danger remove-retainer rounded f-12 p-1 mt-3"><i class="fa fa-trash-alt"></i></button>
        </div>
      </div>`;
    $('#retainerRows').append(newRow);
    retainerCount++;
  });

  $(document).on('click', '.remove-retainer', function () {
    if ($('.retainer-row').length === 1) {
      Swal.fire('<?php echo app('translator')->get('app.cannotDelete'); ?>', '<?php echo app('translator')->get('messages.atLeastOneRow'); ?>', 'info');
      return;
    }
    $(this).closest('.retainer-row').remove();
    retainerCount--;
  });

  $(document).on('change', '.retainer-name-select', function () {
    let mobile = $(this).find(':selected').data('mobile');
    let idx = $(this).data('index');
    $(`input.retainer-mobile[data-index="${idx}"]`).val(mobile || '');
  });

  $('#post').change(function () {
    if ($(this).val() === 'Retainer') $('#retainerSection').slideDown();
    else $('#retainerSection').slideUp();
  });

  $('#retainerNameSelect').change(function () {
    $('#retainerMobile').val($(this).find(':selected').data('mobile') || '');
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/executive-retainer/create.blade.php ENDPATH**/ ?>