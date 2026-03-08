<?php
session_start();
if (!isset($_SESSION['supplier_id'])) {
    header("Location: supplier_login.php");
    exit();
}

require 'db_connection.php';

$supplier_id = $_SESSION['supplier_id'];

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);

// Verify the product belongs to the supplier
$stmt = $conn->prepare("SELECT image FROM products WHERE product_id = ? AND supplier_id = ?");
$stmt->bind_param("ii", $product_id, $supplier_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found or access denied.");
}

$product = $result->fetch_assoc();
$imagePath = 'uploads/' . $product['image'];

// Delete the product
$deleteStmt = $conn->prepare("DELETE FROM products WHERE product_id = ? AND supplier_id = ?");
$deleteStmt->bind_param("ii", $product_id, $supplier_id);

if ($deleteStmt->execute()) {
    // Optionally delete image file
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    header("Location: supplier_dashboard.php?deleted=1");
    exit();
} else {
    die("Error deleting product: " . $deleteStmt->error);
}
?>
