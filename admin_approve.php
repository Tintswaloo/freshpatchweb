<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

require 'db.php'; // or '../db_connection.php' depending on file structure

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);

$stmt = $conn->prepare("UPDATE products SET approved = 1 WHERE product_id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    header("Location: admin_manage_products.php?approved=1");
    exit();
} else {
    die("Error approving product: " . $stmt->error);
}
?>
