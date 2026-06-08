<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="w-100 d-flex">
        <?php echo $__env->make('sections.setting-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if (isset($component)) { $__componentOriginalcb8848b8ae159c08072bf1971fc3ca1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb8848b8ae159c08072bf1971fc3ca1f = $attributes; } ?>
<?php $component = App\View\Components\SettingCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('setting-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SettingCard::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

             <?php $__env->slot('buttons', null, []); ?> 
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <?php if (isset($component)) { $__componentOriginalcf8d12533ff890e0d6573daf32b7618d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf8d12533ff890e0d6573daf32b7618d = $attributes; } ?>
<?php $component = App\View\Components\Forms\ButtonPrimary::resolve(['icon' => 'plus'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.button-primary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Forms\ButtonPrimary::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'add-field','class' => 'mb-2']); ?> <?php echo app('translator')->get('modules.customFields.addField'); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf8d12533ff890e0d6573daf32b7618d)): ?>
<?php $attributes = $__attributesOriginalcf8d12533ff890e0d6573daf32b7618d; ?>
<?php unset($__attributesOriginalcf8d12533ff890e0d6573daf32b7618d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf8d12533ff890e0d6573daf32b7618d)): ?>
<?php $component = $__componentOriginalcf8d12533ff890e0d6573daf32b7618d; ?>
<?php unset($__componentOriginalcf8d12533ff890e0d6573daf32b7618d); ?>
<?php endif; ?>
                    </div>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('header', null, []); ?> 
                <div class="s-b-n-header" id="tabs">
                    <h2 class="mb-0 p-20 f-21 font-weight-normal  border-bottom-grey">
                        <?php echo app('translator')->get($pageTitle); ?>
                    </h2>
                </div>
             <?php $__env->endSlot(); ?>

            <div class="table-responsive p-20 pipelineData">
                <div class="col-lg-12 col-md-12 ntfcn-tab-content-left w-100">
                    <?php $__empty_1 = true; $__currentLoopData = $groupedCustomFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="row no-gutters border rounded my-3 px-4 py-2" id="removeModule<?php echo e($module); ?>">
                            <div class="col-md-6">
                                <div class="heading-h4">
                                    <?php echo e($module); ?>

                                </div>

                                <div class="simple-text text-lightest mt-1">
                                    <span id="moduleCount<?php echo e($module); ?>"><?php echo e($fields->count()); ?></span>

                                    <?php if($fields->count() == 1): ?>
                                        <?php echo app('translator')->get('modules.customFields.field'); ?>
                                    <?php else: ?>
                                        <?php echo app('translator')->get('modules.customFields.fields'); ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="col-md-2 text-right module-header" data-module="<?php echo e($module); ?>" style="margin-left: 390px;">
                                <?php if (isset($component)) { $__componentOriginal5e57c6582b8a883148a28bb7ee46d2ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5e57c6582b8a883148a28bb7ee46d2ad = $attributes; } ?>
<?php $component = App\View\Components\Forms\ButtonSecondary::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.button-secondary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Forms\ButtonSecondary::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'view-pipeline']); ?>
                                    <i class="side-icon bi bi-kanban"></i>
                                    <?php echo app('translator')->get('modules.customFields.viewFields'); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5e57c6582b8a883148a28bb7ee46d2ad)): ?>
<?php $attributes = $__attributesOriginal5e57c6582b8a883148a28bb7ee46d2ad; ?>
<?php unset($__attributesOriginal5e57c6582b8a883148a28bb7ee46d2ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5e57c6582b8a883148a28bb7ee46d2ad)): ?>
<?php $component = $__componentOriginal5e57c6582b8a883148a28bb7ee46d2ad; ?>
<?php unset($__componentOriginal5e57c6582b8a883148a28bb7ee46d2ad); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="custom-fields-table" data-module="<?php echo e($module); ?>" style="display: none;">
                            <?php if (isset($component)) { $__componentOriginal7d9f6e0b9001f5841f72577781b2d17f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d9f6e0b9001f5841f72577781b2d17f = $attributes; } ?>
