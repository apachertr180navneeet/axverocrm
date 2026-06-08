<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Failed</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center">
          <div class="card-body">
            <div class="mb-4">
              <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                <circle cx="12" cy="12" r="10" stroke="currentColor" />
                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" />
              </svg>
            </div>
            <h2 class="text-danger">Payment Failed!</h2>
            <p>Your payment could not be processed.</p>
            @if(isset($submission))
              <p><strong>Application ID:</strong> #{{ $submission->id }}</p>
              <p><strong>Amount:</strong> ₹{{ number_format($submission->amount, 2) }}</p>
              <p><strong>Status:</strong> <span
                  class="badge bg-danger">{{ strtoupper($submission->payment_status) }}</span></p>
            @endif
            <p>Please try again or contact support.</p>
            <a href="{{ route('hiring.create') }}" class="btn btn-primary">Try Again</a>
            <a href="{{ url('/') }}" class="btn btn-secondary">Go Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>