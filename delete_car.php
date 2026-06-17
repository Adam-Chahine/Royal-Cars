<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];

    include 'db.php';

    // 🔍 Step 1: Get the image_url for that car
    $getImageStmt = $conn->prepare("SELECT image_url FROM cars WHERE name = ?");
    $getImageStmt->bind_param("s", $name);
    $getImageStmt->execute();
    $getImageStmt->bind_result($image_url);
    $getImageStmt->fetch();
    $getImageStmt->close();

    // 🗑 Step 2: If the image is a local file (from uploads/), delete it
    if (!empty($image_url) && str_starts_with($image_url, 'uploads/') && file_exists($image_url)) {
        unlink($image_url);
    }

    // 🗑 Step 3: Delete the car from the database
    $stmt = $conn->prepare("DELETE FROM cars WHERE name = ?");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: succes.php?type=delete");
            exit();
        } else {
            echo "No car found with that name.";
        }
    } else {
        echo "Error deleting car: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
