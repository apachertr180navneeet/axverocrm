<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center">
          <div class="card-body">
            <div class="mb-4">
              <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                <path d="M20 6L9 17L4 12" stroke="currentColor" />
              </svg>
            </div>
            <h2 class="text-success">Payment Successful!</h2>
            <p>Application Submitted Successfully!</p>
            <p><strong>Application ID:</strong> #<?php echo e($hiring->id); ?></p>
            <p><strong>Name:</strong> <?php echo e($hiring->name ?? 'N/A'); ?></p>
            <p><strong>Mobile:</strong> <?php echo e($hiring->mobile ?? 'N/A'); ?></p>
            <p><strong>Amount Paid:</strong> ₹<?php echo e(number_format($hiring->amount, 2)); ?></p>
            <p><strong>Status:</strong> <span class="badge bg-success"><?php echo e(strtoupper($hiring->payment_status)); ?></span>
            </p>
            
            <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary">Go Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/hiring/success.blade.php ENDPATH**/ ?>