<?php
session_start();

// Save form inputs to session
$_SESSION['checkout_data'] = [
    'recipient_name'   => $_POST['recipient_name'] ?? '',
    'cellphone'        => $_POST['cellphone'] ?? '',
    'delivery_address' => $_POST['delivery_address'] ?? '',
    'delivery_date'    => $_POST['delivery_date'] ?? '',
    'payment_method'   => $_POST['payment_method'] ?? ''
];

// Redirect to process payment
header("Location: process_payment.php");
exit;
