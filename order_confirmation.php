<?php
session_start();
require 'db.php';

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Order ID is missing.");
}

$order_id = (int)$_GET['order_id'];

// Fetch order and customer info
$order_stmt = $conn->prepare("
    SELECT o.*, c.first_name, c.last_name 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    WHERE o.id = ?
");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    die("❌ Order not found.");
}

$order = $order_result->fetch_assoc();

// Parse items
$items = explode(',', $order['items']);
$cartItems = [];

foreach ($items as $item) {
    [$productId, $quantity] = explode(':', $item);
    $cartItems[] = ['product_id' => (int)$productId, 'quantity' => (int)$quantity];
}

// Get product details
$productIds = array_column($cartItems, 'product_id');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$product_stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE product_id IN ($placeholders)");
$product_stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

$productMap = [];
while ($row = $product_result->fetch_assoc()) {
    $productMap[$row['product_id']] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .order-box {
            background: #fff;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .order-box h2 {
            color: #4CAF50;
            font-size: 26px;
        }
        .details p {
            margin: 5px 0;
            font-size: 15px;
        }
        .product-row {
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .product-row img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-info {
            flex-grow: 1;
        }
        .subtotal {
            font-weight: 600;
            color: #333;
        }
        .return-link {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background-color: #6ec072;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }
        .return-link i {
            margin-right: 6px;
        }
        .service-fee {
            font-weight: 600;
            margin-top: 15px;
            font-size: 16px;
            color: #666;
        }
        .delivery-info {
            background: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 15px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="order-box">
        <h2><i class="fas fa-check-circle"></i> Thank you, <?= htmlspecialchars($order['first_name']) ?>!</h2>
        <div class="details">
            <p><strong>Order #:</strong> <?= $order['id'] ?></p>
            <p><strong>Total:</strong> R<?= number_format($order['total'], 2) ?></p>
            <p><strong>Payment Method:</strong> 
                <?= ucfirst(htmlspecialchars($order['payment_method'])) ?> 
                <?php 
                switch (strtolower($order['payment_method'])) {
                    case 'paypal':
                        echo '<i class="fab fa-cc-paypal" style="color:#003087;"></i>';
                        break;
                    case 'eft':
                        echo '<i class="fas fa-university" style="color:#4CAF50;"></i>';
                        break;
                    case 'cod':
                        echo '<i class="fas fa-money-bill-wave" style="color:#4CAF50;"></i>';
                        break;
                    default:
                        echo '<i class="fas fa-credit-card" style="color:#0070ba;"></i>';
                }
                ?>
            </p>
            <p><strong>Date Ordered:</strong> <?= date("F j, Y H:i", strtotime($order['created_at'])) ?></p>

            <div class="delivery-info">
                <p><strong>Recipient Name:</strong> <?= htmlspecialchars($order['recipient_name']) ?></p>
                <p><strong>Cellphone:</strong> <?= htmlspecialchars($order['cellphone']) ?></p>
                <p><strong>Delivery Address:</strong> <?= nl2br(htmlspecialchars($order['delivery_address'])) ?></p>
                <p><strong>Delivery Date:</strong> <?= date("F j, Y", strtotime($order['delivery_date'])) ?></p>
                <p class="service-fee">Includes a fixed service fee of <strong>R<?= number_format($order['service_fee'], 2) ?></strong></p>
                <?php if (strtolower($order['payment_method']) === 'cod'): ?>
                    <p style="color: #d9534f; font-weight: 600;">Please make sure you have change when the driver arrives.</p>
                <?php endif; ?>
            </div>
        </div>

        <h3 style="margin-top: 30px;">🧾 Items Ordered</h3>

        <?php foreach ($cartItems as $item): 
            $product = $productMap[$item['product_id']] ?? null;
            if (!$product) continue;
            $subtotal = $item['quantity'] * $product['price'];
        ?>
        <div class="product-row">
            <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="product-info">
                <strong><?= htmlspecialchars($product['name']) ?></strong><br>
                Qty: <?= $item['quantity'] ?> × R<?= number_format($product['price'], 2) ?>
            </div>
            <div class="subtotal">
                R<?= number_format($subtotal, 2) ?>
            </div>
        </div>
        <?php endforeach; ?>

        <a href="home.php" class="return-link"><i class="fas fa-arrow-left"></i> Return to Website</a>
    </div>
</body>
</html>

