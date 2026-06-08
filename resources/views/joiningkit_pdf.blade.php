@php
$tenth = is_array($kit->tenth_data) ? $kit->tenth_data : json_decode($kit->tenth_data, true);
$graduation = is_array($kit->graduation_data) ? $kit->graduation_data : json_decode($kit->graduation_data, true);
$experience = is_array($kit->experience_data) ? $kit->experience_data : json_decode($kit->experience_data, true);
$certificates = is_array($kit->certificates) ? $kit->certificates : json_decode($kit->certificates, true);
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* {
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
}
p, td, div {
    word-wrap: break-word;
    overflow-wrap: break-word;
}
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    margin: 15px;
    line-height: 1.6;
}
h2 {
    text-align: center;
    margin-bottom: 5px;
}
.header-line {
    border-bottom: 2px solid #2c4a7a;
    margin-bottom: 15px;
}
.section {
    background: #e9edf2;
    padding: 6px 8px;
    font-weight: bold;
    margin-top: 18px;
    font-size: 12px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
    table-layout: fixed;
}
td {
    border: 1px solid #c3c7cc;
    padding: 8px 10px;
    vertical-align: top;
    word-wrap: break-word;
    overflow-wrap: break-word;
}
.label {
    width: 28%;
    background: #f4f6f8;
    font-weight: bold;
    vertical-align: top;
}
.img-container {
    margin-top: 8px;
}
.img-container img {
    width: 140px;
    margin: 4px;
    display: inline-block;
    vertical-align: middle;
    border: 1px solid #ccc;
    padding: 3px;
}
.page-break {
    page-break-after: always;
}
img {
    margin-top: 8px !important;
}
.tnc-heading {
    font-weight: bold;
    margin-top: 12px;
    margin-bottom: 4px;
    font-size: 11.5px;
}
.tnc-sub {
    font-weight: bold;
    margin-top: 6px;
    margin-bottom: 2px;
    color: #333;
    font-size: 11px;
}
</style>
</head>
<body>

<h2>Joining Agreement Kit Information</h2>
<div class="header-line"></div>

{{-- ================= PERSONAL ================= --}}
<div class="section">1. Personal Details</div>
<table>
<tr><td class="label">Designation</td><td>{{ $kit->designation }}</td></tr>
<tr><td class="label">Joining Date</td><td>{{ $kit->joining_date }}</td></tr>
<tr><td class="label">Full Name</td><td>{{ $kit->first_name }} {{ $kit->last_name }}</td></tr>
<tr><td class="label">Email</td><td>{{ $kit->email }}</td></tr>
<tr><td class="label">Mobile</td><td>{{ $kit->mobile }}</td></tr>
<tr><td class="label">Gender</td><td>{{ $kit->gender }}</td></tr>
<tr><td class="label">DOB</td><td>{{ $kit->dob }}</td></tr>
<tr><td class="label">Marital Status</td><td>{{ $kit->marital_status }}</td></tr>
<tr>
    <td class="label">Permanent Address</td>
    <td>{{ $kit->perm_street }}, {{ $kit->perm_city }}, {{ $kit->perm_state }} - {{ $kit->perm_zip }}, {{ $kit->perm_country }}</td>
</tr>
<tr>
    <td class="label">Current Address</td>
    <td>{{ $kit->curr_street }}, {{ $kit->curr_city }}, {{ $kit->curr_state }} - {{ $kit->curr_zip }}, {{ $kit->curr_country }}</td>
</tr>
<tr>
    <td class="label">Photos</td>
    <td>
        <div class="img-container">
            @if($kit->photo_full)
                <img src="{{ public_path($kit->photo_full) }}">
            @endif
            @if($kit->photo_passport)
                <img src="{{ public_path($kit->photo_passport) }}">
            @endif
        </div>
    </td>
</tr>
</table>

{{-- ================= DOCUMENTS ================= --}}
<div class="section">Documents</div>
<table>
<tr><td class="label">Aadhar Number</td><td>{{ $kit->aadhar_number }}</td></tr>
<tr><td class="label">PAN Number</td><td>{{ $kit->pan_number }}</td></tr>
<tr>
    <td class="label">Aadhar Front</td>
    <td><div class="img-container">@if($kit->aadhar_front)<img src="{{ public_path($kit->aadhar_front) }}">@endif</div></td>
</tr>
<tr>
    <td class="label">Aadhar Back</td>
    <td><div class="img-container">@if($kit->aadhar_back)<img src="{{ public_path($kit->aadhar_back) }}">@endif</div></td>
