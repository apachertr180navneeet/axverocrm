<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 10pt;
    color: #111;
    line-height: 1.6;
}

/* ── Page layout ─────────────────────────────────── */
.page {
    width: 100%;
    position: relative;
    page-break-after: always;
}

.page:last-child {
    page-break-after: auto;
}

/* ── Header ──────────────────────────────────────── */
.header {
    width: 100%;
    position: relative;
    height: 28mm;
    margin-bottom: 6mm;
}

.header-logo {
    position: absolute;
    top: 2mm;
    left: 3;
    width: 32mm;
}

.header-banner {
    position: absolute;
    top: 0;
    right: 0;
    width: 55%;
    height: 28mm;
}

.header-website {
    position: absolute;
    top: 4mm;
    right: 6mm;
    font-size: 7.5pt;
    color: #fff;
    z-index: 10;
}

/* ── Content area ────────────────────────────────── */
.content {
    padding: 0 16mm 6mm 16mm;
}

/* ── Ref + Date row ──────────────────────────────── */
.ref-row {
    width: 100%;
    margin-bottom: 6mm;
}

.ref-row td {
    font-size: 9pt;
    font-weight: bold;
    color: #111;
    vertical-align: middle;
}

.ref-row .date-cell {
    text-align: right;
}

/* ── Candidate name ──────────────────────────────── */
.candidate-name {
    font-size: 10pt;
    font-weight: bold;
    margin-bottom: 5mm;
}

/* ── Title ───────────────────────────────────────── */
.letter-title {
    text-align: center;
    font-size: 13pt;
    font-weight: bold;
    text-decoration: underline;
    margin-bottom: 5mm;
}

/* ── Body paragraphs ─────────────────────────────── */
.para {
    text-align: justify;
    margin-bottom: 4mm;
    font-size: 10pt;
}

/* ── Section heading ─────────────────────────────── */
.section-head {
    font-weight: bold;
    font-size: 10pt;
    margin-bottom: 2mm;
    margin-top: 3mm;
}

/* ── Numbered list ───────────────────────────────── */
.num-list {
    margin-left: 4mm;
    margin-bottom: 3mm;
}

.num-list li {
    text-align: justify;
    font-size: 10pt;
    margin-bottom: 2mm;
    list-style-type: decimal;
}

/* ── Signature section ───────────────────────────── */
.sign-table {
    width: 100%;
    margin-top: 5mm;
}

.sign-table td {
    width: 50%;
    vertical-align: top;
    font-size: 9pt;
    font-weight: bold;
    padding-top: 2mm;
}

.sign-table .right-cell {
    text-align: right;
}

.stamp-img {
    width: 28mm;
    margin: 2mm 0;
}

/* ── Footer — fixed to bottom of each page ───────── */
.footer {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
}

.footer img {
    width: 100%;
    height: auto;
    display: block;
}

</style>
</head>
<body>


<?php if($footer_b64): ?>
<div class="footer">
    <img src="<?php echo e($footer_b64); ?>">
</div>
<?php endif; ?>






<?php if($offer->employment_type === 'Internship'): ?>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://exvero.in</span>-->
    </div>

    <div class="content">

        
        <table class="ref-row" cellpadding="0" cellspacing="0">
            <tr>
                <td><?php echo e($offer->ref_no); ?></td>
                <td class="date-cell"><?php echo e($today); ?></td>
            </tr>
        </table>

        
        <p class="para">To,<br>
        <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></strong></p>

        
        <p class="para"><strong>Subject: Appointment as Retainer</strong></p>

        
        <p class="letter-title">RETAINER APPOINTMENT LETTER</p>

        
        <p class="para">Dear <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?>,</strong></p>

        
        <p class="para">
            We are pleased to appoint you as a <strong>Retainer</strong> with EASY ONLINE MARKETING <strong>AXVERO</strong>, subject to the terms and conditions mentioned below:
        </p>

            <!--<p class="para">-->
            <!--    Your internship will commence from <strong><?php echo e($joining_fmt); ?></strong> and will continue for a-->
            <!--    period of <strong>6 months</strong>, unless terminated earlier in accordance with company policies.-->
            <!--</p>-->

        
        <p class="section-head">Terms &amp; Conditions:</p>

        <p class="section-head">1. Nature of Engagement</p>
        <p class="para">
            You will be engaged as a <strong>Retainer</strong> on a part-time basis. This engagement does not constitute full-time employment and shall be governed by the terms of this letter.
        </p>

        <p class="section-head">2. Joining Date</p>
        <p class="para">
            Your engagement shall commence from Date  <strong><?php echo e($joining_fmt); ?></strong>. ( Date of Joining) 
        </p>

        <p class="section-head">3. Working Hours & Attendance</p>
        <p class="para">
            * You are required to mark your <strong>Clock-In attendance between 09:00 AM and 10:00 AM</strong> daily.
            * You are required to mark your <strong>Clock-Out attendance between 06:00 PM and 06:30 PM</strong> daily.
            * Attendance shall be marked through the system/platform prescribed by the company.
        </p>

        <p class="section-head">4. Roles & Responsibilities</p>
        <p class="para">
            1. Marketing and promotion of the company's products and services.
            2. Daily execution of marketing activities assigned by the company.
            3. Recruitment and onboarding support for sales agents.
            4. Ensuring the hiring of <strong>minimum 10 agents</strong> for the company as per business requirements.
            5. Submission of daily work reports and updates to the reporting manager.
            6. Any other related tasks assigned by the management from time to time.
        </p>

    </div>

