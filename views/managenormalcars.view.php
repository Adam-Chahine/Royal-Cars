<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Hidden Cars - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/managenormalcars.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-eye-slash"></i> Hidden Cars Management</h1>
            <a href="admin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Admin Panel
            </a>
        </div>

        <div class="cars-grid">
            <?php
            $result = $conn->query("SELECT * FROM hidden_cars");

            if ($result->num_rows === 0) {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-car"></i>';
                echo '<h3>No Hidden Cars Found</h3>';
                echo '<p>All your cars are currently available for rental.</p>';
                echo '</div>';
            } else {
                while ($car = $result->fetch_assoc()) {
                    echo '<div class="car-card">';
                    echo '<div class="car-image">';
                    echo '<img src="' . htmlspecialchars($car['image_url']) . '" alt="' . htmlspecialchars($car['name']) . '">';
                    echo '<div class="car-badge">HIDDEN</div>';
                    echo '</div>';

                    echo '<div class="car-details">';
                    echo '<h3>' . htmlspecialchars($car['name']) . '</h3>';

                    echo '<div class="car-info">';
                    echo '<span class="info-item"><i class="fas fa-tag"></i> ' . htmlspecialchars($car['category']) . '</span>';
                    echo '<span class="info-item"><i class="fas fa-money-bill-wave"></i> ' . htmlspecialchars($car['price_per_day']) . ' DH/day</span>';
                    echo '<span class="info-item"><i class="fas fa-gas-pump"></i> ' . htmlspecialchars($car['fuel_type']) . '</span>';
                    echo '<span class="info-item"><i class="fas fa-star"></i> ' . htmlspecialchars($car['badge']) . '</span>';
                    echo '</div>';

                    echo '<form method="POST" onsubmit="return confirm(\'Are you sure you want to make this car available again?\');">';
                    echo '<input type="hidden" name="name" value="' . htmlspecialchars($car['name']) . '">';
                    echo '<button type="submit" name="make_available" class="make-available-btn">';
                    echo '<i class="fas fa-eye"></i> Make Available';
                    echo '</button>';
                    echo '</form>';

                    echo '</div></div>';
                }
            }
            ?>
        </div>
    </div>

    <script src="js/managenormalcars.js"></script>
</body>

</html>