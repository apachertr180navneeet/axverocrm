<?php $__env->startSection('content'); ?>
  <div class="content-wrapper">
    <div class="add-client bg-white rounded">
      <h4 class="mb-0 p-20 f-21 font-weight-normal border-bottom-grey">
        <?php echo app('translator')->get('app.menu.executiveRetainerList'); ?>
      </h4>

      <div class="row p-20">
        <div class="col-sm-12">
          <form method="GET" class="mb-3">
            <div class="d-flex flex-wrap align-items-center">
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <input type="text" name="search" class="form-control f-14" placeholder="Name / Mobile / Email"
                  value="<?php echo e(request('search')); ?>">
              </div>
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <div class="select-status">
                  <select name="post" class="form-control select-picker">
                    <option value=""><?php echo app('translator')->get('app.all'); ?> Posts</option>
                    <option value="HR Executive" <?php echo e(request('post') == 'HR Executive' ? 'selected' : ''); ?>>HR Executive</option>
                    <option value="Retainer" <?php echo e(request('post') == 'Retainer' ? 'selected' : ''); ?>>Retainer</option>
                  </select>
                </div>
              </div>
              <div class="select-box d-flex pr-2 mb-2 mb-sm-0 border-right-grey">
                <div class="select-status">
                  <select name="payment_status" class="form-control select-picker">
                    <option value=""><?php echo app('translator')->get('app.all'); ?> Payment</option>
                    <option value="pending" <?php echo e(request('payment_status') == 'pending' ? 'selected' : ''); ?>><?php echo app('translator')->get('app.pending'); ?></option>
                    <option value="success" <?php echo e(request('payment_status') == 'success' ? 'selected' : ''); ?>><?php echo app('translator')->get('app.success'); ?></option>
                    <option value="failed" <?php echo e(request('payment_status') == 'failed' ? 'selected' : ''); ?>><?php echo app('translator')->get('app.failed'); ?></option>
                  </select>
                </div>
              </div>
              <div class="d-flex py-1 px-lg-2 px-md-2 px-0">
                <button type="submit" class="btn btn-primary rounded f-14 p-2 mr-2">
                  <i class="fa fa-search mr-1"></i> <?php echo app('translator')->get('app.filter'); ?>
                </button>
                <?php if(request()->anyFilled(['search', 'post', 'payment_status'])): ?>
                  <a href="<?php echo e(route('admin.executive-retainer.index')); ?>" class="btn btn-secondary rounded f-14 p-2">
                    <i class="fa fa-times-circle mr-1"></i> <?php echo app('translator')->get('app.clearFilters'); ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row p-20">
        <div class="col-sm-12">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div id="table-actions">
              <a href="<?php echo e(route('admin.executive-retainer.create')); ?>" class="btn btn-primary rounded f-14 p-2">
                <i class="fa fa-plus mr-1"></i> <?php echo app('translator')->get('app.add'); ?> Application
              </a>
              <?php if(request()->has('trashed')): ?>
                <a href="<?php echo e(route('admin.executive-retainer.index')); ?>" class="btn btn-secondary rounded f-14 p-2">
                  <i class="fa fa-list mr-1"></i> <?php echo app('translator')->get('app.all'); ?> Records
                </a>
              <?php else: ?>
                <a href="?trashed=1" class="btn btn-secondary rounded f-14 p-2">
                  <i class="fa fa-trash-restore mr-1"></i> <?php echo app('translator')->get('app.trashed'); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover border-0 w-100">
              <thead>
                <tr>
                  <th>ID</th>
                  <th><?php echo app('translator')->get('app.name'); ?></th>
                  <th><?php echo app('translator')->get('app.mobile'); ?></th>
                  <th><?php echo app('translator')->get('app.post'); ?></th>
                  <th><?php echo app('translator')->get('app.joiningDate'); ?></th>
                  <th><?php echo app('translator')->get('app.amount'); ?></th>
                  <th><?php echo app('translator')->get('app.paymentStatus'); ?></th>
                  <th width="220"><?php echo app('translator')->get('app.action'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td><?php echo e($app->id); ?></td>
                    <td><strong><?php echo e($app->name); ?></strong><br><small class="text-muted"><?php echo e($app->email); ?></small></td>
                    <td><?php echo e($app->mobile); ?></td>
                    <td><?php echo e($app->post); ?></td>
                    <td><?php echo e($app->date_of_joining->format('d-m-Y')); ?></td>
                    <td>₹<?php echo e(number_format($app->amount, 2)); ?></td>
                    <td>
                      <span class="badge badge-<?php echo e($app->payment_status == 'success' ? 'success' : ($app->payment_status == 'pending' ? 'warning' : 'danger')); ?>">
                        <?php echo e(ucfirst($app->payment_status)); ?>

                      </span>
                    </td>
                    <td>
                      <?php if($app->trashed()): ?>
                        <button class="btn btn-sm btn-success restore-btn rounded f-12 p-1" data-id="<?php echo e($app->id); ?>"><i class="fa fa-undo"></i> <?php echo app('translator')->get('app.restore'); ?></button>
                        <button class="btn btn-sm btn-dark force-delete-btn rounded f-12 p-1" data-id="<?php echo e($app->id); ?>"><i class="fa fa-trash-alt"></i> <?php echo app('translator')->get('app.forceDelete'); ?></button>
                      <?php else: ?>
                        <a href="<?php echo e(route('admin.executive-retainer.edit', $app->id)); ?>" class="btn btn-sm btn-info rounded f-12 p-1"><i class="fa fa-edit"></i> <?php echo app('translator')->get('app.edit'); ?></a>
                        <button class="btn btn-sm btn-danger delete-btn rounded f-12 p-1" data-id="<?php echo e($app->id); ?>" data-name="<?php echo e($app->name); ?>"><i class="fa fa-trash"></i> <?php echo app('translator')->get('app.delete'); ?></button>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted"><?php echo app('translator')->get('messages.noRecordFound'); ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="mt-3">
            <?php echo e($applications->appends(request()->query())->links()); ?>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <script>
    $(document).ready(function () {
      $('.delete-btn').click(function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        Swal.fire({
          title: '<?php echo app('translator')->get('messages.sweetAlertTitle'); ?>',
          text: `<?php echo app('translator')->get('messages.deleteConfirmation'); ?> ${name}?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: '<?php echo app('translator')->get('app.yes'); ?>',
          cancelButtonText: '<?php echo app('translator')->get('app.cancel'); ?>',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}`,
              type: 'POST',
              data: { _token: '<?php echo e(csrf_token()); ?>', _method: 'DELETE' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });

      $('.restore-btn').click(function () {
        let id = $(this).data('id');
        Swal.fire({
          title: '<?php echo app('translator')->get('app.restore'); ?>?',
          text: "<?php echo app('translator')->get('messages.restoreConfirmation'); ?>",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<?php echo app('translator')->get('app.yes'); ?>',
          cancelButtonText: '<?php echo app('translator')->get('app.cancel'); ?>',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}/restore`,
              type: 'POST',
              data: { _token: '<?php echo e(csrf_token()); ?>' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });

      $('.force-delete-btn').click(function () {
        let id = $(this).data('id');
        Swal.fire({
          title: '<?php echo app('translator')->get('app.forceDelete'); ?>?',
          text: "<?php echo app('translator')->get('messages.forceDeleteConfirmation'); ?>",
          icon: 'error',
          showCancelButton: true,
          confirmButtonText: '<?php echo app('translator')->get('app.yes'); ?>',
          cancelButtonText: '<?php echo app('translator')->get('app.cancel'); ?>',
          customClass: { confirmButton: 'btn btn-primary mr-3', cancelButton: 'btn btn-secondary' },
          showClass: { popup: 'swal2-noanimation', backdrop: 'swal2-noanimation' },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/account/executive-retainer/${id}/force-delete`,
              type: 'POST',
              data: { _token: '<?php echo e(csrf_token()); ?>', _method: 'DELETE' },
              success: function (response) {
                if (response.status == 'success') { location.reload(); }
              }
            });
          }
        });
      });
    });
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/admin/executive-retainer/index.blade.php ENDPATH**/ ?>