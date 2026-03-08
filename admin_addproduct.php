<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $supplier_id = intval($_POST['supplier_id']);
    $imageName = $_FILES['images']['name'];
    $imageTmp = $_FILES['images']['tmp_name'];
    $uploadDir = 'images/';
    $imagePath = $uploadDir . basename($imageName);
    $category = $_POST['category'] ?? 'Uncategorized';
$approved = isset($_POST['approved']) ? 1 : 0;


    if ($name && $price > 0 && $description && $supplier_id && $imageName) {
        if (move_uploaded_file($imageTmp, $imagePath)) {
           $stmt = $conn->prepare("INSERT INTO products (name, price, description, supplier_id, image, category, approved) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdsissi", $name, $price, $description, $supplier_id, $imageName, $category, $approved);

            if ($stmt->execute()) {
                // header("Location: admin_manage_products.php?success=1");
                // exit;
                echo "success";
            } else {
                $error = "There was an error adding this product.";
            }
        } else {
            $error = "Image upload failed.";
        }
    } else {
        $error = "All fields are required and price must be valid.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background: #f0f4f3;
    }

    form {
      max-width: 500px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #4caf50;
    }

    label {
      font-weight: bold;
      margin-top: 15px;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      box-sizing: border-box;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    button {
      background: #4caf50;
      color: white;
      border: none;
      padding: 12px;
      margin-top: 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }

    button:hover {
      background: #45a049;
    }

    .error {
      color: red;
      margin-top: 10px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 25px;
      color: #4caf50;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

<h2>➕ Add New Product</h2>

<form method="POST" action="" enctype="multipart/form-data">
  <label>Product Name:</label>
  <input type="text" name="name" required>

  <label>Price (R):</label>
  <input type="number" step="0.01" name="price" required>

  <label>Description:</label>
  <textarea name="description" rows="4" required></textarea>

  <label>Supplier:</label>
  <select name="supplier_id" required>
    <option value="">-- Select Supplier --</option>
    <?php
    $supplier_query = $conn->query("SELECT supplier_id, business_name FROM suppliers");
    while ($s = $supplier_query->fetch_assoc()) {
        $id = (int)$s['supplier_id'];
        $name = htmlspecialchars($s['business_name']);
        echo "<option value='$id'>$name</option>";
    }
    ?>
  </select>
  <label>Category:</label>
  <select name="category" required>
    <option value="Uncategorized">Uncategorized</option>
    <option value="Fruit">Fruit</option>
    <option value="Vegetable">Vegetable</option>
    <option value="Herb">Herb</option>
    <option value="Dairy">Dairy</option>
    <option value="Beverages">Beverages</option>

  <label>Approve this product:</label>
  <input type="checkbox" name="approved" value="1">

  <label>Product Image:</label>
  <input type="file" name="images" accept="images/*" required>

  <?php if (isset($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>

  <button type="submit">Add Product</button>
</form>

<a class="back-link" href="admin_dashboard.php">← Back to Dashboard</a>

</body>
</html>