</tr>
<tr>
    <td class="label">PAN Card</td>
    <td><div class="img-container">@if($kit->pan_image)<img src="{{ public_path($kit->pan_image) }}">@endif</div></td>
</tr>
</table>

<div class="page-break"></div>

{{-- ================= EDUCATION ================= --}}
<div class="section">2. Education Details</div>
<table>
<tr>
    <td class="label">10th Details</td>
    <td>
        @foreach($tenth ?? [] as $edu)
            Year: {{ $edu['year'] ?? '' }}, %: {{ $edu['percentage'] ?? '' }}, Board: {{ $edu['board'] ?? '' }} <br>
        @endforeach
    </td>
</tr>
<tr>
    <td class="label">Highest Qualification</td>
    <td>
        @foreach($graduation ?? [] as $edu)
            {{ $edu['degree'] ?? '' }} - Year: {{ $edu['year'] ?? '' }}, College: {{ $edu['college'] ?? '' }} <br>
        @endforeach
    </td>
</tr>
<tr>
    <td class="label">Certificates</td>
    <td>
        <div class="img-container">
            @foreach($certificates ?? [] as $file)
                <img src="{{ public_path($file) }}">
            @endforeach
        </div>
    </td>
</tr>
</table>

{{-- ================= EXPERIENCE ================= --}}
<div class="section">3. Experience Details</div>
<table>
<tr><td class="label">Status</td><td>{{ $kit->exp_type }}</td></tr>
<tr>
    <td class="label">Details</td>
    <td>
        @foreach($experience ?? [] as $exp)
            Company: {{ $exp['company'] ?? '' }} <br>
            Designation: {{ $exp['designation'] ?? '' }} <br>
            From: {{ $exp['from'] ?? '' }} To: {{ $exp['to'] ?? '' }} <br><br>
        @endforeach
    </td>
</tr>
<tr>
    <td class="label">Documents</td>
    <td>
        <div class="img-container">
            @if($kit->exp_certificate)<img src="{{ public_path($kit->exp_certificate) }}">@endif
            @if($kit->relieving_letter)<img src="{{ public_path($kit->relieving_letter) }}">@endif
        </div>
    </td>
</tr>
</table>

{{-- ================= BANK ================= --}}
<div class="section">4. Bank Details</div>
<table>
<tr><td class="label">Bank Name</td><td>{{ $kit->bank_name }}</td></tr>
<tr><td class="label">Account Holder</td><td>{{ $kit->acc_holder }}</td></tr>
<tr><td class="label">Account Number</td><td>{{ $kit->acc_number }}</td></tr>
<tr><td class="label">IFSC</td><td>{{ $kit->ifsc }}</td></tr>
<tr>
    <td class="label">Passbook</td>
    <td><div class="img-container">@if($kit->passbook)<img src="{{ public_path($kit->passbook) }}">@endif</div></td>
</tr>

{{-- ================= TERMS & CONDITIONS ================= --}}
</table>

<div class="page-break"></div>

<div class="section">5. Terms &amp; Conditions</div>

<div style="font-size:11px; line-height:1.8; padding:10px 5px; word-wrap:break-word;">

<p style="text-align:center; font-weight:bold; background:#e9edf2; padding:8px; margin:0 0 10px 0;">Terms &amp; Conditions &mdash; Easy Online Marketing Company</p>

<p><b>I confirm that I have read and accepted the terms and conditions.</b></p>
<p>We are pleased to welcome you to EASY ONLINE MARKETING COMPANY. The following retainer Terms and Conditions govern. You are requested to carefully read the following terms and conditions and provide your acceptance.</p>
<p>During the probationary period, your engagement with the Company shall be governed by the retainer terms of this Agreement, and the applicable remuneration, rights, and benefits shall be as expressly set out herein.</p>
<p>You are hereby appointed as a Retainer &amp; Department &amp; Recruiter Like HR Executive, HR Manager Trainer &amp; Retainer Sales &amp; Marketing, hereinafter referred to as the "Candidate" for a probationary period of six (6) months on a retainer basis. Upon completion of this period, and subject to your performance being found satisfactory, you may be eligible to apply for confirmation as a permanent employee of the Company, at the Company's sole discretion.</p>
<p>Until the completion of the six-month period, you shall continue to work strictly as a Contract Candidate. During the probation period, you shall be entitled only to a Income Amount as agreed, and no other employee benefits shall be applicable.</p>

<p><b>1. Joining Formalities</b></p>
<p>1.1 Acceptance of the offer and completion of all joining formalities by the candidate shall commence from the date of issuance of the offer letter. In the event the offer is not accepted within three (3) days thereof, the offer shall stand automatically withdrawn without further notice.</p>
<p>1.2 The candidate shall be required to attend all daily scheduled meetings and report directly to the reporting person assigned by the Company.</p>

