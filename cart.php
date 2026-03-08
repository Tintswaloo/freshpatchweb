<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Check if product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    header("Location: view_cart.php");
    exit;
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $idToRemove = $_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $idToRemove);
    header("Location: view_cart.php");
    exit;
}

// If accessed directly without any action, redirect to view cart
header("Location: view_cart.php");
exit;
?>

