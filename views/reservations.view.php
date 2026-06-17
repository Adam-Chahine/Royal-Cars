
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation Management - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/reservations.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-calendar-alt"></i> Pending Reservations</h1>
            <a href="admin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Admin Panel
            </a>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Client</th>
                        <th>Contact</th>
                        <th>Dates</th>
                        <th>Locations</th>
                        <th>Requests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><strong><?= htmlspecialchars($row['car_name']) ?></strong></td>
                            <td>
                                <?= htmlspecialchars($row['full_name']) ?><br>
                                <?= htmlspecialchars($row['address']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['email']) ?><br>
                                <?= htmlspecialchars($row['phone']) ?>
                            </td>
                            <td>
                                <strong>Pickup:</strong> <?= $row['pickup_date'] ?><br>
                                <strong>Return:</strong> <?= $row['return_date'] ?>
                            </td>
                            <td>
                                <strong>From:</strong> <?= htmlspecialchars($row['pickup_location']) ?><br>
                                <strong>To:</strong> <?= htmlspecialchars($row['return_location']) ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($row['special_requests'])) ?></td>
                            <td>
                                <?php
                                $car = $conn->real_escape_string($row['car_name']);

                                // Check hidden status first
                                $isHidden = $conn->query("SELECT id FROM hidden_cars WHERE name = '$car'");
                                $alreadyConfirmed = $conn->query("SELECT id FROM confirmation WHERE car_name = '$car'");
                                ?>

                                <?php if ($isHidden && $isHidden->num_rows > 0): ?>
                                    <span class="hidden-badge">
                                        <i class="fas fa-eye-slash"></i> Hidden
                                    </span>

                                <?php elseif ($alreadyConfirmed && $alreadyConfirmed->num_rows > 0): ?>
                                    <span class="reserved-badge">
                                        <i class="fas fa-lock"></i> Reserved
                                    </span>

                                <?php else: ?>
                                    <form class="action-form" method="POST" onsubmit="return confirm('Confirm this reservation?');">
                                        <input type="hidden" name="confirm_id" value="<?= $row['id'] ?>">
                                        <input type="text" class="form-input" name="price" placeholder="Price (DH)" required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <!-- Delete button remains unchanged -->
                                <form class="action-form" method="POST" onsubmit="return confirm('Are you sure to delete this reservation?');">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>No Pending Reservations</h3>
                <p>There are currently no reservations awaiting approval.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/reservations.js"></script>
</body>

</html>

<?php $conn->close(); ?>