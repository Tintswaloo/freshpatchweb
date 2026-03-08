<?php
session_start();
if (!isset($_SESSION['supplier_id'])) {
    header("Location: /login.php");
    exit;
}

include('../db_connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .status-pending { color: orange; }
        .status-approved { color: green; }
        .status-rejected { color: red; }
    </style>
</head>
<body>
    <h1>My Products</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert">Product added successfully!</div>
    <?php endif; ?>
    
    <a href="add.php">Add New Product</a>
    
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $products = $db->query("SELECT * FROM products WHERE grower_id = {$_SESSION['supplier_id']} ORDER BY created_at DESC");
            while ($product = $products->fetch_assoc()):
                $status_class = 'status-' . $product['approval_status'];
            ?>
                <tr>
                    <td><img src="images/<?= htmlspecialchars($product['image_url']) ?>" width="50"></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars(substr($product['description'], 0, 50)) ?>...</td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td><?= $product['stock_quantity'] ?> <?= htmlspecialchars($product['unit']) ?></td>
                    <td class="<?= $status_class ?>"><?= ucfirst($product['approval_status']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $product['product_id'] ?>">Edit</a>
                        <?php if ($product['approval_status'] == 'rejected' && !empty($product['admin_notes'])): ?>
                            <br><small>Reason: <?= htmlspecialchars($product['admin_notes']) ?></small>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>