<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart | Fresh Patch</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f4fdf4;
    }

    h2 {
      text-align: center;
      margin: 30px 0 20px;
      font-size: 28px;
      color: #2b572d;
    }

    .cart-container {
      max-width: 1000px;
      margin: 0 auto 40px;
      padding: 0 20px;
      animation: slideUp 0.5s ease-in-out;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #6ec072;
      color: white;
      font-size: 16px;
    }

    tr:last-child td {
      border-bottom: none;
    }

    td a {
      color: red;
      text-decoration: none;
      font-size: 18px;
    }

    .empty-message {
      text-align: center;
      font-size: 18px;
      color: #777;
    }

    .grand-total {
      font-weight: bold;
      font-size: 18px;
      background-color: #f0fdf0;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <h2>🛒 Your Shopping Cart</h2>
  <div class="cart-container">
    <?php if (empty($cart)): ?>
      <p class="empty-message">Your cart is empty.</p>
    <?php else: 
      // Debug: uncomment to see cart contents
      // echo "<pre>"; print_r($cart); echo "</pre>";
    ?>
      <table>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Total</th>
          <th>Remove</th>
        </tr>
        <?php 
        $grandTotal = 0;
        foreach ($cart as $index => $item): 
            // Ensure price is numeric
            $price = is_numeric($item['price']) ? floatval($item['price']) : 0;
            $quantity = isset($item['quantity']) ? intval($item['quantity']) : 1;
            $total = $price * $quantity;
            $grandTotal += $total;
        ?>
        <tr>
          <td><?= htmlspecialchars($item['name'] ?? 'Unknown Product') ?></td>
          <td><?= $quantity ?></td>
          <td>R<?= number_format($price, 2) ?></td>
          <td>R<?= number_format($total, 2) ?></td>
          <td><a href="cart.php?remove=<?= $item['id'] ?? $index ?>">❌</a></td>
        </tr>
        <?php endforeach; ?>
        <tr class="grand-total">
          <td colspan="3">Grand Total</td>
          <td colspan="2">R<?= number_format($grandTotal, 2) ?></td>
        </tr>
      </table>
      
      <div style="text-align: center; margin-top: 30px;">
        <a href="checkout.php" style="background: linear-gradient(135deg, #6ec072 0%, #45a049 100%); color: white; padding: 15px 40px; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(110, 192, 114, 0.3); transition: all 0.3s ease;">
          Proceed to Checkout →
        </a>
      </div>
    <?php endif; ?>
  </div>
        
  <div id="footer-placeholder"></div>

  <script>
    // Load footer
    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data);
  </script>
</body>
</html>
