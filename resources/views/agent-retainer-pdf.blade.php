<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Retainer</title>

<style>

body{
font-family: DejaVu Sans;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

td,th{
border:1px solid #000;
padding:8px;
}

h2{
text-align:center;
}

</style>

</head>

<body>

<h2>Retainer Details</h2>

<table>

<tr>
<th width="30%">Name</th>
<td>{{ $agent->name }}</td>
</tr>

<tr>
<th>Mobile</th>
<td>{{ $agent->mobile }}</td>
</tr>

<tr>
<th>Address</th>
<td>{{ $agent->address }}</td>
</tr>

<tr>
<th>Gender</th>
<td>{{ ucfirst($agent->gender) }}</td>
</tr>

<tr>
<th>Date Of Birth</th>
<td>{{ $agent->date_of_birth }}</td>
</tr>

<tr>
<th>Marital Status</th>
<td>{{ $agent->marital_status }}</td>
</tr>

<tr>
<th>Recommended Person Name </th>
<td>{{ $agent->person_name }}</td>
</tr>

<tr>
<th>Recommended Person Mobile</th>
<td>{{ $agent->person_mobile }}</td>
</tr>

</table>

</body>
</html>