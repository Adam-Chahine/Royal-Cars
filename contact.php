<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: MSGERR.html");
    exit();
}

/* ==========================
   1. INPUT VALIDATION
========================== */

$fullName = trim($_POST['full-name'] ?? '');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone    = trim($_POST['phone'] ?? '');
$subject  = trim($_POST['subject'] ?? 'No Subject');
$message  = trim($_POST['message'] ?? '');

if ($fullName === '' || !$email || $message === '') {
    header("Location: MSGERR.html");
    exit();
}

/* Escape ONLY when outputting HTML */
$safeName    = htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8');
$safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

/* ==========================
   2. MAIL CONFIG (ONE SOURCE)
========================== */

$senderEmail   = 'adamchahine37@gmail.com';
$receiverEmail = 'chadam787@gmail.com';
$appPassword   = 'ksjfrlsnegaalvcp';

$mail = new PHPMailer(true);

try {
    /* ==========================
       3. SMTP CONFIG
    ========================== */

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $senderEmail;
    $mail->Password   = $appPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    /* Identity headers */
    $mail->setFrom($senderEmail, 'Royal Cars');
    $mail->addReplyTo($email, $safeName);
    $mail->addCustomHeader('X-Mailer', 'RoyalCarsMailer');
    $mail->addCustomHeader('X-Priority', '3');

    /* ==========================
       4. OWNER EMAIL (CRITICAL)
    ========================== */

    $mail->addAddress($receiverEmail, 'Royal Cars Admin');
    $mail->isHTML(true);
    $mail->Subject = "New Contact Message: {$subject}";

    $mail->Body = "
        <h2>New Contact Message</h2>
        <p><strong>Name:</strong> {$safeName}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong><br>{$safeMessage}</p>
    ";

    $mail->AltBody =
        "New Contact Message\n\n" .
        "Name: {$fullName}\n" .
        "Email: {$email}\n" .
        "Phone: {$phone}\n" .
        "Subject: {$subject}\n\n" .
        "Message:\n{$message}";

    $mail->send(); // 🔴 MUST succeed

    /* ==========================
       5. CLIENT EMAIL
    ========================== */

    $mail->clearAddresses();
    $mail->clearReplyTos();

    $mail->addAddress($email, $safeName);
    $mail->addReplyTo($senderEmail, 'Royal Cars');

    $mail->Subject = 'Thank you for contacting Royal Cars';

    $mail->Body = "
        <h3>Hello {$safeName},</h3>
        <p>Thank you for contacting <strong>Royal Cars</strong>.</p>
        <p>We received your message regarding: <strong>{$subject}</strong>.</p>
        <p><strong>Your message:</strong><br>{$safeMessage}</p>
        <br>
        <p>— Royal Cars Team</p>
    ";

    $mail->AltBody =
        "Hello {$fullName},\n\n" .
        "Thank you for contacting Royal Cars.\n\n" .
        "Your message:\n{$message}\n\n" .
        "- Royal Cars Team";

    $mail->send(); // 🔴 MUST succeed

    /* ==========================
       6. SUCCESS
    ========================== */

    header("Location: MSGST.html");
    exit();

} catch (Exception $e) {

    /* ==========================
       7. FAILURE LOGGING
    ========================== */

    error_log("MAIL ERROR: " . $e->getMessage());

    header("Location: MSGERR.html");
    exit();
}
