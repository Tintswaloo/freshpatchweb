<!-- supplier_forgot_password.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Supplier</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      background: #f2fff2;
      font-family: Arial, sans-serif;
    }

    .reset-container {
      max-width: 400px;
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

    label, input {
      display: block;
      width: 100%;
      margin-top: 15px;
    }

    input[type="email"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .reset-btn {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .reset-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <h2>Reset Password</h2>
    <form action="process_supplier_reset.php" method="POST">
      <label for="email">Enter your email</label>
      <input type="email" name="email" required>
      <button type="submit" class="reset-btn">Continue</button>
    </form>
  </div>
</body>
</html>
