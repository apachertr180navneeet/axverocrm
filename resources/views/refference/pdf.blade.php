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
    <strong>Senior Name:</strong> {{ $refference->senior_name }} <br>
    <strong>Mobile:</strong> {{ $refference->senior_mobile }} <br>
    <strong>Portal ID:</strong> {{ $refference->user_id }}
</div>

@php
    $candidates = is_array($refference->candidates)
        ? $refference->candidates
        : json_decode($refference->candidates, true);
@endphp

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
        @foreach($candidates as $i => $c)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $c['name'] }}</td>
            <td>{{ $c['mobile'] }}</td>
            <td>{{ $c['gender'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>