    <!DOCTYPE html>
    <html>
        <head>
        <meta charset="utf-8">
            <title>Executive Report</title>
        
            <style>
            body { font-family: DejaVu Sans; font-size:12px; }
            h2 { text-align:center; margin-bottom:10px; }
            table { width:100%; border-collapse:collapse; margin-bottom:15px; }
            th, td { border:1px solid #000; padding:6px; }
            .section { margin-top:20px; }
            </style>
        </head>
    
    <body>
    
            <h2>Executive Report</h2>
            
            <table>
            <tr>
                <td><strong>Date</strong></td>
                <td><?php echo e(\Carbon\Carbon::parse($report->report_date)->format('d/m/Y')); ?></td>
            </tr>
            
            <tr>
                <td><strong>Portal Email</strong></td>
                <td><?php echo e($report->portal_email); ?></td>
            </tr>
            
            <tr>
                <td><strong>Name</strong></td>
                <td><?php echo e($report->name); ?></td>
            </tr>
            
            <tr>
                <td><strong>Mobile</strong></td>
                <td><?php echo e($report->mobile); ?></td>
            </tr>
            
            <tr>
                <td><strong>HR Manager</strong></td>
                <td><?php echo e($report->hr_manager_name); ?></td>
            </tr>
            
            <tr>
                <td><strong>HR Manager Mobile</strong></td>
                <td><?php echo e($report->hr_manager_mobile); ?></td>
            </tr>
            
            </table>
            
            
            
            <div class="section">
            <h4>Today Selected Person's Report</h4>
            
            <table>
            
            <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Designation</th>
            <th>Joining Date</th>
            <th>Email</th>
            </tr>
            
            <?php $__empty_1 = true; $__currentLoopData = $selectedPersons ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <tr>
            <td><?php echo e($person['name'] ?? ''); ?></td>
            
            <td><?php echo e($person['mobile'] ?? ''); ?></td>
            
            <td><?php echo e($person['designation'] ?? ''); ?></td>
            
            <td>
            <?php if(!empty($person['joining_date'])): ?>
            <?php echo e(\Carbon\Carbon::parse($person['joining_date'])->format('d/m/Y')); ?>

            <?php endif; ?>
            </td>
            
            <td><?php echo e($person['email'] ?? ''); ?></td>
            </tr>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <tr>
            <td colspan="5" style="text-align:center;">No Data Available</td>
            </tr>
            
            <?php endif; ?>
            
            </table>
            
            </div>
            
            
            
            <div class="section">
            
            <h4>Follow Up Candidates Detail</h4>
            
            <table>
            
            <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Interview Date</th>
            </tr>
            
            <?php $__empty_1 = true; $__currentLoopData = $followUp ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <tr>
            <td><?php echo e($person['name'] ?? ''); ?></td>
            
            <td><?php echo e($person['mobile'] ?? ''); ?></td>
            
            <td>
            <?php if(!empty($person['interview_date'])): ?>
            <?php echo e(\Carbon\Carbon::parse($person['interview_date'])->format('d/m/Y')); ?>

            <?php endif; ?>
            </td>
            
            </tr>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <tr>
            <td colspan="3" style="text-align:center;">No Data Available</td>
            </tr>
            
            <?php endif; ?>
            
            </table>
            
            </div>
            
            
            
            <div class="section">
            
            <h4>Detail of Joined Total Candidate</h4>
            
            <table>
            
            <tr>
            <th>Total HR Executive</th>
            <th>Total Sales Executive</th>
            </tr>
            
            <?php $__empty_1 = true; $__currentLoopData = $totalJoined ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <tr>
            <td><?php echo e($total['total_executive'] ?? ''); ?></td>
            <td><?php echo e($total['total_sales_executive'] ?? ''); ?></td>
            </tr>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <tr>
            <td colspan="2" style="text-align:center;">No Data Available</td>
            </tr>
            
            <?php endif; ?>
            
            </table>
            
            </div>
            
    </body>
    </html><?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/hr-report-pdf.blade.php ENDPATH**/ ?>