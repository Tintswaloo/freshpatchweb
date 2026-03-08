<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<h2>Your cart is empty.</h2>";
    echo "<a href='products.php'>🛍️ Continue Shopping</a>";
    exit;
}

// Calculate subtotal from cart (assuming you have product prices in session or fetch from DB)
require 'db.php';

// Prepare product IDs and fetch prices
$productIds = array_keys($cart);
if (empty($productIds)) {
    echo "<h2>Your cart is empty.</h2>";
    echo "<a href='products.php'>🛍️ Continue Shopping</a>";
    exit;
}
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$stmt = $conn->prepare("SELECT product_id, price, name FROM products WHERE product_id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[$row['product_id']] = $row;
}

$subtotal = 0;
foreach ($cart as $productId => $item) {
    $qty = $item['quantity'] ?? 1;
    if (isset($products[$productId])) {
        $subtotal += $products[$productId]['price'] * $qty;
    }
}

$serviceFee = 20;
$total = $subtotal + $serviceFee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Checkout - Fresh Patch</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9f7;
    margin: 0; padding: 0;
  }
  .container {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 128, 0, 0.15);
  }
  h2 {
    color: #4caf50;
    text-align: center;
    margin-bottom: 30px;
  }
  form label {
    display: block;
    margin: 15px 0 6px;
    font-weight: 600;
    color: #2a5934;
  }
  input[type="text"],
  input[type="tel"],
  input[type="date"],
  textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1.8px solid #c6d6be;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="tel"]:focus,
  input[type="date"]:focus,
  textarea:focus {
    border-color: #4caf50;
    outline: none;
  }
  textarea {
    resize: vertical;
    min-height: 80px;
  }
  .payment-methods {
    margin: 15px 0;
  }
  .payment-methods label {
    font-weight: 500;
    color: #3a6f3a;
    cursor: pointer;
  }
  .payment-methods input[type="radio"] {
    margin-right: 8px;
    accent-color: #4caf50;
  }
  .cod-note {
    background: #d8f0d8;
    border: 1px solid #a3d0a3;
    padding: 10px 14px;
    border-radius: 6px;
    color: #3a6f3a;
    font-weight: 500;
    margin-top: 6px;
    display: none;
  }
  .order-summary {
    background: #e7f0e7;
    border: 1px solid #b4d6b4;
    padding: 20px;
    border-radius: 10px;
    margin-top: 30px;
    font-size: 16px;
    color: #2f532f;
  }
  .order-summary strong {
    color: #396639;
  }
  .order-summary p {
    margin: 6px 0;
  }
  button[type="submit"] {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 15px;
    width: 100%;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 30px;
    transition: background-color 0.3s ease;
  }
  button[type="submit"]:hover {
    background-color: #3b8e3b;
  }
  @media (max-width: 480px) {
    .container {
      padding: 20px;
      margin: 20px;
    }
  }
</style>
<script>
  function toggleCODNote() {
    const codRadio = document.getElementById('payment-cod');
    const codNote = document.getElementById('cod-note');
    if (codRadio.checked) {
      codNote.style.display = 'block';
    } else {
      codNote.style.display = 'none';
    }
  }
  window.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    radios.forEach(radio => {
      radio.addEventListener('change', toggleCODNote);
    });
    toggleCODNote(); // Initial check
  });
</script>
</head>
<body>

<div class="container">
  <h2>Checkout</h2>

    <form action="save_checkout_data.php" method="POST" novalidate>
  <label>Name of person receiving delivery</label>
  <input type="text" name="recipient_name" required placeholder="Full name" />

  <label>Cellphone Number</label>
  <input type="tel" name="cellphone" required placeholder="e.g. 071 123 4567" pattern="[0-9\s\-+]+" />

  <label>Delivery Address</label>
  <textarea name="delivery_address" required placeholder="Enter your full delivery address"></textarea>

  <label>Choose Delivery Date</label>
  <input type="date" name="delivery_date" required min="<?= date('Y-m-d') ?>" />

  <label>Payment Method</label>
  <label><input type="radio" name="payment_method" value="paypal" required> PayPal</label>
  <label><input type="radio" name="payment_method" value="eft"> EFT</label>
  <label><input type="radio" name="payment_method" value="cod"> Cash on Delivery</label>

  <button type="submit">Proceed to Payment</button>
</form>

</div>

</body>
</html>




