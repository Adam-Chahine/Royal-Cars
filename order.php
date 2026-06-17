<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

try {
    include 'db.php';

    // Sanitize form inputs
    function sanitize($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $car_name         = sanitize($_POST['car-name'] ?? '');
    $full_name        = sanitize($_POST['full-name'] ?? '');
    $email            = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone            = sanitize($_POST['phone'] ?? '');
    $address          = sanitize($_POST['address'] ?? '');
    $pickup_date      = sanitize($_POST['pickup-date'] ?? '');
    $return_date      = sanitize($_POST['return-date'] ?? '');
    $pickup_location  = sanitize($_POST['pickup-location'] ?? '');
    $return_location  = sanitize($_POST['return-location'] ?? '');
    $special_requests = sanitize($_POST['special-requests'] ?? '');

    if (!$email) {
        throw new Exception("Invalid email");
    }

    /* =======================
       PHPMailer setup
    ======================= */
    
    $mail = new PHPMailer(true);

    // SMTP Config (GOOD for inbox)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = ''; // Entrer l'email de l'expéditeur (sender)
    $mail->Password   = ''; // Entrer le mot de passe d'application de cet email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // ========= EMAIL TO CLIENT =========
    $mail->setFrom('', 'Royal Cars');
    $mail->addReplyTo('', 'Royal Cars');
    $mail->addAddress($email, $full_name);
    $mail->isHTML(true);
    $mail->Subject = "Your Car Reservation - Royal Cars";

    $mail->Body = "
        <h3>Hello " . htmlentities($full_name) . ",</h3>
        <p>Thank you for choosing <strong>Royal Cars</strong>!</p>
        <ul>
            <li><strong>Car:</strong> " . htmlentities($car_name) . "</li>
            <li><strong>Pick-Up:</strong> $pickup_date at $pickup_location</li>
            <li><strong>Return:</strong> $return_date at $return_location</li>
        </ul>
        <p>Royal Cars Team</p>
    ";

    $mail->AltBody = "Hello $full_name, your reservation for $car_name is received.";

    $mail->send(); // 🔴 MUST succeed

    // ========= EMAIL TO OWNER =========
    $mail->clearAddresses();
    $mail->addAddress('', 'Royal Cars Admin'); // Entrer l'email de l'admin qui recevra la notification
    $mail->Subject = "New Car Reservation Received";
    $mail->Body = "New reservation from $full_name ($email) for $car_name.";
    $mail->send(); // 🔴 MUST succeed

    /* =======================
       INSERT ONLY AFTER EMAIL SUCCESS
    ======================= */
    $stmt = $conn->prepare("
        INSERT INTO reservations (
            car_name, full_name, email, phone, address,
            pickup_date, return_date, pickup_location, return_location, special_requests
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssssssss",
        $car_name, $full_name, $email, $phone, $address,
        $pickup_date, $return_date, $pickup_location, $return_location, $special_requests
    );

    $stmt->execute();
    $stmt->close();

    header("Location: success.html");
    exit();

} catch (Exception $e) {
    error_log($e->getMessage()); // log for you
    header("Location: error.html");
    exit();
}
?>
