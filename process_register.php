<?php
session_start();
require 'db_connection.php';

// Sanitize input
$username       = trim($_POST['username'] ?? '');
$email          = trim($_POST['email'] ?? '');
$first_name     = trim($_POST['first_name'] ?? '');
$last_name      = trim($_POST['last_name'] ?? '');
$password       = $_POST['password'] ?? '';
$confirm        = $_POST['confirm_password'] ?? '';
$home_address   = trim($_POST['home_address'] ?? '');
$phone_number   = trim($_POST['phone_number'] ?? '');

// Basic validations
if (empty($username) || empty($email) || empty($first_name) || empty($last_name) || empty($password) || empty($confirm) || empty($home_address) || empty($phone_number)) {
    header("Location: register.php?error=emptyfields");
    exit();
}

if ($password !== $confirm) {
    header("Location: register.php?error=passwordmismatch");
    exit();
}

// Password strength validation
if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||     // at least one uppercase letter
    !preg_match('/[a-z]/', $password) ||     // at least one lowercase letter
    !preg_match('/[0-9]/', $password) ||     // at least one digit
    !preg_match('/[@$!%*?&]/', $password)    // at least one special char
) {
    // You could create a new error type or just reuse existing
    header("Location: register.php?error=weakpassword");
    exit();
}

// Check for existing email
$stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    header("Location: register.php?error=emailtaken");
    exit();
}
$stmt->close();

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$stmt = $conn->prepare("
    INSERT INTO customers (username, email, first_name, last_name, password, home_address, phone_number) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("sssssss", $username, $email, $first_name, $last_name, $hashedPassword, $home_address, $phone_number);

if ($stmt->execute()) {
    header("Location: login.php?success=registered");
    exit();
} else {
    echo "Database error: " . $conn->error;
}
?>



