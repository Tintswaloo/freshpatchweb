<?php
session_start();
require 'db.php'; // or db_connect.php if that's the correct one

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check supplier credentials
    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); // Use password hashing in production!
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['supplier_logged_in'] = true;
        $_SESSION['supplier_email'] = $email;
        header("Location: supplier_dashboard.php"); // redirect to supplier page
        exit();
    } else {
        echo "❌ Invalid email or password";
    }
}
?>
