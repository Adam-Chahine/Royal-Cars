<?php
$type = $_GET['type'] ?? 'unknown';

switch ($type) {
  case 'add':
    $message = "Car added successfully!";
    break;
  case 'delete':
    $message = "Car deleted successfully!";
    break;
  case 'modify':
    $message = "Car modified successfully!";
    break;
  case 'hide':
    $message = 'Car hidden successfully';
    break;
  default:
    $message = "ℹ Action completed.";
}
include "views/succes.view.php"
?>
