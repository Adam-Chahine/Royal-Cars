<?php
include 'db.php';

$success = "";
$error = "";

// Fetch car names from cars table
$cars = [];
$carQuery = "
    SELECT name FROM cars
    WHERE name NOT IN (SELECT name FROM hidden_cars)
    AND name NOT IN (SELECT car_name FROM confirmation)
";
$result = $conn->query($carQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row['name'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $conn->real_escape_string($_POST['car_name']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    $pickup_location = $conn->real_escape_string($_POST['pickup_location']);
    $return_location = $conn->real_escape_string($_POST['return_location']);
    $special_requests = $conn->real_escape_string($_POST['special_requests']);
    $price = $conn->real_escape_string($_POST['price']);

    $insertRented = "INSERT INTO rented (car_name, full_name, email, phone, address, pickup_date, return_date, pickup_location, return_location, special_requests, price, rented_at)
                     VALUES ('$car_name', '$full_name', '$email', '$phone', '$address', '$pickup_date', '$return_date', '$pickup_location', '$return_location', '$special_requests', '$price', NOW())";

    $insertMonth = "INSERT INTO month (car_name, full_name, email, phone, address, pickup_date, return_date, pickup_location, return_location, special_requests, price, rented_at)
                     VALUES ('$car_name', '$full_name', '$email', '$phone', '$address', '$pickup_date', '$return_date', '$pickup_location', '$return_location', '$special_requests', '$price', NOW())";

    $insertConfirmation = "INSERT INTO confirmation (car_name, full_name, email, phone, address, pickup_date, return_date, pickup_location, return_location, special_requests, price, reservation_time)
                     VALUES ('$car_name', '$full_name', '$email', '$phone', '$address', '$pickup_date', '$return_date', '$pickup_location', '$return_location', '$special_requests', '$price', NOW())";

    if ($conn->query($insertRented) === TRUE && $conn->query($insertConfirmation) === TRUE && $conn->query($insertMonth) === TRUE) {
        $success = "✅ Offline reservation inserted successfully!";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
include "views/offline_rental.view.php"
?>
