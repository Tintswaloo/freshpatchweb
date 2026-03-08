<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Select Payment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f5f5f5;
    }
    .payment-option {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    .payment-option i {
      font-size: 30px;
      margin-right: 15px;
      color: #333;
    }
    button {
      padding: 10px 20px;
      background-color: #4caf50;
      border: none;
      color: white;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Select Payment Method</h1>
  <form method="post" action="process_payment.php">
    <div class="payment-option">
      <i class="fas fa-money-bill-wave"></i>
      <label>
        <input type="radio" name="payment_method" value="Manual" required>
        Pay on Delivery
      </label>
    </div>
    <div class="payment-option">
      <i class="fab fa-cc-paypal"></i>
      <label>
        <input type="radio" name="payment_method" value="PayPal">
        Pay with PayPal
      </label>
    </div>
    <button type="submit">Proceed to Payment</button>
  </form>
</body>
</html>