<p><b>2. Place of Posting</b></p>
<p>You may be assigned to work at any location in India and at any place of business owned, operated, or subsequently acquired by the Company, as per business requirements.</p>

<p><b>3. Attendance and Work Reporting Policy</b></p>
<p>3.1 The Company's standard working hours shall be from 9:00 a.m. to 6:00 p.m., or such other hours as may be prescribed by the Company from time to time based on business requirements.</p>
<p>3.2 For the limited purpose of work tracking, monitoring, and reporting, the candidate shall record attendance by clocking in between 9:00 a.m. and 10:00 a.m. and clocking out between 6:00 p.m. and 6:30 p.m.</p>
<p>3.3 Failure to record a clock-out by 6:30 p.m. shall be deemed as absence for the relevant working day, unless otherwise approved in writing by the reporting authority.</p>
<p>3.4 Clock-in after 10:00 a.m. shall be treated as a half-day leave.</p>
<p>3.5 Clock-in after 11:00 a.m. shall be treated as a full-day leave.</p>
<p>3.6 In the event the candidate records a clock-in but fails to record a corresponding clock-out, such day shall be marked as absent, unless an explanation is provided and accepted in writing by the Company.</p>
<p>3.7 Any request for half-day leave, full-day leave, or absence due to emergency must be communicated to the designated reporting authority in writing and in advance, or at the earliest possible opportunity in case of an emergency.</p>

<p><b>4. Monthly Income Payment Terms</b></p>
<p>4.1 The candidate shall complete a minimum of fifteen (15) working days in a calendar month to be eligible for payment of the fixed retainer fee for that month.</p>
<p>4.2 In the event the candidate disengages from the Company, or the engagement is terminated by the Company, prior to completion of fifteen (15) working days in a calendar month, the candidate shall not be entitled to receive any retainer fee or payment for the services rendered during such period.</p>
<p>4.3 The Income shall be credited to the designated bank account on or before the 10th day of the succeeding month. The Company shall not be liable for delays caused due to bank holidays, strikes, technical issues, or other circumstances beyond the Company's reasonable control.</p>

<p><b>5. Leave and Holidays</b></p>
<p>5.1 The candidate shall not be entitled to any casual leave.</p>
<p>5.2 The candidate shall not be entitled to any paid sick leave. Any absence on account of illness shall be treated as unpaid leave.</p>
<p>5.3 The Company shall, from time to time, communicate in advance the list of declared holidays, if any, applicable for work planning purposes.</p>

<p><b>6. Company Property</b></p>
<p>The candidate shall at all times maintain in good condition any property, equipment, documents, or materials belonging to the Company that may be entrusted for official use during the course of engagement. All such property shall be returned to the Company upon cessation of engagement or upon request by the Company. Failure to return Company property may result in the cost of such property being recovered from the candidate.</p>

<p><b>7. Borrowing and Acceptance of Gifts</b></p>
<p>The candidate shall not borrow money from, accept gifts, rewards, or any form of personal compensation from, or place themselves under any pecuniary obligation to, any person, client, or entity with whom they have official dealings in the course of their engagement with the Company.</p>

<p><b>8. Termination</b></p>
<p><b>8.1 Termination by the Company:</b> The Company may terminate the engagement of the candidate, without assigning any reason, by providing not less than one (1) day's prior written notice, or payment in lieu thereof.</p>
<p><b>8.2 Termination by the Candidate:</b> The candidate may terminate their engagement without cause by providing not less than one (1) day's prior written notice, or pro-rated payment in lieu of notice, after adjusting for any pending leaves, if applicable.</p>
<p><b>8.3 Termination for Misconduct or Breach:</b> The Company reserves the right to terminate the engagement summarily without notice or payment, if there are reasonable grounds to believe that the candidate has engaged in misconduct, negligence, fundamental breach of contract, or caused loss or damage to the Company.</p>
<p><b>8.4 Return of Company Property:</b> Upon termination of the engagement, for any reason, the candidate shall return all Company property, documents, records, samples, literature, contracts, data, drawings, blueprints, letters, notes, and any confidential information, whether original or copies, in their possession or under their control.</p>
<p>8.5 The Company reserves the right to cancel the engagement at any time by providing one (1) day's prior notice.</p>
<p><b>8.6 Final Settlement:</b> The full and final settlement of any dues, including pro-rated retainer fees, shall be completed within 45 to 90 working days following the termination of engagement.</p>

