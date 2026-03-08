<?php
session_start();
require 'db_connection.php'; // Ensure this connects to your DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $business = trim($_POST['farmname']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($business) || empty($password)) {
        die("❌ Please fill in all required fields.");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM suppliers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        die("❌ An account with this email already exists.");
    }
    $stmt->close();

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO suppliers (name, email, phone, business_name, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $business, $hashedPassword);
    
    if ($stmt->execute()) {
        $_SESSION['supplier_id'] = $stmt->insert_id;
        header("Location: supplier_dashboard.php");
        exit();
    } else {
        echo "❌ Error registering supplier: " . $stmt->error;
    }
}
?>
