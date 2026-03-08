<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$adminName = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e0f2f1;
      margin: 0;
      padding: 0;
    }

    .dashboard-container {
      max-width: 800px;
      margin: 60px auto;
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #2e7d32;
    }

    .welcome {
      text-align: center;
      margin-bottom: 30px;
      font-size: 18px;
    }

    .dashboard-links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }

    .dashboard-links a {
      text-decoration: none;
      background-color: #4caf50;
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      transition: background-color 0.3s;
      font-weight: bold;
      text-align: center;
      min-width: 180px;
    }

    .dashboard-links a:hover {
      background-color: #388e3c;
    }

    .logout {
      text-align: center;
      margin-top: 40px;
    }

    .logout a {
      color: #d32f2f;
      font-weight: bold;
      text-decoration: none;
    }

    .logout a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <p class="welcome">Welcome, <strong><?= htmlspecialchars($adminName) ?></strong> 👋</p>

    <div class="dashboard-links">
      <a href="admin_suppliers.php">Manage Suppliers</a>
      <a href="admin_manage_products.php">Manage Products</a>
      <a href="admin_addproduct.php">Add Product</a>
      <a href="approve_products.php">Approve Products</a> <!-- NEW -->
      <a href="#">View Orders</a>
      <a href="#">Reports</a>
      <a href="admin_addsupplier.php">Add Supplier</a>
    </div>

    <div class="logout">
      <p><a href="logout_admin.php">Log out</a></p>
    </div>
  </div> 
</body>
</html>
