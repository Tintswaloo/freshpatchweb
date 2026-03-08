<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Missing product ID.");
}

$id = (int) $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

// Load suppliers
$suppliers = $conn->query("SELECT * FROM suppliers");

$success = false;

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = (float) $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);
    $supplier_id = (int) $_POST['supplier_id'];

    $conn->query("UPDATE products SET 
                    name = '$name', 
                    price = $price, 
                    description = '$description',
                    supplier_id = $supplier_id
                  WHERE id = $id");

    $success = true;

    // Reload product after update
    $product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            background: #fff;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ddd;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, textarea, select, button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }
        .back-link {
            text-align: center;
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Edit Product</h2>

    <?php if ($success): ?>
        <div class="success">✅ Product updated successfully!</div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required>
        <textarea name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>

        <select name="supplier_id" required>
            <?php while ($s = $suppliers->fetch_assoc()): ?>
                <option value="<?= $s['id'] ?>" <?= $s['id'] == $product['supplier_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['full_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">💾 Save Changes</button>
    </form>

    <a href="admin.php" class="back-link">🔙 Back to Admin Dashboard</a>
</div>

</body>
</html>