</div>

<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://exvero.in</span>-->
    </div>

    <div class="content">

        <p class="section-head">5. Retainer Fee</p>
        <p class="para">
            You shall be paid a monthly retainer fee of <strong>₹12000/-  (Rupees Twelve Thousand only)</strong>, subject to applicable deductions and compliance with company policies.
        </p>

        <p class="section-head">6. Confidentiality</p>
        <p class="para">
            You shall maintain strict confidentiality regarding all company information, business data, customer details, and internal processes during and after the tenure of your engagement.
        </p>

        <p class="section-head">7. Code of Conduct</p>
        <p class="para">
            You are expected to maintain professional behavior and comply with all company policies, rules, and regulations.
        </p>

        <p class="section-head">8. Termination</p>
        <p class="para">
            Either party may terminate this engagement by providing 1 days' written notice or payment in lieu thereof, unless otherwise decided by the company.
        </p>
        
        <p class="section-head">9. Acceptance</p>
        <p class="para">
            Please sign and return a copy of this letter as a token of your acceptance of the above terms and conditions.
            We welcome you and look forward to a successful association with AXVERO.
        </p>

    </div>

</div>

<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://kactto.com</span>-->
    </div>

    <div class="content">

        <p class="para">
            We look forward to your contribution and hope this internship will be a valuable
            learning experience for you.
        </p>

        <p class="para">
            Kindly sign and return a copy of this letter as a token of your acceptance.
        </p>

        <br>
        <p class="para">Best Regards,</p>
        <br>

        
        <table class="sign-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <strong>For AXVERO</strong><br>
                    <?php if($stamp_b64): ?>
                        <img src="<?php echo e($stamp_b64); ?>" class="stamp-img"><br>
                    <?php else: ?>
                        <br><br><br>
                    <?php endif; ?>
                    <strong>Naira</strong><br>
                    <strong>HR Manager, Axvero</strong><br>
                    <a href="mailto:hr@axvero.in" style="font-weight:normal; font-size:9pt;">hr@axvero.in</a>
                </td>
                <td class="right-cell"></td>
            </tr>
        </table>

        <br><br>

        
        <p class="section-head">Acceptance by Retainer</p>
        <br>
        <p class="para">
            I, <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></strong>, have read and understood the terms and conditions mentioned above and hereby accept the appointment as Retainer with AXVERO.
        </p>
        <br>
        <table class="sign-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    Signature: ___________________________
                    <br><br>
                    Date: ________________________________
                </td>
                <td class="right-cell"></td>
            </tr>
        </table>

    </div>

</div>






<?php else: ?>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>
            <img src="<?php echo e($logo_b64); ?>" class="header-logo">
        <?php endif; ?>
        <!--<?php if($header_b64): ?>-->
        <!--    <img src="<?php echo e($header_b64); ?>" class="header-banner">-->
        <!--<?php endif; ?>-->
        <!--<span class="header-website">https://kactto.com</span>-->
    </div>

    <div class="content">

        <table class="ref-row" cellpadding="0" cellspacing="0">
            <tr>
                <td><?php echo e($offer->ref_no); ?></td>
                <td class="date-cell"><?php echo e($today); ?></td>
            </tr>
        </table>

        <p class="candidate-name"><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></p>

        <p class="letter-title">APPOINTMENT LETTER</p>

        <p class="para">Dear <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></strong></p>

        <p class="para">
            This is with reference to your application and the subsequent discussions you had with us. We are
            pleased to appointment you the position of <strong><?php echo e($offer->designation); ?></strong> effective
            <strong><?php echo e($joining_fmt); ?>,</strong> on the terms and conditions mutually agreed upon during the
            interview process.
        </p>

        <p class="para">
            As discussed, your Monthly Fixed Amount would be Rupees
            <strong><?php echo e(number_format($offer->salary, 2)); ?>/-</strong>
            <strong>(Rupees <?php echo e($salary_words); ?> only).</strong>
        </p>

        <p class="section-head">Payment Terms</p>
        <ol class="num-list">
            <li>The above-mentioned compensation is a fixed and consolidated amount, payable on a monthly basis.</li>
            <li>The stated amount represents the final payable sum, and no deductions of any nature shall be made from the said amount.</li>
            <li>Payment of compensation shall remain subject to compliance with the terms and conditions of the appointment and applicable attendance requirements.</li>
        </ol>

        <p class="para">
            The department concerned shall be known as and all individuals joining this department shall be bound
            by the applicable retainer terms and conditions. You shall be on a probationary period of six (6)
            months, upon completion of which, subject to your performance being found satisfactory, you may, at
            the sole discretion of the Company, be confirmed as an employee or a permanent employee.
        </p>

    </div>

