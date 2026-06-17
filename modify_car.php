<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name_car']) && !empty($_POST['name_car'])) {
    $name = $_POST['name_car'];
    
    $fields = [];
    $params = [];
    $types = "";

    if (!empty($_POST['name'])) {
        $fields[] = "name = ?";
        $params[] = $_POST['name'];
        $types .= "s";
    }

    if (!empty($_POST['price_per_day'])) {
        $fields[] = "price_per_day = ?";
        $params[] = $_POST['price_per_day'];
        $types .= "d";
    }

    // 🔽 Image logic: prefer file if uploaded
$image_url = trim($_POST['image_url']); // default

if (!empty($_FILES['image_file']['name'])) {
    // Step 1: Connect early to get old image
    include 'db.php';

    // Step 2: Get current image_url from DB
    $getOldImage = $conn->prepare("SELECT image_url FROM cars WHERE name = ?");
    $getOldImage->bind_param("s", $name);
    $getOldImage->execute();
    $getOldImage->bind_result($oldImageUrl);
    $getOldImage->fetch();
    $getOldImage->close();

    // Step 3: Delete old image if local file
    if (!empty($oldImageUrl) && str_starts_with($oldImageUrl, 'uploads/') && file_exists($oldImageUrl)) {
        unlink($oldImageUrl);
    }

    // Step 4: Upload new image
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

    // Overwrite image_url with new file
    $image_url = $targetFilePath;

    // Do not close the connection yet, it's reused below
    } else {
    // Connection will be opened later in main block
    $conn = null;
    
    } if (!empty($_POST['image_url'])) {
        $image_url = trim($_POST['image_url']);
    }

    if (!empty($image_url)) {
        $fields[] = "image_url = ?";
        $params[] = $image_url;
        $types .= "s";
    }

    if (!empty($_POST['badge'])) {
        $fields[] = "badge = ?";
        $params[] = $_POST['badge'];
        $types .= "s";
    }

    if (!empty($_POST['acceleration'])) {
        $fields[] = "acceleration = ?";
        $params[] = $_POST['acceleration'];
        $types .= "s";
    }

    if (!empty($_POST['seats'])) {
        $fields[] = "seats = ?";
        $params[] = $_POST['seats'];
        $types .= "i";
    }

    if (!empty($_POST['fuel_type'])) {
        $fields[] = "fuel_type = ?";
        $params[] = $_POST['fuel_type'];
        $types .= "s";
    }

    if (empty($fields)) {
        echo "⚠ No fields to update. Please fill at least one field.";
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "royal_cars");
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE cars SET " . implode(", ", $fields) . " WHERE name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "❌ SQL error: " . $conn->error;
        exit;
    }

    $params[] = $name;
    $types .= "s";

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: succes.php?type=modify");
            exit();
        } else {
            echo "⚠ No car found with the name '$name' or no changes made.";
        }
    } else {
        echo "❌ Error executing update: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "❌ Invalid request. Car name is required.";
}
?>
