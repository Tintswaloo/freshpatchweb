<?php
session_start();

// Connect to database
$con = new mysqli('localhost', 'root', 'MyNewPass', 'freshpatch');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get form data
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Validate form fields
if (empty($full_name) || empty($email) || empty($password)) {
    header("Location: login-register.php?error=emptyfields");
    exit();
}

// Check if customer already exists
$checkQuery = $con->prepare("SELECT * FROM customers WHERE email = ?");
$checkQuery->bind_param("s", $email);
$checkQuery->execute();
$result = $checkQuery->get_result();

if ($result->num_rows > 0) {
    header("Location: /freshpatchweb/customer_dashboard.php"); // <-- Fixed dash in filename
    exit();
}
// Insert new customer
$insertQuery = $con->prepare("INSERT INTO customers (fullname, email, password) VALUES (?, ?, ?)");
$insertQuery->bind_param("sss", $full_name, $email, $hashedPassword);

if ($insertQuery->execute()) {
    $_SESSION['customer_id'] = $insertQuery->insert_id;
    $_SESSION['customer_full_name'] = $full_name;

    echo "<p style='color: green; font-weight: bold;'>✅ Registration successful! Redirecting to your dashboard...</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'customer-dashboard.php';
        }, 2000);
    </script>";
    exit();
} else {
    echo "❌ Error: " . $insertQuery->error;
}

// Close connections
$checkQuery->close();
$insertQuery->close();
$con->close();
?>
