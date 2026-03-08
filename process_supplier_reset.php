<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['reset_email'] = $email;
        header("Location: supplier_reset_form.php");
        exit();
    } else {
        echo "❌ No account found with that email. <a href='supplier_forgot_password.php'>Try again</a>";
    }
}
?>
