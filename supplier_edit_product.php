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

// Get product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Missing or invalid product ID.");
}

$product_id = intval($_GET['id']);

// Fetch product info
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND supplier_id = ?");
$stmt->bind_param("ii", $product_id, $supplier_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found or access denied.");
}

$product = $result->fetch_assoc();

// Fetch categories
$categories = [];
$catResult = $conn->query("SELECT id, name FROM categories");
while ($row = $catResult->fetch_assoc()) {
    $categories[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock_quantity']);

    $imageName = $product['image']; // Default: keep current image

    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $uploadDir = "uploads/";
        $imageName = basename($_FILES['image']['name']);
        $uploadPath = $uploadDir . $imageName;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $error = "❌ Image upload failed.";
        }
    }

    if (!$error && $name && $category_id && $price > 0 && $stock >= 0) {
        $updateStmt = $conn->prepare("UPDATE products SET name = ?, category_id = ?, price = ?, stock_quantity = ?, image = ? WHERE product_id = ? AND supplier_id = ?");
        $updateStmt->bind_param("sdisiii", $name, $category_id, $price, $stock, $imageName, $product_id, $supplier_id);

        if ($updateStmt->execute()) {
            $success = "✅ Product updated successfully!";
            // Refresh product data
            $product['name'] = $name;
            $product['category_id'] = $category_id;
            $product['price'] = $price;
            $product['stock_quantity'] = $stock;
            $product['image'] = $imageName;
        } else {
            $error = "❌ Update failed: " . $updateStmt->error;
        }
    } else if (!$error) {
        $error = "❌ All fields must be filled in correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
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
        .preview {
            margin-top: 10px;
        }
        .preview img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }
        .back-link {
            text-align: center;
            display: block;
            margin-top: 20px;
            color: #4caf50;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">✏️ Edit Product</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Price (R):</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

    <label>Stock Quantity:</label>
    <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required>

    <label>Current Image:</label>
    <div class="preview">
        <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Current Image">
    </div>

    <label>Change Image (optional):</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Save Changes</button>

    <?php if ($success): ?>
        <p class="msg"><?= htmlspecialchars($success) ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</form>

<a class="back-link" href="supplier_dashboard.php">&larr; Back to Dashboard</a>

</body>
</html>
