<a href="<?php echo e($href); ?>" <?php if($ajax == "false"): ?> <?php echo e($attributes->merge(['class' => 'text-dark-grey  border-right-grey p-sub-menu'])); ?>


<?php else: ?>
<?php echo e($attributes->merge(['class' => 'text-dark-grey  border-right-grey p-sub-menu ajax-tab'])); ?> <?php endif; ?>><span><?php echo e($text); ?></span></a>
<?php /**PATH /home/u566596326/domains/hreomshopping.in/public_html/resources/views/components/tab.blade.php ENDPATH**/ ?>