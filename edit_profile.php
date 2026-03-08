<?php
session_start();
require 'db.php'; // Assumes $conn is a MySQLi connection

if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
  exit;
}

$customer_id = $_SESSION['customer_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username     = trim($_POST['username']);
  $email        = trim($_POST['email']);
  $phone        = trim($_POST['phone_number']);
  $address      = trim($_POST['home_address']);

  if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE customers SET username = ?, email = ?, phone_number = ?, home_address = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $email, $phone, $address, $password, $customer_id);
  } else {
    $stmt = $conn->prepare("UPDATE customers SET username = ?, email = ?, phone_number = ?, home_address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $email, $phone, $address, $customer_id);
  }

  if ($stmt->execute()) {
    $_SESSION['customer_name'] = $username; // Optional session update
    $message = "Profile updated successfully!";
  } else {
    $message = "❌ Failed to update profile.";
  }
}

// Fetch current data
$stmt = $conn->prepare("SELECT username, email, phone_number, home_address FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <style>
    form {
      max-width: 400px;
      margin: 40px auto;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    input {
      padding: 10px;
      font-size: 16px;
    }
    button {
      padding: 10px;
      background: green;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h2 style="text-align:center;">Edit Your Profile</h2>

<div style="text-align:center; margin-bottom: 20px;">
  <a href="home.php" style="display: inline-block; padding: 10px 20px; background:#4caf50; color:#fff; text-decoration:none; border-radius:5px; font-weight:600;">
    ← Return to Portal
  </a>
</div>

<?php if ($message): ?>
  <p style="text-align:center; color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
  <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($user['username']) ?>" required>
  <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
  <input type="text" name="phone_number" placeholder="Phone Number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
  <input type="text" name="home_address" placeholder="Home Address" value="<?= htmlspecialchars($user['home_address']) ?>" required>
  <input type="password" name="password" placeholder="New password (leave blank to keep current)">
  <button type="submit">Update Profile</button>
</form>

</body>
</html>
