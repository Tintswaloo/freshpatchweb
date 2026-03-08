<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit();
}

// Handle login
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // DB connection
    $conn = new mysqli("localhost", "root", "", "freshpatch");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Found user?
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $username;

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Admin not found";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial;
      background: #f1f1f1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 300px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2e7d32;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #4caf50;
      border: none;
      color: white;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    .error {
      color: red;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>
