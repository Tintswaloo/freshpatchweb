<?php
session_start();

if (!isset($_POST['product_id'], $_POST['action'])) {
    header("Location: cart.php");
    exit;
}

$productId = (int)$_POST['product_id'];
$action = $_POST['action'];

// Initialize cart if not set
if (!isset($_SESSION['cart'][$productId])) {
    header("Location: cart.php");
    exit;
}

switch ($action) {
    case 'increase':
        $_SESSION['cart'][$productId]['quantity']++;
        break;

    case 'decrease':
        $_SESSION['cart'][$productId]['quantity']--;
        if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$productId]);
        break;

    case 'set':
        $newQty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($newQty <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId]['quantity'] = $newQty;
        }
        break;
}

header("Location: cart.php");
exit;
