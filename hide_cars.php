<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hide_car_btn'])) {
    $carName = $conn->real_escape_string($_POST['car_to_hide']);
    $Problem = $conn->real_escape_string($_POST['problem']);

    // 1. Check if the car is reserved (confirmation table)
    $checkReserved = $conn->query("SELECT id FROM confirmation WHERE car_name = '$carName'");
    if ($checkReserved && $checkReserved->num_rows > 0) {
        echo "<p class='error'>❌ This car is currently reserved and cannot be hidden.</p>";
        echo "<a href='admin.php'>Back to admin</a>";
        exit();
    }

    // 2. Check if the car is already hidden (hidden_cars table)
    $checkHidden = $conn->query("SELECT id FROM hidden_cars WHERE name = '$carName'");
    if ($checkHidden && $checkHidden->num_rows > 0) {
        echo "<p class='error'>⚠ This car is already hidden.</p>";
        echo "<a href='admin.php'>Back to admin</a>";
        exit();
    }

    // 3. Fetch car info from cars table
    $res = $conn->query("SELECT name, category, price_per_day, image_url, badge, fuel_type FROM cars WHERE name = '$carName'");
    if ($res && $res->num_rows > 0) {
        $car = $res->fetch_assoc();

        // 4. Insert into hidden_cars
        $stmt = $conn->prepare("INSERT INTO hidden_cars (name, category, price_per_day, image_url, badge, fuel_type, problem) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdssss",
            $car['name'],
            $car['category'],
            $car['price_per_day'],
            $car['image_url'],
            $car['badge'],
            $car['fuel_type'],
            $Problem
        );

        if ($stmt->execute()) {
            header("Location: succes.php?type=hide");
            exit();
        } else {
            echo "<p class='error'>❌ Error hiding the car.</p>";
            echo "<a href='admin.php'>Back to admin</a>";
        }

        $stmt->close();
    } else {
        echo "<p class='error'>❌ Car not found in the cars table.</p>";
        echo "<a href='admin.php'>Back to admin</a>";
    }
}
?>
