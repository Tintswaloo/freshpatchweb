<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Filters
$where = [];
$params = [];
$types = "";

// Search by customer name or product
$search = $_GET['search'] ?? '';
$status_filter = $_GET['status'] ?? '';

if (!empty($search)) {
    $where[] = "(c.first_name LIKE ? OR c.last_name LIKE ?)";
    $searchVal = '%' . $search . '%';
    $params[] = $searchVal;
    $params[] = $searchVal;
    $types .= "ss";
}

if (!empty($status_filter)) {
    $where[] = "o.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql = "
    SELECT 
        o.id AS order_id,
        o.customer_id, 
        o.items,
        o.payment_method,
        o.delivery_address,
        o.recipient_name,
        o.cellphone,
        o.delivery_date, 
        o.status, 
        o.total AS total_amount,
        c.first_name,
        c.last_name
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY o.delivery_date DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Orders | Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f9f9f9;
            max-width: 1200px;
            margin: auto;
        }
        h2 {
            color: #28a745;
            text-align: center;
        }
        form.search-filter {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        input, select, button {
            padding: 8px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 8px #ccc;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }
        .product-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }
        a.back {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #28a745;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>All Orders</h2>

<form class="search-filter" method="get">
    <input type="text" name="search" placeholder="Search by customer..." value="<?= htmlspecialchars($search) ?>">
    <select name="status">
        <option value="">-- Filter by Status --</option>
        <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Delivered" <?= $status_filter === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
    </select>
    <button type="submit">Apply</button>
</form>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Items Purchased</th>
            <th>Total (R)</th>
            <th>Payment Method</th>
            <th>Delivery Date</th>
            <th>Delivery Address</th>
            <th>Recipient</th>
            <th>Contact</th>
        </tr>
    </thead>
    <tbody>
        <?php while($order = $result->fetch_assoc()): ?>
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
                $productRes = $productStmt->get_result();
                $product = $productRes->fetch_assoc();

                if ($product) {
                    $imagePath = 'images/' . $product['image'];
                    $itemDetails[] = "
                        <div class='product-item'>
                            <img src='$imagePath' alt='{$product['name']}'>
                            <span>{$product['name']} (x$qty)</span>
                        </div>";
                } else {
                    $itemDetails[] = "Unknown Product (x$qty)";
                }
            }

            $itemText = implode("", $itemDetails);
            ?>
            <tr>
                <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                <td><?= $itemText ?></td>
                <td><?= number_format($order['total_amount'], 2) ?></td>
                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                <td><?= htmlspecialchars($order['delivery_date']) ?></td>
                <td><?= htmlspecialchars($order['delivery_address']) ?></td>
                <td><?= htmlspecialchars($order['recipient_name']) ?></td>
                <td><?= htmlspecialchars($order['cellphone']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p style="text-align:center;">No orders found.</p>
<?php endif; ?>

<a href="admin_dashboard.php" class="back">← Back to Dashboard</a>

</body>
</html>

