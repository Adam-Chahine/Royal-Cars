<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

include 'db.php';

// Truncate the month table
$conn->query("TRUNCATE TABLE month");

// Redirect back to the monthly rentals page
header("Location: month.php");
exit;
?>