<?php $component = App\View\Components\Table::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Table::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-bordered','id' => 'removeModuleColumns'.e($module).'']); ?>
                                 <?php $__env->slot('thead', null, []); ?> 
                                    <th><?php echo app('translator')->get('modules.customFields.moduleLabel'); ?></th>
                                    <th><?php echo app('translator')->get('modules.customFields.type'); ?></th>
                                    <th><?php echo app('translator')->get('modules.customFields.values'); ?></th>
                                    <th><?php echo app('translator')->get('modules.customFields.required'); ?></th>
                                    <th><?php echo app('translator')->get('modules.customFields.showInTable'); ?></th>
                                    <th><?php echo app('translator')->get('modules.customFields.export'); ?></th>
                                    <th><?php echo app('translator')->get('app.action'); ?></th>
                                 <?php $__env->endSlot(); ?>
                                <?php $__empty_2 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <tr class="row<?php echo e($field->id); ?>">
                                        <td><?php echo e($field->label); ?></td>
                                        <td><?php echo e($field->type); ?></td>
                                        <td>
                                            <?php if(isset($field->values) && $field->values != '[null]'): ?>
                                                <ul class="value-list">
                                                    <?php $__currentLoopData = json_decode($field->values); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($value); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php else: ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($field->required === 'yes'): ?>
                                                <span class="badge badge-danger disabled color-palette"><?php echo app('translator')->get('app.yes'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary disabled color-palette"><?php echo app('translator')->get('app.no'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($field->visible == 'true'): ?>
                                                <span class="badge badge-danger disabled color-palette"><?php echo app('translator')->get('app.yes'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary disabled color-palette"><?php echo app('translator')->get('app.no'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($field->export == 1): ?>
                                                <span class="badge badge-danger disabled color-palette"><?php echo app('translator')->get('app.yes'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary disabled color-palette"><?php echo app('translator')->get('app.no'); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="task_view">
                                                <a data-user-id="<?php echo e($field->id); ?>" class="task_view_more d-flex align-items-center justify-content-center edit-custom-field" href="javascript:;">
                                                    <i class="fa fa-edit icons mr-2"></i> <?php echo e(__('app.edit')); ?>

                                                </a>
                                            </div>
                                            <div class="task_view">
                                                <a data-user-id="<?php echo e($field->id); ?>" data-module="<?php echo e($module); ?>" class="task_view_more d-flex align-items-center justify-content-center sa-params" href="javascript:;">
                                                    <i class="fa fa-trash icons mr-2"></i> <?php echo e(__('app.delete')); ?>

                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <tr>
                                        <td colspan="7">
                                            <?php if (isset($component)) { $__componentOriginal269164c77d9d34462c34359c03da6a68 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal269164c77d9d34462c34359c03da6a68 = $attributes; } ?>
<?php $component = App\View\Components\Cards\NoRecord::resolve(['icon' => 'list','message' => __('messages.noCustomField')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('cards.no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Cards\NoRecord::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal269164c77d9d34462c34359c03da6a68)): ?>
<?php $attributes = $__attributesOriginal269164c77d9d34462c34359c03da6a68; ?>
<?php unset($__attributesOriginal269164c77d9d34462c34359c03da6a68); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal269164c77d9d34462c34359c03da6a68)): ?>
<?php $component = $__componentOriginal269164c77d9d34462c34359c03da6a68; ?>
<?php unset($__componentOriginal269164c77d9d34462c34359c03da6a68); ?>
<?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d9f6e0b9001f5841f72577781b2d17f)): ?>
<?php $attributes = $__attributesOriginal7d9f6e0b9001f5841f72577781b2d17f; ?>
<?php unset($__attributesOriginal7d9f6e0b9001f5841f72577781b2d17f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d9f6e0b9001f5841f72577781b2d17f)): ?>
<?php $component = $__componentOriginal7d9f6e0b9001f5841f72577781b2d17f; ?>
<?php unset($__componentOriginal7d9f6e0b9001f5841f72577781b2d17f); ?>
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="align-items-center d-flex flex-column text-lightest p-20 w-100">
                            <i class="fa fa-clipboard f-21 w-100"></i>

                            <div class="f-15 mt-4">
                                - <?php echo app('translator')->get('messages.noRecordFound'); ?> -
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb8848b8ae159c08072bf1971fc3ca1f)): ?>
<?php $attributes = $__attributesOriginalcb8848b8ae159c08072bf1971fc3ca1f; ?>
<?php unset($__attributesOriginalcb8848b8ae159c08072bf1971fc3ca1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb8848b8ae159c08072bf1971fc3ca1f)): ?>
<?php $component = $__componentOriginalcb8848b8ae159c08072bf1971fc3ca1f; ?>
<?php unset($__componentOriginalcb8848b8ae159c08072bf1971fc3ca1f); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <script>

        $(function () {

            // Hide all custom field tables initially
            $('.custom-fields-table').hide();

            // Toggle visibility of the custom fields table on module header click
            $('.module-header').click(function() {
                var module = $(this).data('module');
                var table = $('.custom-fields-table[data-module="' + module + '"]');
                table.toggle();
            });

            $('body').on('click', '.sa-params', function () {
                const id = $(this).data('user-id');
                var module = $(this).data('module');

                Swal.fire({
                    title: "<?php echo app('translator')->get('messages.sweetAlertTitle'); ?>",
                    text: "<?php echo app('translator')->get('messages.deleteField'); ?>",
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

                        let url = "<?php echo e(route('custom-fields.destroy',':id')); ?>";
                        url = url.replace(':id', id);

                        const token = "<?php echo e(csrf_token()); ?>";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            blockUI: true,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $('.row'+id).fadeOut();
                                    const updatedCount = response.updatedCount;
                                    $('#moduleCount' + module).html(updatedCount);
                                    if (updatedCount == 0) {
                                        $('#removeModule' + module).fadeOut().remove();
                                        $('#removeModuleColumns' + module).fadeOut().remove();
                                    }
                                }
                            }
                        });
                    }
                });
            });

        });

        function updateFieldCount(module) {
            let fieldCount = $('.custom-fields-table[data-module="' + module + '"] tr').length - 1;
            let fieldText = fieldCount === 1 ? '<?php echo app('translator')->get('modules.customFields.field'); ?>' : '<?php echo app('translator')->get('modules.customFields.fields'); ?>';
            console.log(fieldCount+ ' ,'+fieldText);
            $('.module-header[data-module="' + module + '"]').siblings('.heading-h4').find('.simple-text').text(fieldCount + ' ' + fieldText);
        }

        $('body').on('click', '#add-field', function () {
            const url = "<?php echo e(route('custom-fields.create')); ?>";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('body').on('click', '.edit-custom-field', function () {
            const id = $(this).data('user-id');
            let url = "<?php echo e(route('custom-fields.edit',':id')); ?>";
            url = url.replace(':id', id);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/custom-fields/index.blade.php ENDPATH**/ ?>