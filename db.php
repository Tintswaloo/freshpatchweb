<?php
// XAMPP default MySQL connection (usually no password)
$conn = new mysqli("localhost", "root", "", "freshpatch");

// If the above doesn't work, try with password:
// $conn = new mysqli("localhost", "root", "MyNewPass", "freshpatch");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
