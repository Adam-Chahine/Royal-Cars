<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price_per_day = $_POST['price_per_day'];
    $badge = $_POST['badge'];
    $acceleration = $_POST['acceleration'];
    $seats = $_POST['seats'];
    $fuel_type = $_POST['fuel_type'];

    // Default: use text URL if provided
    $image_url = trim($_POST['image_url']);

    // If image file is uploaded, use it instead
    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = time() . "_" . basename($_FILES["image_file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($imageFileType, $allowedTypes)) {
            die("<h2>❌ Invalid image format. Allowed: JPG, PNG, GIF, WEBP</h2>");
        }

        if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFilePath)) {
            die("<h2>❌ Failed to upload image.</h2>");
        }

        // Overwrite image_url with local file path
        $image_url = $targetFilePath;
    }

    // Validate that at least one image method is used
    if (empty($image_url)) {
        die("<h2>❌ Please provide an image URL or upload an image.</h2>");
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO cars (name, category, price_per_day, image_url, badge, acceleration, seats, fuel_type)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssis", $name, $category, $price_per_day, $image_url, $badge, $acceleration, $seats, $fuel_type);

    if ($stmt->execute()) {
        header("Location: succes.php?type=add");
        exit();
    } else {
        echo "<h2>❌ Failed to add car: " . $conn->error . "</h2>";
    }

    $stmt->close();
}
$conn->close();
