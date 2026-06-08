<?php $__env->startPush('datatable-styles'); ?>
    <?php echo $__env->make('sections.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<div class="d-flex flex-column w-tables rounded bg-white table-responsive">
    <?php echo $dataTable->table(['class' => 'table table-hover border-0 w-100']); ?>

</div>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('sections.datatable_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        const showTable = () => {
            window.LaravelDataTables["shift-rotation-table"].draw(true);
        }

        $('body').on('click', '#manageEmployees', function() {
            var rotationId = $(this).data('rotation-id');
            var url = "<?php echo e(route('shift-rotations.manage_rotation_employee', ':id')); ?>";
            url = url.replace(':id', rotationId);

            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('body').on('click', '.delete-shift-rotation', function() {
            let id = $(this).data('rotation-id');

            Swal.fire({
                title: "<?php echo app('translator')->get('messages.sweetAlertTitle'); ?>",
                text: "<?php echo app('translator')->get('messages.recoverRecord'); ?>",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "<?php echo app('translator')->get('messages.confirmDelete'); ?>",
                cancelButtonText: "<?php echo app('translator')->get('app.cancel'); ?>",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "<?php echo e(route('shift-rotations.destroy', ':id')); ?>";
                    url = url.replace(':id', id);

                    var token = "<?php echo e(csrf_token()); ?>";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        blockUI: true,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                showTable();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('change', '.change-rotation-status', function() {
            let status = $(this).val();
            let rotationId = $(this).data('rotation-id');

            var url = "<?php echo e(route('shift-rotations.change_status')); ?>";
            var token = "<?php echo e(csrf_token()); ?>";

            $.easyAjax({
                url: url,
                type: 'POST',
                blockUI: true,
                data: {
                    '_token': token,
                    id: rotationId,
                    status: status,
                    sortBy: 'id'
                },
                success: function(response) {
                    if (response.status == "success") {
                        showTable();
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/attendance-settings/ajax/shift-rotation.blade.php ENDPATH**/ ?>