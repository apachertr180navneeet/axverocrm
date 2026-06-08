<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.7; }
    .container { max-width: 600px; margin: 0 auto; padding: 30px 20px; }
    .logo { margin-bottom: 24px; }
    .content { background: #f9f9f9; border-radius: 8px; padding: 28px 32px; }
    .btn { display: inline-block; margin: 20px 0; padding: 12px 28px; background: #4f46e5; color: #fff !important; border-radius: 6px; text-decoration: none; font-weight: bold; }
    .footer { margin-top: 28px; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 16px; }
</style>
</head>
<body>
<div class="container">

    <div class="content">
        <p>Dear <strong><?php echo e($prefix); ?> <?php echo e($offer->full_name); ?>,</strong></p>

        <p>We are pleased to inform you that you have been selected for the position of
        <strong><?php echo e($offer->designation); ?></strong> at <strong>Kactto</strong>.</p>

        <p>Please find attached your official offer and joining kit detailing the terms and
        conditions of your work. We request you to go through the letter carefully and confirm
        your acceptance by replying to this email or signing and sending back a scanned copy
        of the letter within <strong>48 hours</strong> from the date of issue. Else the letter
        will be declined by itself.</p>

        <p>Please find the login link below.</p>

        <a href="https://crmhr.kactto.com/login" class="btn">Login to Portal</a>

        <p>If you have any questions or need further clarification, feel free to contact us
        at our official email ID.</p>

        <p>We look forward to welcoming you to our team.</p>

        <p>
            Regards,<br>
            <strong>HR Department</strong><br>
            <a href="mailto:Hr@kactto.com">Hr@kactto.com</a>
        </p>
    </div>

    <div class="footer">
        This is an automated email from Kactto HR System. Please do not reply directly to this email.
    </div>

</div>
</body>
</html><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/offer-letter/mail.blade.php ENDPATH**/ ?>