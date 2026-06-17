<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Cars - Luxury Fleet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/cars.css">
</head>

<body>
    <!-- Header -->
    <header id="header">
        <nav>
            <a href="#" class="logo">Royal<span>Cars</span></a>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="Cars.php">Vehicles</a></li>
                <li><a href="contactus.html">Contact</a></li>
                <li><a href="policy.html">Policy</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="cars-hero">
        <div class="hero-content">
            <h1>PREMIUM FLEET COLLECTION</h1>
        </div>
    </section>
    <div class="filter-nav">
        <div class="filter-container">
            <button class="filter-btn active" data-filter="all">All Cars</button>
            <button class="filter-btn" data-filter="sport">Sport</button>
            <button class="filter-btn" data-filter="coupe">Coupe</button>
            <button class="filter-btn" data-filter="luxury">Luxury</button>
            <button class="filter-btn" data-filter="suvs">SUVs</button>
            <button class="filter-btn" data-filter="hatchbacks">HatchBacks</button>
            <button class="filter-btn" data-filter="vans">Vans</button>
            <button class="filter-btn" data-filter="muscles">Muscles</button>
        </div>
    </div>
    <!-- Cars Grid -->
    <div class="cars-container">
        <div class="cars-grid">

            <?php
            include 'db.php';

            // Step 1: Get all confirmed cars from the 'confirmation' table
            $confirmedCars = [];
            $confirmResult = $conn->query("SELECT car_name FROM confirmation");
            if ($confirmResult && $confirmResult->num_rows > 0) {
                while ($row = $confirmResult->fetch_assoc()) {
                    $confirmedCars[$row['car_name']] = "Rented";
                }
            }

            // Step 2: Get all hidden cars and their problem from 'hidden_cars' table
            $hiddenCars = [];
            $hiddenResult = $conn->query("SELECT name, problem FROM hidden_cars");
            if ($hiddenResult && $hiddenResult->num_rows > 0) {
                while ($row = $hiddenResult->fetch_assoc()) {
                    $hiddenCars[$row['name']] = $row['problem'];
                }
            }

            // Step 3: Get all cars from the 'cars' table
            $sql = "SELECT * FROM cars";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($car = $result->fetch_assoc()) {
                    $carName = $car['name'];

                    // Determine if the car is unavailable
                    $isConfirmed = array_key_exists($carName, $confirmedCars);
                    $isHidden = array_key_exists($carName, $hiddenCars);

                    // Determine the reason to show
                    $statusText = "";
                    if ($isConfirmed) {
                        $statusText = $confirmedCars[$carName]; // "Rented"
                    } elseif ($isHidden) {
                        $statusText = $hiddenCars[$carName]; // Like "Cleaning", "🛠 Maintenance", etc.
                    }

                    echo '
        <div class="car-card" data-category="' . htmlspecialchars($car['category']) . '">
            <div class="car-image">
                <img src="' . htmlspecialchars($car['image_url']) . '" alt="' . htmlspecialchars($carName) . '">
                <div class="car-badge">' . htmlspecialchars($car['badge']) . '</div>
            </div>
            <div class="car-details">
                <div class="car-header">
                    <h3>' . htmlspecialchars($carName) . '</h3>
                    <div class="car-price">' . htmlspecialchars($car['price_per_day']) . '<span>MAD/day</span></div>
                </div>
                <div class="car-specs">
                    <div class="spec-item"><i class="fas fa-car"></i> ' . ucfirst(htmlspecialchars($car['category'])) . '</div>
                    <div class="spec-item"><i class="fas fa-tachometer-alt"></i> ' . htmlspecialchars($car['acceleration']) . '</div>
                    <div class="spec-item"><i class="fas fa-chair"></i> ' . htmlspecialchars($car['seats']) . ' Seats</div>
                    <div class="spec-item"><i class="fas fa-gas-pump"></i> ' . htmlspecialchars($car['fuel_type']) . '</div>
                </div>';

                    // Step 4: Show appropriate button
                    if ($isConfirmed) {
                        echo '<button class="order-btn disabled" disabled><i class="fas fa-clock"></i> ' . htmlspecialchars($statusText) . '</button>';
                    } elseif ($isHidden) {
                        echo '<button class="order-btn unavailable" disabled><i class="fas fa-lock"></i> ' . htmlspecialchars($statusText) . '</button>';
                    } else {
                        echo '<button class="order-btn" onclick="orderCar(\'' . addslashes($carName) . '\')"><i class="fas fa-car"></i> Order Now</button>';
                    }

                    echo '</div></div>';
                }
            } else {
                echo "<p>No cars available.</p>";
            }
            ?>


        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>About Royal Cars</h3>
                <p>Royal Cars is a premium car rental service dedicated to providing luxury vehicles for all occasions at competitive prices.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="aboutus.html">About Us</a></li>
                    <li><a href="Cars.html">Our Fleet</a></li>
                    <li><a href="policy.html">Rental Policy</a></li>
                    <li><a href="contactus.html">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Info</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Luxury Ave, Beverly Hills</li>
                    <li><i class="fas fa-phone"></i> (555) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> info@royalcars.com</li>
                    <li><i class="fas fa-clock"></i> Mon-Sun: 24/7</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Royal Cars. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/cars.js"></script>
</body>

</html>