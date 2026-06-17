<?php
// Start session
session_start();

// Save or get selected action
$action = $_POST['action'] ?? ($_SESSION['action'] ?? null);

// Check if admin is logged in
$show_form = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Database connection
  include 'db.php';

  // Check credentials
  $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $stmt->store_result();
  if ($stmt->num_rows === 1) {
    $stmt->bind_result($stored_password);
    $stmt->fetch();

    if ($password === $stored_password) {
      $_SESSION['logged_in'] = true;
      $show_form = true;
    } else {
      $error = "Incorrect username or password.";
    }
  } else {
    $error = "Incorrect username or password.";
  }

  $stmt->close();
  $conn->close();
}

// Save the selected action
if (isset($_POST['action'])) {
  $_SESSION['action'] = $_POST['action'];
  $action = $_POST['action'];
}

// Handle logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: admin.php");
  exit;
}
include "views/admin.view.php"
?>