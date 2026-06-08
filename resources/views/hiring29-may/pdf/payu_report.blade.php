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
  <div class="subtitle">Generated on: {{ date('d-m-Y H:i:s') }}</div>

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
      @foreach($data as $row)
        <tr>
          <td>{{ $row->id }}</td>
          <td>{{ $row->name }}</td>
          <td>{{ $row->mobile }}</td>
          <td>{{ $row->email }}</td>
          <td>{{ $row->designation }}</td>
          <td>{{ $row->department }}</td>
          <td>₹{{ number_format($row->amount, 2) }}</td>
          <td class="{{ $row->payment_status }}">{{ strtoupper($row->payment_status) }}</td>
          <td>{{ $row->created_at->format('d-m-Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    Total Records: {{ $data->count() }} | Total Amount: ₹{{ number_format($data->sum('amount'), 2) }}
  </div>
</body>

</html>