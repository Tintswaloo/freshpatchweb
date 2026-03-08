<?php
session_start();
require 'db_connection.php'; // adjust if your file is named differently

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch user's orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Orders</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f9f9f9;
    }

    h1 {
      color: #333;
    }

    .order {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 20px;
      background-color: #fff;
      border-radius: 8px;
    }

    .order p {
      margin: 5px 0;
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      background: #6ec072;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <h1>My Orders</h1>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($order = $result->fetch_assoc()): ?>
      <div class="order">
        <p><strong>Order #<?= $order['id'] ?></strong></p>
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
        <p><strong>Items:</strong> <?= nl2br(htmlspecialchars($order['items'])) ?></p>
        <p><strong>Total:</strong> R<?= number_format($order['total'], 2) ?></p>
        <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>You have not placed any orders yet.</p>
  <?php endif; ?>

  <a href="home.php" class="back-btn">← Return to Website</a>

</body>
</html>
