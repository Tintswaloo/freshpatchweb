<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // leave blank unless you've set a password in phpMyAdmin
$dbname = 'freshpatch'; // this must match your actual database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
