<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reference</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Reference Details</h2>

<div class="info">
    <strong>Senior Name:</strong> <?php echo e($refference->senior_name); ?> <br>
    <strong>Mobile:</strong> <?php echo e($refference->senior_mobile); ?> <br>
    <strong>Portal ID:</strong> <?php echo e($refference->user_id); ?>

</div>

<?php
    $candidates = is_array($refference->candidates)
        ? $refference->candidates
        : json_decode($refference->candidates, true);
?>

<h3>Candidates</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Gender</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e($c['name']); ?></td>
            <td><?php echo e($c['mobile']); ?></td>
            <td><?php echo e($c['gender']); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

</body>
</html><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/refference/pdf.blade.php ENDPATH**/ ?>