</div>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://kactto.com</span>-->
    </div>

    <div class="content">

        <p class="section-head">4. Place of Posting</p>
        <p class="para">You shall be liable to be posted and work at any location across India, based on the business requirements of the Company. You may also be required to work at any existing or future place of business, branch office, project site, client location, or establishment that the Company currently operates or may subsequently acquire.</p>
        <p class="para">In addition, the Company may, at its sole discretion and depending upon business needs, permit you to work remotely or in a hybrid mode. Such remote working arrangement shall not be deemed permanent and may be modified, withdrawn, or revised by the Company at any time.</p>

        <p class="section-head">5. Hours of Work &amp; Salary</p>
        <p class="para">The normal working days are Monday through Saturday. You will be required to work for such hours as necessary for the proper discharge of your duties to the Company. The normal working hours are from 9.00 AM to 6:00 PM and you are expected to work not less than 8 hours each day, and if necessary for additional hours depending on your responsibilities. Salary from the company will be available monthly basis. income will be credited to your bank account on the 10th of every month. To earn income, a person must have minimum 15 attendances in a month. If you do not attend in any month, then the income will be credited along with the next income.</p>

        <p class="section-head">6. Leave and Holidays</p>
        <p class="para">6.1 You shall not be entitled to any casual leave.</p>
        <p class="para">6.2 You shall not be entitled to any paid sick leave. Any absence due to illness shall be treated as unpaid leave.</p>
        <p class="para">6.3 The Company shall communicate declared holidays, if any, in advance.</p>

        <p class="section-head">7. Company Property</p>
        <p class="para">All property, equipment, documents, materials, or confidential information provided to you shall remain the property of the Company and must be returned upon cessation of engagement or upon request. Failure to return such property may result in recovery of costs.</p>

    </div>

</div>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://kactto.com</span>-->
    </div>

    <div class="content">

        <p class="section-head">8. Borrowing and Gifts</p>
        <p class="para">You shall not borrow money from, accept gifts, rewards, or any personal compensation from any client, vendor, or person having official dealings with the Company.</p>

        <p class="section-head">9. Termination</p>
        <p class="para">9.1 The Company may terminate your engagement by providing one (1) day prior written notice or payment in lieu thereof.</p>
        <p class="para">9.2 You may terminate your engagement by providing one (1) day prior written notice or payment in lieu thereof, after adjusting pending leaves.</p>
        <p class="para">9.3 The Company may terminate your engagement without notice in case of misconduct, negligence, breach of contract, or loss/damage caused to the Company.</p>
        <p class="para">9.4 Final settlement shall be processed within 45 to 90 working days from the date of termination.</p>

        <p class="section-head">10. Confidentiality and Exclusivity</p>
        <p class="para">10.1 During your engagement, you shall devote your full time and attention to the Company's business and shall not engage in any other employment, business, or professional activity without prior written consent.</p>
        <p class="para">10.2 You shall maintain strict confidentiality of all Company information during and after your engagement.</p>
        <p class="para">10.3 Confidential information shall not be removed or disclosed without written authorization.</p>
        <p class="para">10.4 These obligations shall survive termination of engagement.</p>

        <p class="section-head">11. Company Policies</p>
        <p class="para">The Company reserves the right to amend, modify, or update policies and terms of engagement from time to time, and such changes shall be binding upon you.</p>

    </div>

</div>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <!--<?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>-->
        <!--<span class="header-website">https://kactto.com</span>-->
    </div>

    <div class="content">

        <p class="para">You will be required to enter into a Confidentiality Agreement with the Company and provide accurate information to be filled in your joining form, sending along with your appointment letter.</p>

        <p class="para">All applicable terms and conditions are detailed in the joining kit. Submission of the duly filled joining kit along with the signed appointment letter shall be mandatory, and only upon receipt of both shall the appointment be deemed to have been accepted.</p>

        <p class="para">Please sign a duplicate copy of this letter and fill the joining form as a token of your acceptance and send the same email id <strong>hr@axvero.in</strong> (<strong>HR Manager</strong>) back to us. The letter and joining kit will be valid for 2 days only from the day it is issued.</p>

        <p class="para">We Welcome you and look forward for your arrival in AXVERO.</p>

        <br>
        <p class="para">Thanking You Sincerely</p>
        <br>

        <table class="sign-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <strong>For AXVERO</strong><br>
                    <?php if($stamp_b64): ?>
                        <img src="<?php echo e($stamp_b64); ?>" class="stamp-img"><br>
                    <?php else: ?>
                        <br><br><br>
                    <?php endif; ?>
                    <strong>Authorized Signatory</strong>
                </td>
                <td class="right-cell">
                    I accept the terms and conditions
                    <br><br><br><br>
                    <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></strong><br>
                    <strong>Signature of Applicant</strong>
                </td>
            </tr>
        </table>

    </div>

</div>

<?php endif; ?>

</body>
</html><?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/offer-letter/letter-pdf.blade.php ENDPATH**/ ?>