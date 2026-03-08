<?php
$conn = new mysqli("localhost", "root", "MyNewPass", "freshpatch", 3307);
if ($conn->connect_error) {
    die("Failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
