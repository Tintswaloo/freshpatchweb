<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Products | Fresh Patch</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
      width: 95%;
      margin: auto;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .product-table th, .product-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      vertical-align: middle;
    }

    .product-table th {
      background-color: #6ec072;
      color: white;
    }

    .product-table tr:hover {
      background-color: #f1f1f1;
    }

    .product-image {
      max-width: 60px;
      border-radius: 4px;
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

    .stock-form {
      display: flex;
      align-items: center;
    }

    .stock-form button {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      margin: 0 5px;
    }

    .stock-form span {
      font-weight: bold;
    }
  </style>
</head>
<body>

<h1>📦 Manage Products</h1>

<?php if (isset($_GET['approved']) && $_GET['approved'] == 1): ?>
  <p style="text-align:center; color: green; font-weight: bold;">✅ Product approved successfully!</p>
<?php endif; ?>

<?php if (isset($_GET['stock_updated'])): ?>
  <p style="text-align:center; color: green; font-weight: bold;">✅ Stock updated.</p>
<?php endif; ?>

<table class="product-table">
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Price (R)</th>
    <th>Supplier</th>
    <th>Category</th>
    <th>Status</th>
    <th>Description</th>
    <th>Stock</th>
    <th>Actions</th>
  </tr>

  <?php
  $query = "
    SELECT p.*, s.business_name, c.name AS category_name
    FROM products p
    LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
    LEFT JOIN categories c ON p.category_id = c.id
  ";

  $result = $conn->query($query);

  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td><img src='images/" . htmlspecialchars($row['image']) . "' alt='Product Image' class='product-image'></td>";
          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
          echo "<td>" . number_format($row['price'], 2) . "</td>";
          echo "<td>" . htmlspecialchars($row['business_name'] ?? 'N/A') . "</td>";
          echo "<td>" . htmlspecialchars($row['category_name'] ?? 'Uncategorized') . "</td>";
          echo "<td>" . ucfirst(htmlspecialchars($row['approval_status'] ?? 'pending')) . "</td>";
          echo "<td>" . htmlspecialchars($row['description']) . "</td>";

          // Stock control form
          echo "<td>
            <form method='POST' action='admin_update_stock.php' class='stock-form'>
              <input type='hidden' name='product_id' value='" . $row['product_id'] . "'>
              <button type='submit' name='action' value='decrease'>➖</button>
              <span>" . $row['stock_quantity'] . "</span>
              <button type='submit' name='action' value='increase'>➕</button>
            </form>
          </td>";

          echo "<td class='actions'>
            <a class='edit-link' href='edit_product.php?id=" . $row['product_id'] . "'><i class='fa fa-pen'></i></a>
            <a class='delete-link' href='delete_product.php?id=" . $row['product_id'] . "' onclick='return confirm(\"Delete this product?\");'><i class='fa fa-trash'></i></a>";

          if ($row['approved'] == 0) {
              echo " <a href='admin_approve.php?id=" . $row['product_id'] . "' style='color: green;' title='Approve Product'>✅</a>";
          } else {
              echo " <span style='color: gray;'>✔️</span>";
          }

          echo "</td></tr>";
      }
  } else {
      echo "<tr><td colspan='9' style='text-align:center;'>No products available.</td></tr>";
  }
  ?>
</table>

<div style="text-align:center;">
  <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
