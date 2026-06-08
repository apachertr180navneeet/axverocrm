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
    top: 4mm;
    left: 6mm;
    width: 42mm;
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
        <?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
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

        
        <p class="para"><strong>Subject: Internship Appointment Letter</strong></p>

        
        <p class="letter-title">INTERNSHIP APPOINTMENT LETTER</p>

        
        <p class="para">Dear <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?>,</strong></p>

        
        <p class="para">
            We are pleased to offer you an internship position with <strong>KACTTO (EASY ONLINE MARKETING)</strong>
            for the role of <strong><?php echo e($offer->designation); ?></strong>.
        </p>

        <p class="para">
            Your internship will commence from <strong><?php echo e($joining_fmt); ?></strong> and will continue for a
            period of <strong>6 months</strong>, unless terminated earlier in accordance with company policies.
        </p>

        
        <p class="section-head">Terms &amp; Conditions:</p>

        <p class="section-head">1. Working Hours</p>
        <p class="para">
            Your working hours will be from <strong>10:00 AM to 6:00 PM</strong>, every week
            <strong>Monday to Saturday</strong> (Sunday holiday).
        </p>

        <p class="section-head">2. Stipend</p>
        <p class="para">
            You will receive a stipend of
            <strong>Rs. <?php echo e(number_format($offer->salary, 2)); ?>/-</strong>
            <strong>(Rupees <?php echo e($salary_words); ?> only)</strong>,
            payable monthly on the <strong>10th</strong> of every month, subject to performance
            and company policy.
        </p>

        <p class="section-head">3. Roles &amp; Responsibilities</p>
        <p class="para">
            You are expected to perform tasks assigned by your reporting manager and maintain
            daily work reports.
        </p>

        <p class="section-head">4. Confidentiality</p>
        <p class="para">
            You must maintain strict confidentiality of all company data, documents, and processes
            during and after the internship period.
        </p>

        <p class="section-head">5. Performance &amp; Conduct</p>
        <p class="para">
            Your performance will be reviewed periodically. Any misconduct, negligence, or failure
            to perform duties may lead to termination of the internship.
        </p>

        <p class="section-head">6. Leave Policy</p>
        <p class="para">
            Leaves must be approved in advance by your reporting manager.
        </p>

        <p class="section-head">7. Termination</p>
        <p class="para">
            Either party may terminate this internship by giving <strong>1 day</strong> prior notice.
        </p>

        <p class="section-head">8. Certificate</p>
        <p class="para">
            Upon successful completion of the internship, you will be provided with an
            <strong>Internship Completion Certificate</strong>.
        </p>

    </div>

</div>


<div class="page">

    <div class="header">
        <?php if($logo_b64): ?>  <img src="<?php echo e($logo_b64); ?>"   class="header-logo"> <?php endif; ?>
        <?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
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
                    <strong>For KACTTO (EASY ONLINE MARKETING)</strong><br>
                    <?php if($stamp_b64): ?>
                        <img src="<?php echo e($stamp_b64); ?>" class="stamp-img"><br>
                    <?php else: ?>
                        <br><br><br>
                    <?php endif; ?>
                    <strong>Naira</strong><br>
                    <strong>HR Manager, Kactto</strong><br>
                    <a href="mailto:hr@kactto.com" style="font-weight:normal; font-size:9pt;">hr@kactto.com</a>
                </td>
                <td class="right-cell"></td>
            </tr>
        </table>

        <br><br>

        
        <p class="section-head">Acceptance by Intern</p>
        <br>
        <p class="para">
            I, <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?></strong>, hereby accept the terms and
            conditions of this internship.
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
        <?php if($header_b64): ?>
            <img src="<?php echo e($header_b64); ?>" class="header-banner">
        <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
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
        <?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
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
        <?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
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
        <?php if($header_b64): ?><img src="<?php echo e($header_b64); ?>" class="header-banner"> <?php endif; ?>
        <span class="header-website">https://kactto.com</span>
    </div>

    <div class="content">

        <p class="para">You will be required to enter into a Confidentiality Agreement with the Company and provide accurate information to be filled in your joining form, sending along with your appointment letter.</p>

        <p class="para">All applicable terms and conditions are detailed in the joining kit. Submission of the duly filled joining kit along with the signed appointment letter shall be mandatory, and only upon receipt of both shall the appointment be deemed to have been accepted.</p>

        <p class="para">Please sign a duplicate copy of this letter and fill the joining form as a token of your acceptance and send the same email id <strong>hr@kactto.com</strong> (<strong>HR Manager</strong>) back to us. The letter and joining kit will be valid for 2 days only from the day it is issued.</p>

        <p class="para">We Welcome you and look forward for your arrival in EASY ONLINE MARKETING.</p>

        <br>
        <p class="para">Thanking You Sincerely</p>
        <br>

        <table class="sign-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <strong>For EASY ONLINE MARKETING</strong><br>
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
</html><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/offer-letter/letter-pdf.blade.php ENDPATH**/ ?>