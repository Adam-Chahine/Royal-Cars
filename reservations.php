<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

include 'db.php';

// Confirm reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_id'])) {
    $id = intval($_POST['confirm_id']);
    $res = $conn->query("SELECT * FROM reservations WHERE id = $id");

    if ($res && $res->num_rows === 1) {
        $data = $res->fetch_assoc();
        $carName = $conn->real_escape_string($data['car_name']);

        // Check if car is hidden
        $hiddenCheck = $conn->query("SELECT id FROM hidden_cars WHERE name = '$carName'");
        if ($hiddenCheck && $hiddenCheck->num_rows > 0) {
            $error = "This car is hidden and cannot be reserved.";
        }
        // Original confirmation check
        else {
            $check = $conn->query("SELECT * FROM confirmation WHERE car_name = '$carName'");
            if ($check && $check->num_rows > 0) {
                $error = "This car is already reserved.";
            } else {
                $price = $conn->real_escape_string($_POST['price']);


                $stmt = $conn->prepare("INSERT INTO confirmation (
                car_name, full_name, email, phone, address,
                pickup_date, return_date, pickup_location,
                return_location, special_requests, price
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param(
                    "sssssssssss",
                    $data['car_name'],
                    $data['full_name'],
                    $data['email'],
                    $data['phone'],
                    $data['address'],
                    $data['pickup_date'],
                    $data['return_date'],
                    $data['pickup_location'],
                    $data['return_location'],
                    $data['special_requests'],
                    $price
                );

                if ($stmt->execute()) {
                    // Also insert into rented
                    $stmt2 = $conn->prepare("INSERT INTO rented (
                    car_name, full_name, email, phone, address,
                    pickup_date, return_date, pickup_location,
                    return_location, special_requests, price
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $stmt2->bind_param(
                        "sssssssssss",
                        $data['car_name'],
                        $data['full_name'],
                        $data['email'],
                        $data['phone'],
                        $data['address'],
                        $data['pickup_date'],
                        $data['return_date'],
                        $data['pickup_location'],
                        $data['return_location'],
                        $data['special_requests'],
                        $price
                    );
                    $stmt2->execute();
                    $stmt2->close();

                    // Also insert into month
                    $stmt3 = $conn->prepare("INSERT INTO month (
                    car_name, full_name, email, phone, address,
                    pickup_date, return_date, pickup_location,
                    return_location, special_requests, price
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $stmt3->bind_param(
                        "sssssssssss",
                        $data['car_name'],
                        $data['full_name'],
                        $data['email'],
                        $data['phone'],
                        $data['address'],
                        $data['pickup_date'],
                        $data['return_date'],
                        $data['pickup_location'],
                        $data['return_location'],
                        $data['special_requests'],
                        $price
                    );
                    $stmt3->execute();
                    $stmt3->close();

                    // Delete from reservations
                    $conn->query("DELETE FROM reservations WHERE id = $id");

                    // Send confirmation email
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = ''; // Entrer l'email de l'expéditeur (sender)
                        $mail->Password = ''; // Entrer le mot de passe d'application de cet email
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('', 'Royal Cars'); // Entrer l'email de l'expéditeur (sender)
                        $mail->addAddress($data['email'], $data['full_name']);

                        $mail->isHTML(true);
                        $mail->Subject = 'Reservation Confirmed - Royal Cars';
                        $mail->Body = "Hello <b>{$data['full_name']}</b>,<br>Your car reservation for <b>{$data['car_name']}</b> has been <b>confirmed</b>.<br><br>Thank you for choosing Royal Cars!";
                        $mail->AltBody = "Hello {$data['full_name']},\n\nYour car reservation for {$data['car_name']} is confirmed.\n\nThanks for choosing Royal Cars!";

                        $mail->send();
                        $success = "Reservation confirmed and email sent.";
                    } catch (Exception $e) {
                        $success = "Reservation confirmed, but email could not be sent.";
                    }
                } else {
                    $error = "Failed to confirm reservation.";
                }
                $stmt->close();
            }
        }
    }
}

// Delete reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    if ($conn->query("DELETE FROM reservations WHERE id = $id")) {
        $success = "Reservation deleted.";
    } else {
        $error = "Failed to delete reservation.";
    }
}

$result = $conn->query("SELECT * FROM reservations ORDER BY reservation_time DESC");
include "views/reservations.view.php"
?>
