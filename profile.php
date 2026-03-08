<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customerId = $_SESSION['customer_id'];

$stmt = $conn->prepare("SELECT username, first_name, last_name, email, phone, address FROM customers WHERE id = ?");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile | Fresh Patch</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-wrapper">
  <div class="login-box">
    <a href="index.php" class="home-link">← Back to Home</a>
    <h1>My Profile</h1>

    <div style="margin-top: 20px;">
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
    </div>

    <p style="margin-top: 20px;"><a href="logout.php">Logout</a></p>
  </div>
</body>
</html>

