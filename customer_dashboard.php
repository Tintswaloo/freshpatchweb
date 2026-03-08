<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
require_once 'db_connect.php'; // this should connect to your DB

// Get user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get some recent orders
$order_stmt = $conn->prepare("SELECT id, order_date, total FROM orders WHERE user_id = ? ORDER BY order_date DESC LIMIT 5");
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$orders = $order_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; }
        .header { background: #007BFF; color: white; padding: 10px; }
        .nav { margin-top: 10px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007BFF; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    </div>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="orders.php">My Orders</a>
        <a href="logout.php">Logout</a>
    </div>

    <h3>Recent Orders</h3>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Total ($)</th>
        </tr>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo date('Y-m-d', strtotime($order['order_date'])); ?></td>
                <td><?php echo number_format($order['total'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
