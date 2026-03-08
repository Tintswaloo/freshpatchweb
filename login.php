<?php
session_start();

// Connect to database
$con = new mysqli('localhost', 'Bianca', 'MyNewPass', 'freshpatch');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate form fields
if (empty($email) || empty($password)) {
    header("Location: login-register.html?error=emptyfields");
    exit();
}

// Check if customer exists
$query = $con->prepare("SELECT * FROM customers WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $customer = $result->fetch_assoc();
error_log("Entered password: " . $password);
error_log("Stored hash: " . $customer['password']);

    // Verify password
    if (password_verify($password, $customer['password'])) {
        // Login success: set session and redirect
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['customer_name'] = $customer['name'];

        header("Location: customer_dashboard.php");
        exit();
    } else {
        // Wrong password
        header("Location: login-register.html?error=wrongpassword");
        exit();
    }
} else {
    // No user found
    header("Location: login-register.html?error=nouser");
    exit();
}

// Close connections
$query->close();
$con->close();
?>
