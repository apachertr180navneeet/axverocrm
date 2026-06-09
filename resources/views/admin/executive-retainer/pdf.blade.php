<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 15px; line-height: 1.6; }
h2 { text-align: center; margin-bottom: 5px; }
.header-line { border-bottom: 2px solid #2c4a7a; margin-bottom: 15px; }
.section { background: #e9edf2; padding: 6px 8px; font-weight: bold; margin-top: 18px; font-size: 12px; }
table { width: 100%; border-collapse: collapse; margin-top: 5px; }
td { border: 1px solid #c3c7cc; padding: 6px 8px; vertical-align: top; }
.label { font-weight: bold; width: 120px; }
</style>
</head>
<body>

<h2>Advance Income Form</h2>
<div class="header-line"></div>

<table>
    <tr><td class="label">@lang('app.name')</td><td>{{ $application->name }}</td></tr>
    <tr><td class="label">@lang('app.mobile')</td><td>{{ $application->mobile }}</td></tr>
    <tr><td class="label">@lang('app.email')</td><td>{{ $application->email }}</td></tr>
    <tr><td class="label">@lang('app.jobpost')</td><td>{{ $application->post }}</td></tr>
    <tr><td class="label">@lang('app.dateOfJoining')</td><td>{{ $application->date_of_joining->format('d-m-Y') }}</td></tr>
    <tr><td class="label">@lang('app.amount')</td><td>&#x20B9;{{ number_format($application->amount, 2) }}</td></tr>
    <tr><td class="label">@lang('app.paymentStatus')</td><td>{{ ucfirst($application->payment_status) }}</td></tr>
    <tr><td class="label">@lang('app.txnid')</td><td>{{ $application->txnid ?? '--' }}</td></tr>
    @if($application->paid_at)
    <tr><td class="label">@lang('app.paidAt')</td><td>{{ $application->paid_at->format('d-m-Y h:i A') }}</td></tr>
    @endif
</table>

@if($application->hired_executives)
<div class="section">@lang('app.hireExecutives')</div>
<table>
    <tr>
        <td><strong>#</strong></td>
        <td><strong>@lang('app.name')</strong></td>
        <td><strong>@lang('app.mobile')</strong></td>
        <td><strong>@lang('app.joiningDate')</strong></td>
    </tr>
    @foreach($application->hired_executives as $index => $exec)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $exec['name'] ?? '--' }}</td>
        <td>{{ $exec['mobile'] ?? '--' }}</td>
        <td>{{ isset($exec['joining_date']) ? \Carbon\Carbon::parse($exec['joining_date'])->format('d-m-Y') : '--' }}</td>
    </tr>
    @endforeach
</table>
@endif

@if($application->hired_retainers)
<div class="section">@lang('app.hireRetainers')</div>
<table>
    <tr>
        <td><strong>#</strong></td>
        <td><strong>@lang('app.name')</strong></td>
        <td><strong>@lang('app.mobile')</strong></td>
        <td><strong>@lang('app.joiningDate')</strong></td>
        td><strong>@lang('app.jobPost')</strong></td>
    </tr>
    @foreach($application->hired_retainers as $index => $ret)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $ret['name'] ?? '--' }}</td>
        <td>{{ $ret['mobile'] ?? '--' }}</td>
        <td>{{ isset($ret['joining_date']) ? \Carbon\Carbon::parse($ret['joining_date'])->format('d-m-Y') : '--' }}</td>
        <td>{{ $ret['job_post'] ?? '--' }}</td>
    </tr>
    @endforeach
</table>
@endif

@if($application->retainer_detail)
<div class="section">@lang('app.retainerJoinDetail')</div>
<table>
    <tr><td class="label">@lang('app.name')</td><td>{{ $application->retainer_detail['name'] ?? '--' }}</td></tr>
    <tr><td class="label">@lang('app.mobile')</td><td>{{ $application->retainer_detail['mobile'] ?? '--' }}</td></tr>
    <tr><td class="label">@lang('app.joiningDate')</td><td>{{ isset($application->retainer_detail['joining_date']) ? \Carbon\Carbon::parse($application->retainer_detail['joining_date'])->format('d-m-Y') : '--' }}</td></tr>
    <tr><td class="label">@lang('app.jobPost')</td><td>{{ $application->retainer_detail['job_post'] ?? '--' }}</td></tr>
</table>
@endif

</body>
</html>
