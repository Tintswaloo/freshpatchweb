<?php
session_start();
require 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products | Fresh Patch</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9f9f9;
      margin: 20px;
    }

    h1 {
      color: #6ec072;
      text-align: center;
      margin-bottom: 30px;
    }

    .product-table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .product-table th, .product-table td {
      padding: 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    .product-table th {
      background-color: #6ec072;
      color: white;
    }

    .product-table tr:hover {
      background-color: #f1f1f1;
    }

    .actions a {
      margin-right: 10px;
      text-decoration: none;
      font-size: 16px;
    }

    .edit-link {
      color: #007bff;
    }

    .delete-link {
      color: red;
    }

    .back-link {
      display: inline-block;
      margin: 20px auto;
      text-align: center;
      color: #6ec072;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

<h1>📦 Manage Products</h1>

<table class="product-table">
  <tr>
    <th>Name</th>
    <th>Price (R)</th>
    <th>Supplier</th>
    <th>Description</th>
    <th>Actions</th>
  </tr>
  <?php
  $query = "SELECT products.*, suppliers.full_name 
            FROM products 
            LEFT JOIN suppliers ON products.supplier_id = suppliers.id";

  $result = $conn->query($query);

  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
          echo "<td>" . number_format($row['price'], 2) . "</td>";
          echo "<td>" . htmlspecialchars($row['full_name'] ?? 'N/A') . "</td>";
          echo "<td>" . htmlspecialchars($row['description']) . "</td>";
          echo "<td class='actions'>
                  <a class='edit-link' href='edit_product.php?id={$row['id']}'><i class='fa fa-pen'></i></a>
                  <a class='delete-link' href='delete_product.php?id={$row['id']}' onclick='return confirm(\"Delete this product?\");'><i class='fa fa-trash'></i></a>
                </td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='5' style='text-align:center;'>No products available.</td></tr>";
  }
  ?>
</table>

<div style="text-align:center;">
  <a href="admin.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
