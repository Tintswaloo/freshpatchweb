<?php
session_start();

// Get product data from POST request (support both field name formats)
$id = $_POST['product_id'] ?? $_POST['id'] ?? null;
$name = $_POST['product_name'] ?? $_POST['name'] ?? null;
$price = $_POST['product_price'] ?? $_POST['price'] ?? null;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Validate and convert price to float
if (!$id || !$name || !$price) {
    header('Location: products.php?error=missing_data');
    exit();
}

// Convert price to float
$price = floatval($price);

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Check if product already exists in cart
$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $id) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}

// If product doesn't exist, add it
if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ];
}

// Redirect back to the previous page
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'products.php'));
exit();
