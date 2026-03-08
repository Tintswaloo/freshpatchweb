<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$productId = (int)$_POST['product_id'];
$action = $_POST['action'];

if ($productId > 0 && in_array($action, ['increase', 'decrease'])) {
    $operator = $action === 'increase' ? '+' : '-';

    // Ensure stock doesn't go below 0
    if ($operator === '-') {
        $check = $conn->query("SELECT stock_quantity FROM products WHERE product_id = $productId");
        $current = $check->fetch_assoc()['stock_quantity'] ?? 0;
        if ($current <= 0) {
            header("Location: admin_manage_products.php?stock_updated=0");
            exit;
        }
    }

    $update = $conn->query("UPDATE products SET stock_quantity = stock_quantity $operator 1 WHERE product_id = $productId");

    if ($update) {
        header("Location: admin_manage_products.php?stock_updated=1");
    } else {
        echo "Error updating stock: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
