<?php
session_start();
require 'db.php';


if (!isset($_SESSION['admin'])) {
    die("Access denied.");
}

$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$imageFileName = '';

// Handle image upload
if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/";
    $imageFileName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageFileName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
}

// Save to database
if ($name && $price) {
    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $description, $imageFileName);

    if ($stmt->execute()) {
        header("Location: admin.php?success=1");
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }
} else {
    echo "❌ All fields are required.";
}
?>