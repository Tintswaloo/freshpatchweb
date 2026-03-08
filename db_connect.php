<?php
$servername = "localhost";
$username = "root";        
$password = "MyNewPass";           
$dbname = "Fresh_Patch";   

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
