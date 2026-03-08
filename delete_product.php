<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Access denied.");
}

if (isset($_GET['index'])) {
    $index = (int)$_GET['index'];
    $products = file("products.txt", FILE_IGNORE_NEW_LINES);
    if (isset($products[$index])) {
        unset($products[$index]);
        file_put_contents("products.txt", implode("\n", $products));
    }
}

header("Location: admin.php");
exit();
?>
   