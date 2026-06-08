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
<td><?php echo e($agent->name); ?></td>
</tr>

<tr>
<th>Mobile</th>
<td><?php echo e($agent->mobile); ?></td>
</tr>

<tr>
<th>Address</th>
<td><?php echo e($agent->address); ?></td>
</tr>

<tr>
<th>Gender</th>
<td><?php echo e(ucfirst($agent->gender)); ?></td>
</tr>

<tr>
<th>Date Of Birth</th>
<td><?php echo e($agent->date_of_birth); ?></td>
</tr>

<tr>
<th>Marital Status</th>
<td><?php echo e($agent->marital_status); ?></td>
</tr>

<tr>
<th>Recommended Person Name </th>
<td><?php echo e($agent->person_name); ?></td>
</tr>

<tr>
<th>Recommended Person Mobile</th>
<td><?php echo e($agent->person_mobile); ?></td>
</tr>

</table>

</body>
</html><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/agent-retainer-pdf.blade.php ENDPATH**/ ?>