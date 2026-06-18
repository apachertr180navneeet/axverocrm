<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Retainer Application</title>
<style>
body{font-family: DejaVu Sans;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
td,th{border:1px solid #000;padding:8px;text-align:left;}
th{background:#f0f0f0;}
h2{text-align:center;}
</style>
</head>
<body>
<h2>Retainer Application Details</h2>
<table>
<tr><th width="35%">Application ID</th><td>#{{ $submission->id }}</td></tr>
<tr><th>Name</th><td>{{ $submission->name }}</td></tr>
<tr><th>Mobile</th><td>{{ $submission->mobile }}</td></tr>
<tr><th>Email</th><td>{{ $submission->email }}</td></tr>
<tr><th>Address</th><td>{{ $submission->address ?? '--' }}</td></tr>
<tr><th>Designation</th><td>{{ $submission->designation ?? '--' }}</td></tr>
<tr><th>Department</th><td>{{ $submission->department ?? '--' }}</td></tr>
<tr><th>Senior Manager</th><td>{{ $submission->senior_manager_name ?? '--' }}</td></tr>
<tr><th>Senior Manager Mobile</th><td>{{ $submission->senior_manager_mobile ?? '--' }}</td></tr>
<tr><th>Referred Executive</th><td>{{ $submission->referred_executive_name ?? '--' }}</td></tr>
<tr><th>Relationship Manager</th><td>{{ $submission->relationship_manager_name ?? '--' }}</td></tr>
<tr><th>Amount</th><td>₹{{ number_format($submission->amount, 2) }}</td></tr>
<tr><th>Transaction ID</th><td>{{ $submission->txnid ?? '--' }}</td></tr>
<tr><th>Payment Status</th><td>{{ strtoupper($submission->payment_status) }}</td></tr>
<tr><th>Submitted At</th><td>{{ $submission->submitted_at ? $submission->submitted_at->format('d-m-Y H:i:s') : '--' }}</td></tr>
<tr><th>Paid At</th><td>{{ $submission->paid_at ? $submission->paid_at->format('d-m-Y H:i:s') : '--' }}</td></tr>
</table>
</body>
</html>
