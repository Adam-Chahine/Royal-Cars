<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

include 'db.php';

$result = $conn->query("SELECT * FROM rented");

// Total number of rented cars
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM rented");
$totalRented = $totalQuery->fetch_assoc()['total'];

// Total revenue
$priceQuery = $conn->query("SELECT SUM(price) AS total_price FROM rented");
$totalPrice = $priceQuery->fetch_assoc()['total_price'];

// Most rented car
$bestCarQuery = $conn->query("
    SELECT car_name, COUNT(*) AS count 
    FROM rented 
    GROUP BY car_name 
    ORDER BY count DESC 
    LIMIT 1
");
$bestCar = $bestCarQuery->fetch_assoc();
include "views/viewres.view.php"
?>