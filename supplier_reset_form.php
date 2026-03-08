<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    die("❌ Unauthorized access. Please start from the <a href='supplier_forgot_password.php'>Forgot Password</a> page.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password - Fresh Patch</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      background: #f2fff2;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .form-container {
      max-width: 450px;
      margin: 100px auto;
      padding: 30px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #2d572c;
    }

    label {
      display: block;
      margin-top: 15px;
      color: #333;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .submit-btn {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Set New Password</h2>

    <form action="process_supplier_new_password.php" method="POST">
  <label for="new_password">New Password</label>
  <input type="password" name="new_password" id="new_password" required
         pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
         title="At least 8 characters with uppercase, lowercase, number, and special character" />

  <label style="margin-top:10px;">
    <input type="checkbox" id="togglePassword"> Show Password
  </label>

  <button type="submit" class="submit-btn">Update Password</button>
</form>
  </div>

  <script>
    document.getElementById("new_password").addEventListener("input", function () {
      const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
      if (!pattern.test(this.value)) {
        this.setCustomValidity("Weak password: Use 8+ characters with uppercase, lowercase, number, and symbol.");
      } else {
        this.setCustomValidity("");
      }
    });
   document.getElementById("togglePassword").addEventListener("change", function () {
    const pwd = document.getElementById("new_password");
    pwd.type = this.checked ? "text" : "password";
  });
</script>
</body>
</html>

