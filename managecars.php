<?php
include 'db.php';

// Handle the "Make Available" action (delete reservation)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['make_available'])) {
    $reservationId = $_POST['reservation_id'];
    $conn->query("DELETE FROM confirmation WHERE id = $reservationId");
    header("Location: managecars.php"); // Refresh
    exit();
}
include "views/managecars.view.php"
?>