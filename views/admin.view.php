
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Royal Cars</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>
  <div class="admin-container">
    <?php if ($show_form): ?>
      <div class="admin-header">
        <h1>Royal Cars Admin</h1>
        <a href="admin.php?logout=true" class="logout-link">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>

      <div class="admin-sections">
        <div class="admin-sidebar">
          <h3>Car Management</h3>
          <form method="POST" class="action-buttons">
            <button type="submit" name="action" value="add" class="btn">
              <i class="fas fa-plus"></i> Add Car
            </button>
            <button type="submit" name="action" value="modify" class="btn">
              <i class="fas fa-edit"></i> Modify Car
            </button>
            <button type="submit" name="action" value="delete" class="btn">
              <i class="fas fa-trash"></i> Delete Car
            </button>
            <button type="submit" name="action" value="hide" class="btn">
              <i class="fas fa-eye-slash"></i> Hide Car
            </button>
          </form>

          <h3>Reservations</h3>
          <div class="action-buttons">
            <a href="offline_rental.php" class="btn btn-secondary">
              <i class="fas fa-calendar-plus"></i> Add Reservation
            </a>
            <a href="reservations.php" class="btn btn-secondary">
              <i class="fas fa-tasks"></i> Manage Reservations
            </a>
            <a href="viewres.php" class="btn btn-secondary">
              <i class="fas fa-eye fa-lg"></i> View Reservations
            </a>
          </div>

          <h3>Car Status</h3>
          <div class="action-buttons">
            <a href="managecars.php" class="btn btn-secondary">
              <i class="fas fa-car"></i> Reserved Cars
            </a>
            <a href="managenormalcars.php" class="btn btn-secondary">
              <i class="fas fa-car-side"></i> Available Cars
            </a>
          </div>
        </div>

        <div class="admin-content">
          <?php if ($action === 'add'): ?>
            <div class="form-section">
              <h3>Add New Car</h3>
              <form action="add_car.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="Car Name" required>
                </div>

                <div class="form-group">
                  <label for="category">Category:</label>
                  <select name="category" class="form-control" required>
                    <option value="sport">Sport</option>
                    <option value="coupe">Coupe</option>
                    <option value="luxury">Luxury</option>
                    <option value="suvs">SUVs</option>
                    <option value="hatchbacks">HatchBacks</option>
                    <option value="muscles">Muscles</option>
                    <option value="vans">Van</option>
                  </select>
                </div>

                <div class="form-group">
                  <input type="number" step="0.01" name="price_per_day" class="form-control" placeholder="Price per Day" required>
                </div>

                <div class="form-group">
                  <input type="file" name="image_file" class="form-control" placeholder="Image Path" accept="image/*" optional>
                </div>

                <div class="form-group">
                  <input type="text" name="badge" class="form-control" placeholder="Badge (POPULAR, ECO...)" required>
                </div>

                <div class="form-group">
                  <input type="text" name="acceleration" class="form-control" placeholder="Acceleration (e.g. 3.5s 0-60)" required>
                </div>

                <div class="form-group">
                  <input type="number" name="seats" class="form-control" placeholder="Number of Seats" required>
                </div>

                <div class="form-group">
                  <input type="text" name="fuel_type" class="form-control" placeholder="Fuel Type" required>
                </div>

                <button type="submit" class="btn">
                  <i class="fas fa-save"></i> Add Car
                </button>
              </form>
            </div>

          <?php elseif ($action === 'modify'): ?>
            <div class="form-section">
              <h3>Modify Car</h3>
              <form action="modify_car.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" name="name_car" class="form-control" placeholder="Car name to modify" required>
                </div>

                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="New Car Name">
                </div>

                <div class="form-group">
                  <input type="number" step="0.01" name="price_per_day" class="form-control" placeholder="New Price per Day">
                </div>

                <div class="form-group">
                  <input type="file" name="image_file" class="form-control" placeholder="Image Path" accept="image/*">
                </div>

                <div class="form-group">
                  <input type="text" name="badge" class="form-control" placeholder="New Badge">
                </div>

                <div class="form-group">
                  <input type="text" name="acceleration" class="form-control" placeholder="New Acceleration">
                </div>

                <div class="form-group">
                  <input type="number" name="seats" class="form-control" placeholder="New Number of Seats">
                </div>

                <div class="form-group">
                  <input type="text" name="fuel_type" class="form-control" placeholder="New Fuel Type">
                </div>

                <button type="submit" class="btn">
                  <i class="fas fa-save"></i> Modify Car
                </button>
              </form>
            </div>

          <?php elseif ($action === 'delete'): ?>
            <div class="form-section">
              <h3>Delete Car</h3>
              <form action="delete_car.php" method="POST">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="Car name to delete" required>
                </div>

                <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this car?');">
                  <i class="fas fa-trash"></i> Delete Car
                </button>
              </form>
            </div>

          <?php elseif ($action === 'hide'): ?>
            <div class="form-section">
              <h3>Hide Car</h3>
              <form action="hide_cars.php" method="POST">
                <div class="form-group">
                  <input type="text" name="car_to_hide" class="form-control" placeholder="Enter Car Name to Hide" required>
                </div>
                <div class="form-group">
                  <input type="text" name="problem" class="form-control" placeholder="Enter Problem" required>
                </div>

                <button type="submit" name="hide_car_btn" class="btn">
                  <i class="fas fa-eye-slash"></i> Hide Car
                </button>
              </form>
            </div>

          <?php elseif ($action === 'manage'): ?>
            <?php include 'manage.php'; ?>

          <?php else: ?>
            <div class="welcome-message">
              <h2>Welcome to Royal Cars Admin Panel</h2>
              <p>Select an action from the sidebar to manage cars and reservations.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

    <?php else: ?>
      <div class="login-form" style="max-width: 400px; margin: 0 auto;">
        <h1 style="text-align: center; color: var(--primary);">Admin Login</h1>
        <form action="admin.php" method="POST">
          <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
          </div>

          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <button type="submit" class="btn" style="width: 100%;">
            <i class="fas fa-sign-in-alt"></i> Login
          </button>

          <?php if (isset($error)): ?>
            <div class="error-message">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>