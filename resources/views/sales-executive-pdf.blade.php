<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Executive Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        .section-title {
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Sales Executive Report</h2>

<table>
    <tr>
        <th>Name</th>
        <td>{{ $report->name }}</td>
    </tr>
    <tr>
        <th>Mobile</th>
        <td>{{ $report->mobile }}</td>
    </tr>
    <tr>
        <th>Portal ID</th>
        <td>{{ $report->portal_id }}</td>
    </tr>
    <tr>
        <th>Manager Name</th>
        <td>{{ $report->manager_name }}</td>
    </tr>
    <tr>
        <th>Manager Mobile</th>
        <td>{{ $report->manager_mobile }}</td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td>{{ $report->created_at->format('d-m-Y h:i A') }}</td>
    </tr>
</table>

<div class="section-title">Today's Sales Details</div>

<table>
    <tr>
        <th>Today Sales Number</th>
        <td>{{ $report->today_sales_number }}</td>
    </tr>
    <tr>
        <th>Today Sales Amount</th>
        <td>{{ number_format($report->today_sales_amount, 2) }}</td>
    </tr>
</table>

<div class="section-title">Total Sales Details</div>

<table>
    <tr>
        <th>Total Sales Number</th>
        <td>{{ $report->total_sales_number }}</td>
    </tr>
    <tr>
        <th>Total Sales Amount</th>
        <td>{{ number_format($report->total_sales_amount, 2) }}</td>
    </tr>
</table>

<div class="section-title">Followup Customers</div>

@if(!empty($followups))
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Mobile</th>
        </tr>
    </thead>
    <tbody>
        @foreach($followups as $index => $followup)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $followup['customer_name'] ?? '' }}</td>
            <td>{{ $followup['mobile'] ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No Followups Added</p>
@endif

</body>
</html>