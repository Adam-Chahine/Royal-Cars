<?php
include 'db.php';

// Handle "Make Available" (delete from hidden_cars)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['make_available'])) {
    $carName = $conn->real_escape_string($_POST['name']);
    $conn->query("DELETE FROM hidden_cars WHERE name = '$carName'");
    header("Location: managenormalcars.php"); // Refresh the page
    exit();
}
include "views/managenormalcars.view.php"
?>
