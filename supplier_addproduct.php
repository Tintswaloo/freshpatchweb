<?php
session_start();
if (!isset($_SESSION['supplier_id'])) {
    header("Location: supplier_login.php");
    exit();
}

require 'db_connection.php';

$supplier_id = $_SESSION['supplier_id'];
$error = "";
$success = "";

// Fetch categories
$categories = [];
$catResult = $conn->query("SELECT id, name FROM categories");
while ($row = $catResult->fetch_assoc()) {
    $categories[] = $row;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock_quantity']);
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = "uploads/";
    $uploadPath = $uploadDir . basename($image);

    if ($name && $category_id && $price > 0 && $stock >= 0 && $image) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // create folder if it doesn't exist
        }

        if (move_uploaded_file($imageTmp, $uploadPath)) {
            $stmt = $conn->prepare("INSERT INTO products (name, category_id, price, stock_quantity, supplier_id, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdiiss", $name, $category_id, $price, $stock, $supplier_id, $image);

            if ($stmt->execute()) {
                $success = "✅ Product added successfully!";
            } else {
                $error = "❌ Database error: " . $stmt->error;
            }
        } else {
            $error = "❌ Image upload failed.";
        }
    } else {
        $error = "❌ All fields are required and must be valid.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial;
            padding: 30px;
            background-color: #f8fdf4;
        }
        form {
            background: #fff;
            max-width: 600px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .msg {
            text-align: center;
            margin-top: 15px;
            color: green;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">➕ Add New Product</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" required>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Price (R):</label>
    <input type="number" step="0.01" name="price" required>

    <label>Stock Quantity:</label>
    <input type="number" name="stock_quantity" required>

    <label>Product Image:</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Add Product</button>

    <?php if ($success): ?>
        <p class="msg"><?= htmlspecialchars($success) ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</form>

</body>
</html>