<p><b>9. Confidential Information</b></p>
<p><b>9.1 Exclusivity of Engagement:</b> During the period of engagement, the candidate shall devote their time, attention, and skill to the Company's business to the best of their ability. The candidate shall not, directly or indirectly, engage, associate, or be connected with any other business, employment, post, or activity, whether part-time or full-time, nor pursue any course of study or professional activity, without the prior written consent of the Company.</p>
<p><b>9.2 Confidentiality Obligations:</b> The candidate shall at all times maintain the highest degree of confidentiality and shall keep confidential all records, documents, and other information relating to the business of the Company. "Confidential Information" includes, but is not limited to, information relating to the Company's business operations, customer lists, employment policies, personnel data, products, processes, concepts, projections, technology, manuals, drawings, designs, specifications, contracts, records, and any other information not generally available to the public.</p>
<p><b>9.3 Restrictions on Removal:</b> The candidate shall not remove any Confidential Information from the Company's premises without prior written permission.</p>
<p><b>9.4 Survival of Obligations:</b> The obligations under this clause shall survive the termination or expiration of the engagement, regardless of the reason for cessation.</p>
<p><b>9.5 Remedies for Breach:</b> Any breach of this clause may result in summary termination of engagement in accordance with Clause 8, in addition to any other legal or equitable remedies available to the Company.</p>

<p><b>10. Notices</b></p>
<p><b>10.1 Notices to the Company:</b> All notices or communications by the candidate to the Company shall be sent to the Company's registered office address, unless otherwise specified in writing.</p>
<p><b>10.2 Notices to the Candidate:</b> All notices or communications by the Company to the candidate shall be sent to the address provided by the candidate in the Company's official records, unless otherwise updated in writing.</p>
<p><b>10.3 Mode of Delivery:</b> Notices may be delivered by hand, registered post, courier, or electronic communication (info@eomshopping.com), and shall be deemed to have been received on the date of delivery if delivered by hand, or three (3) business days after dispatch if sent by post/courier, or on the date of sending if sent by email.</p>

<p><b>11. Applicability of Company Policy</b></p>
<p>The Company reserves the right to issue, revise, or amend policies from time to time concerning matters such as working hours, leave entitlements, benefits, transfers, and other operational or administrative matters. All such policies, amendments, or directives shall be binding on the candidate, and to the extent of any inconsistency, shall prevail over the terms of this Agreement.</p>

<p><b>12. Termination for Misconduct or Misrepresentation</b></p>
<p><b>12.1 Non-Performance and Misconduct:</b> If the candidate fails to perform the assigned work, fails to maintain attendance as required, or is found to be engaged in activities detrimental to the Company, the Company reserves the right to immediately terminate the engagement. In such cases, the candidate shall forfeit any entitlement to payment or fees for the period of engagement.</p>
<p><b>12.2 Misrepresentation:</b> The candidate warrants that all information provided to the Company during the onboarding process is complete and accurate. In the event any information is found to be false, misleading, or incorrect, the Company shall have the right to cancel the engagement immediately, and the candidate shall not be entitled to receive any payment or Amount.</p>

<p><b>13. Modification of Terms</b></p>
<p>The Company reserves the right to amend, modify, or update the terms and conditions of this engagement at any time, based on business requirements, market conditions, or operational needs. The candidate agrees to abide by and accept any such changes upon notification by the Company.</p>

<p><b>14. Governing Law and Jurisdiction</b></p>
<p>14.1 During the probationary period, your engagement with the Company shall be governed by the retainer terms of this Agreement, and the applicable remuneration, rights, and benefits shall be as expressly set out herein.</p>
<p>14.2 This engagement shall be governed by and construed in accordance with the laws of India. Any disputes, differences, or claims arising out of or in connection with this engagement shall be subject to the exclusive jurisdiction of the courts of Delhi.</p>
<p>14.3 The Company reserves the right to amend or modify the terms and conditions of this engagement at any time in accordance with business requirements or market conditions, and the candidate agrees to abide by such changes upon notification.</p>

</div>

<table style="width:100%; border-collapse:collapse; margin-top:10px;">
<tr>
    <td class="label">Accepted</td>
    <td style="font-weight:bold; color: {{ $kit->tnc_accepted ? 'green' : 'red' }};">
        {{ $kit->tnc_accepted ? '✔ Yes' : '✘ No' }}
    </td>
</tr>
@if($kit->tnc_accepted_at)
<tr>
    <td class="label">Accepted On</td>
    <td>{{ \Carbon\Carbon::parse($kit->tnc_accepted_at)->format('d M Y h:i A') }}</td>
</tr>
@endif
</table>

</body>
</html>