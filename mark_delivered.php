<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id'];

    $stmt = $conn->prepare("UPDATE orders SET status = 'Delivered', delivery_date = NOW() WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    header("Location: admin_orders.php");
    exit();
}
