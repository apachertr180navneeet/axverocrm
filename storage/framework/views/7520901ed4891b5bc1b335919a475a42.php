<div class="modal-header">
    <h5 class="modal-title" id="modelHeading"><?php echo app('translator')->get('app.attendanceDetails'); ?></h5>
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>

<div class="modal-body bg-grey">

    <div class="row">
        <?php
            $minimumHalfDayMinutes = ((float)$attendance->shift->flexible_half_day_hours * 60);
            $totalMinimumMinutes = ((float)$attendance->shift->flexible_total_hours * 60);
            $clockedTotalMinutes = floor((float)$totalTime / 60);
        ?>

        <?php if($attendance->shift->shift_type == 'flexible'): ?>

            <?php if($clockedTotalMinutes < $minimumHalfDayMinutes): ?>
            <div class="col-md-12">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?><?php echo app('translator')->get('messages.halfdayHoursNotComplete'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>            
            <?php elseif($clockedTotalMinutes >= $minimumHalfDayMinutes && $clockedTotalMinutes < $totalMinimumMinutes): ?>
            <div class="col-md-12">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?><?php echo app('translator')->get('messages.willMarkHalfDay'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>  
            <?php endif; ?>
        <?php endif; ?>

        <div class="col-md-6">
            <?php if (isset($component)) { $__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9 = $attributes; } ?>
<?php $component = App\View\Components\Cards\Data::resolve(['title' => __('app.date').' - '.$attendanceDate->translatedFormat(company()->date_format) .' ('.$attendanceDate->translatedFormat('l').')'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('cards.data'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Cards\Data::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <div class="punch-status">
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h6 class="f-13"><?php echo app('translator')->get('modules.attendance.clock_in'); ?></h6>
                        <p class="mb-0"><?php echo e($startTime->translatedFormat(company()->time_format)); ?></p>
                    </div>
                    <div class="punch-info">
                        <div class="punch-hours f-13">
                            <span><?php echo e($totalTimeFormatted); ?></span>
                        </div>
                    </div>
                    <div class="border rounded p-3 bg-light">
                        <p class="mb-0"><?php echo e($endTime != '' ? $endTime->translatedFormat(company()->time_format) : ''); ?>

                            <?php if(isset($notClockedOut)): ?>
                                (<?php echo app('translator')->get('modules.attendance.currentTime'); ?>)
                            <?php endif; ?>
                        </p>
                    </div>

                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9)): ?>
<?php $attributes = $__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9; ?>
<?php unset($__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9)): ?>
<?php $component = $__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9; ?>
<?php unset($__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9); ?>
<?php endif; ?>
        </div>
        <div class="col-md-6">

            <?php if (isset($component)) { $__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9 = $attributes; } ?>
<?php $component = App\View\Components\Cards\Data::resolve(['title' => __('modules.employees.activity')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('cards.data'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Cards\Data::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

                <div class="recent-activity h-auto">
                    <?php $__currentLoopData = $attendanceActivity->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row res-activity-box" id="timelogBox<?php echo e($item->aId); ?>">
                            <ul class="res-activity-list col-md-9">
                                <li>
                                    <p class="mb-0"><?php echo app('translator')->get('modules.attendance.clock_in'); ?>
                                        <?php if(!is_null($item->employee_shift_id)): ?>
                                            <?php if($item->shift->shift_name != 'Day Off'): ?>
                                                <span class="badge badge-info ml-2" style="background-color: <?php echo e($item->shift->color); ?>"><?php echo e($item->shift->shift_name); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary ml-2" ><?php echo e(__('modules.attendance.' . str($attendanceSettings->shift_name)->camel())); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock"></i>
                                        <?php echo e($item->clock_in_time->timezone(company()->timezone)->translatedFormat(company()->date_format . ' ' . company()->time_format)); ?>


                                        <?php if($item->work_from_type != ''): ?>
                                            <?php if($item->work_from_type == 'other'): ?>
                                                <i class="fa fa-map-marker-alt ml-2"></i>
                                                <?php echo e($item->location); ?> <?php echo e($item->working_from != '' ? '(' . $item->working_from . ')' : ''); ?>

                                            <?php else: ?>
                                                <i class="fa fa-map-marker-alt ml-2"></i>
                                                <?php echo e($item->location); ?> (<?php echo e($item->work_from_type); ?>)
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if($item->late == 'yes'): ?>
                                            <i class="fa fa-exclamation-triangle ml-2"></i>
                                            <?php echo app('translator')->get('modules.attendance.late'); ?>
                                        <?php endif; ?>

                                        <?php if($item->half_day == 'yes'): ?>
                                            <i class="fa fa-sign-out-alt ml-2"></i>
                                            <?php echo app('translator')->get('modules.attendance.halfDay'); ?>
                                            <span>
                                                <?php if($item->half_day_type == 'first_half'): ?>
                                                    ( <?php echo app('translator')->get('modules.leaves.1stHalf'); ?> )
                                                <?php elseif($item->half_day_type == 'second_half'): ?>
                                                    ( <?php echo app('translator')->get('modules.leaves.2ndHalf'); ?> )
                                                <?php else: ?>

                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>

                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0"><?php echo app('translator')->get('modules.attendance.clock_out'); ?></p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock"></i>
                                        <?php if(!is_null($item->clock_out_time)): ?>
                                            <?php echo e($item->clock_out_time->timezone(company()->timezone)->translatedFormat(company()->date_format . ' ' . company()->time_format)); ?>

                                            <?php if($item->auto_clock_out): ?>
                                                <i class="fa fa-sign-out-alt ml-2"></i>
                                                <?php echo app('translator')->get('modules.attendance.autoClockOut'); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo app('translator')->get('modules.attendance.notClockOut'); ?>
                                        <?php endif; ?>
                                    </p>
                                </li>
                            </ul>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9)): ?>
<?php $attributes = $__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9; ?>
<?php unset($__attributesOriginalbc9540fa671f26a0f8028a5a8d8f93e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9)): ?>
<?php $component = $__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9; ?>
<?php unset($__componentOriginalbc9540fa671f26a0f8028a5a8d8f93e9); ?>
<?php endif; ?>
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="mr-3 rounded btn-cancel" data-dismiss="modal"><?php echo app('translator')->get('app.cancel'); ?></button>
    <button type="button" onclick="clockOut()" class="rounded btn-danger"><i
        class="icons icon-login mr-2"></i><?php echo app('translator')->get('modules.attendance.clock_out'); ?></button>
</div>
<script>

 

</script>
<?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/dashboard/employee/show_clocked_hours.blade.php ENDPATH**/ ?>