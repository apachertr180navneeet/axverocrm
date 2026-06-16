<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Applications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2>My Hiring Applications</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Designation</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach($applications as $app)
          <tr>
            <td>#{{ $app->id }}</td>
            <td>{{ $app->name }}</td>
            <td>{{ $app->designation }}</td>
            <td>₹{{ number_format($app->advance_amount, 2) }}</td>
            <td>
              <span class="badge bg-{{ $app->payment_status == 'paid' ? 'success' : 'warning' }}">
                {{ $app->payment_status }}
              </span>
            </td>
            <td>{{ $app->created_at->format('d-m-Y') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $applications->links() }}
  </div>
</body>

</html>