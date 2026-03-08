<?php
session_start();

if (isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    unset($_SESSION['cart'][$productId]);
}

header("Location: cart.php");
exit;

