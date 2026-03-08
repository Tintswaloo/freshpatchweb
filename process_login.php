<?php
session_start();
require 'db_connection.php';

// Sanitize input
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Check for empty fields
if (empty($email) || empty($password)) {
    header("Location: login.php?error=emptyfields");
    exit();
}

// Fetch user by email
$stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // ✅ Check password
    if (password_verify($password, $row['password'])) {
        $_SESSION['customer_id'] = $row['id'];
        $_SESSION['customer_name'] = $row['first_name'] . ' ' . $row['last_name'];

        // Redirect to home
        header("Location: index.php");
        exit();
    } else {
        // Wrong password
        header("Location: login.php?error=wrongpassword");
        exit();
    }
} else {
    // No user found
    header("Location: login.php?error=nouser");
    exit();
}

// Failsafe (just in case)
header("Location: login.php?error=unknown");
exit();
?>
