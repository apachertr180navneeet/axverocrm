<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>PayU Report</title>
  <style>
    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
    }

    h2 {
      text-align: center;
      color: #667eea;
      margin-bottom: 5px;
    }

    .subtitle {
      text-align: center;
      font-size: 10px;
      margin-bottom: 15px;
      color: #666;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      background: #667eea;
      color: white;
      padding: 8px;
      text-align: left;
    }

    td {
      border: 1px solid #ddd;
      padding: 6px;
    }

    .success {
      color: #10b981;
      font-weight: bold;
    }

    .pending {
      color: #f59e0b;
      font-weight: bold;
    }

    .failed {
      color: #ef4444;
      font-weight: bold;
    }

    .footer {
      margin-top: 15px;
      text-align: center;
      font-size: 9px;
      color: #999;
    }
  </style>
</head>

<body>
  <h2>PayU Hiring Applications Report</h2>
  <div class="subtitle">Generated on: <?php echo e(date('d-m-Y H:i:s')); ?></div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><?php echo e($row->id); ?></td>
          <td><?php echo e($row->name); ?></td>
          <td><?php echo e($row->mobile); ?></td>
          <td><?php echo e($row->email); ?></td>
          <td><?php echo e($row->designation); ?></td>
          <td><?php echo e($row->department); ?></td>
          <td>₹<?php echo e(number_format($row->amount, 2)); ?></td>
          <td class="<?php echo e($row->payment_status); ?>"><?php echo e(strtoupper($row->payment_status)); ?></td>
          <td><?php echo e($row->created_at->format('d-m-Y')); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <div class="footer">
    Total Records: <?php echo e($data->count()); ?> | Total Amount: ₹<?php echo e(number_format($data->sum('amount'), 2)); ?>

  </div>
</body>

</html><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/hiring/pdf/payu_report.blade.php ENDPATH**/ ?>