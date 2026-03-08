<?php
session_start();
require 'db.php';

// Ensure only valid reset sessions access this file
if (!isset($_SESSION['reset_email'])) {
    die("❌ Unauthorized access. Please go through the reset process.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';

    // Check for empty password
    if (empty($new_password)) {
        die("❌ New password cannot be empty.");
    }

    // Hash the new password securely
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $email = $_SESSION['reset_email'];

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE suppliers SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
    unset($_SESSION['reset_email']);
    echo "<script>
      alert('✅ Password updated successfully.');
      window.location.href = 'supplier_login.php';
    </script>";
    exit();
}

    } else {
        echo "❌ Failed to update password. Please try again.";
    }

?>
