<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Action Completed | Royal Cars Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/succes.css">
</head>

<body>
  <div class="notification-container">
    <?php
    // Determine icon based on action type
    $iconClass = 'icon-default';
    switch ($type) {
      case 'add':
        $iconClass = 'icon-add';
        break;
      case 'delete':
        $iconClass = 'icon-delete';
        break;
      case 'modify':
        $iconClass = 'icon-modify';
        break;
      case 'hide':
        $iconClass = 'icon-hide';
        break;
    }
    ?>
    <div class="notification-icon">
      <i class="fas <?= $iconClass ?>"></i>
    </div>
    <h1><?= $message ?></h1>

    <div class="notification-detail">
      <?php if ($type === 'add'): ?>
        The new vehicle has been successfully added to our premium fleet.
      <?php elseif ($type === 'delete'): ?>
        The vehicle has been permanently removed from our system.
      <?php elseif ($type === 'modify'): ?>
        Vehicle specifications have been updated across all platforms.
      <?php elseif ($type === 'hide'): ?>
        The vehicle is now hidden from customer view but remains in the database.
      <?php else: ?>
        Your administrative action has been processed successfully.
      <?php endif; ?>
    </div>

    <button class="back-btn" onclick="window.location.href='admin.php'">
      <i class="fas fa-arrow-left"></i> Back to Admin Panel
    </button>
  </div>
</body>

</html>