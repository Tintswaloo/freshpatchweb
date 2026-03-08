<?php
session_start();
require 'db.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$cart = $_SESSION['cart'] ?? [];
$checkout = $_SESSION['checkout_data'] ?? [];

// If checkout data is missing, go back to form
if (empty($checkout)) {
    header("Location: checkout.php");
    exit();
}

// Validate delivery info
$recipient_name = trim($checkout['recipient_name'] ?? '');
$cellphone = trim($checkout['cellphone'] ?? '');
$delivery_address = trim($checkout['delivery_address'] ?? '');
$delivery_date = $checkout['delivery_date'] ?? '';
$paymentMethod = $checkout['payment_method'] ?? '';

if (!$recipient_name || !$cellphone || !$delivery_address || !$delivery_date || !$paymentMethod) {
    die("❌ Missing delivery or payment information.");
}

// Validate delivery date
$today = date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $delivery_date) || $delivery_date < $today) {
    die("❌ Invalid delivery date.");
}

// Validate cart
$cart = array_filter($cart, function($value, $key) {
    return is_array($value) && isset($value['quantity']) && is_numeric($key) && $key > 0;
}, ARRAY_FILTER_USE_BOTH);

if (empty($cart)) {
    die("❌ Your cart is empty or contains invalid items.");
}

// Get product prices
$productIds = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$stmt = $conn->prepare("SELECT product_id, price FROM products WHERE product_id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[$row['product_id']] = $row['price'];
}

// Calculate total
$subtotal = 0;
$itemsSummary = [];

foreach ($cart as $productId => $item) {
    $qty = $item['quantity'] ?? 1;
    $price = $products[$productId] ?? 0;
    $subtotal += $qty * $price;
    $itemsSummary[] = "$productId:$qty";
}

$serviceFee = 20;
$total = $subtotal + $serviceFee;
$itemsStr = implode(',', $itemsSummary);

// Insert into orders
$order_stmt = $conn->prepare("
    INSERT INTO orders 
    (customer_id, items, total, payment_method, delivery_address, delivery_date, service_fee, recipient_name, cellphone, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$order_stmt->bind_param(
    "isdssssss",
    $customer_id,
    $itemsStr,
    $total,
    $paymentMethod,
    $delivery_address,
    $delivery_date,
    $serviceFee,
    $recipient_name,
    $cellphone
);

$order_stmt->execute();
$order_id = $order_stmt->insert_id;

// Insert order items
$item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cart as $productId => $item) {
    $qty = $item['quantity'];
    $price = $products[$productId];
    $item_stmt->bind_param("iiid", $order_id, $productId, $qty, $price);
    $item_stmt->execute();
}

// Update stock
$stock_stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
foreach ($cart as $productId => $item) {
    $qty = $item['quantity'];
    $stock_stmt->bind_param("ii", $qty, $productId);
    $stock_stmt->execute();
}

// Clear cart and delivery data
unset($_SESSION['cart'], $_SESSION['checkout_data']);

// Show COD note
if ($paymentMethod === 'cod') {
    echo "<h2>Thank you for your order!</h2>";
    echo "<p>Please make sure you have the correct change ready when the driver arrives.</p>";
    echo "<p><a href='order_confirmation.php?order_id={$order_id}'>Click here to view your order details.</a></p>";
    exit;
}

// Simulate PayPal
if ($paymentMethod === 'paypal') {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Redirecting to PayPal</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 50px;
                text-align: center;
                background-color: #f5f5f5;
            }
            .paypal-box {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                display: inline-block;
            }
            .paypal-box i {
                font-size: 50px;
                color: #0070ba;
                margin-bottom: 20px;
            }
            .paypal-box h2 {
                margin-bottom: 10px;
            }
            .paypal-box p {
                color: #555;
            }
            .paypal-box a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: #0070ba;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class='paypal-box'>
            <i class='fab fa-cc-paypal'></i>
            <h2>Redirecting to PayPal...</h2>
            <a href='order_confirmation.php?order_id={$order_id}'>Continue</a>
        </div>
    </body>
    </html>";
    exit;
}

// Default: EFT or other → order confirmation
header("Location: order_confirmation.php?order_id=$order_id");
exit;



