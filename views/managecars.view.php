
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Reserved Cars - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/managecars.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-calendar-check"></i> Reserved Cars</h1>
            <a href="admin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Admin Panel
            </a>
        </div>

        <div class="reservations-grid">
            <?php
            $result = $conn->query("SELECT * FROM confirmation");

            if ($result->num_rows === 0) {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-car"></i>';
                echo '<h3>No Reserved Cars</h3>';
                echo '<p>All cars are currently available for new reservations.</p>';
                echo '</div>';
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="reservation-card">';
                    echo '<span class="reservation-id">ID: ' . htmlspecialchars($row['id']) . '</span>';
                    echo '<h3 class="car-name">' . htmlspecialchars($row['car_name']) . '</h3>';

                    echo '<div class="client-info">';
                    echo '<div class="info-item"><i class="fas fa-user"></i> ' . htmlspecialchars($row['full_name']) . '</div>';
                    echo '<div class="info-item"><i class="fas fa-envelope"></i> ' . htmlspecialchars($row['email']) . '</div>';
                    echo '<div class="info-item"><i class="fas fa-phone"></i> ' . htmlspecialchars($row['phone']) . '</div>';
                    echo '</div>';

                    echo '<form method="POST" onsubmit="return confirm(\'Are you sure you want to make this car available again?\');">';
                    echo '<input type="hidden" name="reservation_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<button type="submit" name="make_available" class="make-available-btn">';
                    echo '<i class="fas fa-check-circle"></i> Make Available';
                    echo '</button>';
                    echo '</form>';

                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    <script src="js/managecars.js"></script>
</body>

</html>