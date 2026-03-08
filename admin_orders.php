<?php
session_start();
require 'db.php';

// Build filters
$where = [];
$params = [];
$types = "";

if (!empty($_GET['customer'])) {
    $where[] = "(c.first_name LIKE ? OR c.last_name LIKE ?)";
    $search = '%' . $_GET['customer'] . '%';
    $params[] = $search;
    $params[] = $search;
    $types .= "ss";
}

if (!empty($_GET['date'])) {
    $where[] = "DATE(o.created_at) = ?";
    $params[] = $_GET['date'];
    $types .= "s";
}

// SQL with joins and filters
$sql = "SELECT o.*, c.first_name, c.last_name 
        FROM orders o
        JOIN customers c ON o.customer_id = c.id";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - All Orders</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            margin: 30px;
        }
        h1 {
            color: #2f6e2f;
        }
        .back-btn, .filter-form button {
            background: #2f6e2f;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .back-btn:hover, .filter-form button:hover {
            background: #245924;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            font-size: 14px;
            vertical-align: top;
        }
        th {
            background-color: #e7f4e7;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input {
            padding: 6px;
            margin-right: 10px;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.2s;
        }
        .product-item img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <h1>All Orders</h1>
    <a href="admin_dashboard.php" class="back-btn">← Back to Admin Panel</a>

    <form method="get" class="filter-form">
        <input type="text" name="customer" placeholder="Search by customer" value="<?= htmlspecialchars($_GET['customer'] ?? '') ?>">
        <input type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
        <button type="submit">Filter</button>
    </form>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total</th>
            <th>Service Fee</th>
            <th>Payment</th>
            <th>Delivery Address</th>
            <th>Recipient</th>
            <th>Cellphone</th>
            <th>Status</th>
            <th>Delivery Date</th>
            <th>Created At</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <?php
                // Decode items
                $items = explode(',', $order['items']);
                $itemDetails = [];

                foreach ($items as $item) {
                    list($productId, $qty) = explode(':', $item);
                    $productId = (int)$productId;
                    $qty = (int)$qty;

                    $productStmt = $conn->prepare("SELECT name, image FROM products WHERE product_id = ?");
                    $productStmt->bind_param("i", $productId);
                    $productStmt->execute();
                    $productResult = $productStmt->get_result();

                    if ($product = $productResult->fetch_assoc()) {
                        $imagePath = 'product_images/' . $product['image']; // Adjust folder if needed
                        $itemDetails[] = "
                            <div class='product-item'>
                                <a href='$imagePath' target='_blank'>
                                    <img src='$imagePath' alt='{$product['name']}'>
                                </a>
                                <span>{$product['name']} (x$qty)</span>
                            </div>";
                    } else {
                        $itemDetails[] = "Product ID $productId (x$qty)";
                    }
                }

                $itemText = implode("", $itemDetails);
                ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                    <td><?= $itemText ?></td>
                    <td>R<?= number_format($order['total'], 2) ?></td>
                    <td>R<?= number_format($order['service_fee'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td><?= htmlspecialchars($order['delivery_address']) ?></td>
                    <td><?= htmlspecialchars($order['recipient_name']) ?></td>
                    <td><?= htmlspecialchars($order['cellphone']) ?></td>
                    <td>
                        <?= htmlspecialchars($order['status'] ?? 'Pending') ?>
                        <?php if (($order['status'] ?? 'Pending') !== 'Delivered'): ?>
                            <form method="post" action="mark_delivered.php" style="margin-top: 5px;">
                                <button type="submit" class="back-btn" style="font-size: 12px;">Mark as Delivered</button>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td><?= $order['delivery_date'] ?? 'N/A' ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="12">No orders found.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>

