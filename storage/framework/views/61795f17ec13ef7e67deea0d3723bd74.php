            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <title>Report Manager PDF</title>
            
            <style>
            body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            }
            
            h2{
            text-align:center;
            margin-bottom:10px;
            }
            
            table{
            width:100%;
            border-collapse:collapse;
            margin-bottom:15px;
            }
            
            table,th,td{
            border:1px solid #000;
            }
            
            th{
            background:#f2f2f2;
            }
            
            th,td{
            padding:6px;
            text-align:left;
            }
            
            .section-title{
            margin-top:20px;
            font-weight:bold;
            font-size:14px;
            }
            </style>
            </head>
            
            <body>
            
            <h2>Report Manager</h2>
            
            <table>
            <tr>
            <th>Date</th>
            <td><?php echo e($report->report_date); ?></td>
            </tr>
            
            <tr>
            <th>Email</th>
            <td><?php echo e($report->portal_email); ?></td>
            </tr>
            
            <tr>
            <th>Name</th>
            <td><?php echo e($report->name); ?></td>
            </tr>
            
            <tr>
            <th>Mobile</th>
            <td><?php echo e($report->mobile); ?></td>
            </tr>
            
            
            
            </table>
            
            
            
            
            <div class="section-title">Today Selected Person Detail</div>
            
            <table>
            
            <thead>
            <tr>
            <th>HR Executive Name</th>
            <th>HR Mobile</th>
            <th>Name</th>
            <th>Person Mobile</th>
            <th>Salary</th>
            <th>Email</th>
            <th>Designation</th>
            <th>Joining Date</th>
            </tr>
            </thead>
            
            <tbody>
            
            <?php $__empty_1 = true; $__currentLoopData = $selectedPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <tr>
            <td><?php echo e($row['hr_name'] ?? ''); ?></td>
            <td><?php echo e($row['hr_mobile'] ?? ''); ?></td>
            <td><?php echo e($row['selected_name'] ?? ''); ?></td>
            <td><?php echo e($row['selected_mobile'] ?? ''); ?></td>
            
            <td><?php echo e($row['salary_offered'] ?? ''); ?></td>
            <td><?php echo e($row['person_email'] ?? ''); ?></td>
            
            <td><?php echo e($row['designation'] ?? ''); ?></td>
            <td><?php echo e($row['joining_date'] ?? ''); ?></td>
            
            </tr>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <tr>
            <td colspan="8">No Data</td>
            </tr>
            
            <?php endif; ?>
            
            </tbody>
            </table>
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="section-title">Total Team Detail</div>
            
            <table>
            
            <thead>
            <tr>
            <th>HR Executive Name</th>
            <th>HR Mobile</th>
            <th>Total HR Executive</th>
            <th>Total Sales Executive</th>
            </tr>
            </thead>
            
            <tbody>
            
            <?php $__empty_1 = true; $__currentLoopData = $teamDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <tr>
            
            <td><?php echo e($row['hr_name'] ?? ''); ?></td>
            <td><?php echo e($row['hr_mobile'] ?? ''); ?></td>
            <td><?php echo e($row['total_active_executive'] ?? ''); ?></td>
            <td><?php echo e($row['total_active_retainer'] ?? ''); ?></td>
            
            </tr>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <tr>
            <td colspan="4">No Data</td>
            </tr>
            
            <?php endif; ?>
            
            </tbody>
            
            </table>
            
            </body>
            </html><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/daily-report-pdf.blade.php ENDPATH**/ ?>