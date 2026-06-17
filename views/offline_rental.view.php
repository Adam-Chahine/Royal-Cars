<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Offline Reservation - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/offline_rental.css">
</head>

<body>
    <div class="admin-container">
        <div class="form-header">
            <h2><i class="fas fa-calendar-plus"></i> Add Offline Reservation</h2>
            <p>For walk-in customers or phone reservations</p>
            <a href="admin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Admin Panel
            </a>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= $success ?>
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-card">
            <div class="form-group">
                <label for="car_name"><i class="fas fa-car"></i> Car Selection</label>
                <select name="car_name" class="form-control" required>
                    <option value="">-- Select a Car --</option>
                    <?php foreach ($cars as $car): ?>
                        <option value="<?= htmlspecialchars($car) ?>"><?= htmlspecialchars($car) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label for="pickup_date"><i class="fas fa-calendar-day"></i> Pickup Date</label>
                    <input type="date" id="pickup_date" name="pickup_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="return_date"><i class="fas fa-calendar-day"></i> Return Date</label>
                    <input type="date" id="return_date" name="return_date" class="form-control" required>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label for="pickup_location"><i class="fas fa-map-pin"></i> Pickup Location</label>
                    <input type="text" name="pickup_location" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="return_location"><i class="fas fa-map-pin"></i> Return Location</label>
                    <input type="text" name="return_location" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="special_requests"><i class="fas fa-comment-dots"></i> Special Requests</label>
                <textarea name="special_requests" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="price"><i class="fas fa-money-bill-wave"></i> Price (DH)</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-plus-circle"></i> Create Offline Reservation
            </button>
        </form>
    </div>

    <script src="js/offline_rental.js"></script>

</body>

</html>