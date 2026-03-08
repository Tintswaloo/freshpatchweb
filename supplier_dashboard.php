<?php
session_start();
if (!isset($_SESSION['supplier_id'])) {
    header("Location: supplier_login.php");
    exit();
}

require 'db_connection.php';

$supplier_id = $_SESSION['supplier_id'];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stock_quantities'])) {
    $stock_quantities = $_POST['stock_quantities'];
    foreach ($stock_quantities as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = intval($quantity);

        $updateStmt = $conn->prepare("UPDATE products SET stock_quantity = ? WHERE product_id = ? AND supplier_id = ?");
        $updateStmt->bind_param("iii", $quantity, $product_id, $supplier_id);
        $updateStmt->execute();
        $updateStmt->close();
    }
    $message = "Stock quantities updated successfully.";
}

// OPTIONAL: Fetch supplier name from DB if not in session
if (!isset($_SESSION['supplier_name'])) {
    $nameStmt = $conn->prepare("SELECT business_name FROM suppliers WHERE supplier_id = ?");
    $nameStmt->bind_param("i", $supplier_id);
    $nameStmt->execute();
    $nameResult = $nameStmt->get_result();
    if ($row = $nameResult->fetch_assoc()) {
        $supplier_name = $row['business_name'];
        $_SESSION['supplier_name'] = $supplier_name;
    } else {
        $supplier_name = 'Supplier';
    }
} else {
    $supplier_name = $_SESSION['supplier_name'];
}

// Fetch products for this supplier with category names
$stmt = $conn->prepare("
    SELECT p.product_id, p.name, c.name AS category, p.price, p.stock_quantity
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.supplier_id = ?
");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $supplier_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Supplier Dashboard - <?= htmlspecialchars($supplier_name) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        header {
            background: #4caf50;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background: #4caf50;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #d0e8d0;
        }
        .no-products {
            text-align: center;
            padding: 40px 0;
            color: #666;
            font-size: 18px;
        }
        .logout-link {
            display: block;
            margin: 20px auto 0;
            text-align: center;
            font-weight: bold;
            color: #4caf50;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
        button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
            display: block;
            width: 100%;
        }
        select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 70px;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }
        .action-btn {
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    margin-right: 5px;
}
.action-btn.edit {
    background-color: #2196F3;
    color: white;
}
.action-btn.delete {
    background-color: #f44336;
    color: white;
}
.action-btn.add {
    background-color: #2f8f2f;
    color: white;
}
    </style>
</head>
<body>

<header>Welcome, <?= htmlspecialchars($supplier_name) ?></header>

<div class="container">
    <a href="supplier_add_product.php" class="action-btn add" style="display:inline-block; margin-bottom: 20px;">Add New Product</a>
    <h2>Your Products</h2>
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <p class="message">🗑️ Product deleted successfully!</p>
<?php endif; ?>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (count($products) > 0): ?>
    <form method="POST" action="">
        <table>
            <thead>
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price (R)</th>
        <th>Stock Quantity</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['category'] ?? 'Uncategorized') ?></td>
        <td><?= number_format($product['price'], 2) ?></td>
        <td>
            <select name="stock_quantities[<?= intval($product['product_id']) ?>]">
                <?php
                $currentQty = intval($product['stock_quantity']);
                for ($i = 0; $i <= 100; $i++):
                    $selected = ($i === $currentQty) ? 'selected' : '';
                ?>
                <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </td>
        <td>
            <a href="supplier_edit_product.php?id=<?= $product['product_id'] ?>" class="action-btn edit">Edit</a>
            <a href="supplier_delete_product.php?id=<?= $product['product_id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

        </table>
        <button type="submit">Update Stock Quantities</button>
    </form>
    <?php else: ?>
        <p class="no-products">You have no products listed yet.</p>
    <?php endif; ?>

    <a class="logout-link" href="supplier_login.php">Logout</a>
</div>

</body>
</html>

