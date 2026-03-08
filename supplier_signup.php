<?php
session_start();
require 'db_connection.php';

if (isset($_SESSION['supplier_id'])) {
    header("Location: supplier_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Supplier Signup - Fresh Patch</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0fff4;
      margin: 0;
      padding: 0;
    }

    .signup-container {
      max-width: 500px;
      margin: 60px auto;
      padding: 30px;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 40px;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
    }

    p {
      text-align: center;
      color: #2e7d32;
    }

    label {
      display: block;
      margin-top: 15px;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    .signup-btn {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .signup-btn:hover {
      background-color: #45a049;
    }

    .login-link {
      margin-top: 15px;
      text-align: center;
      display: block;
      color: #2e7d32;
      text-decoration: none;
    }

    .tc-btn {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .tc-btn:hover {
      background-color: #45a049;
      text-decoration: underline;
    }

    .error {
      color: #f44336;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <h1>BECOME A SUPPLIER TODAY</h1>
  <p>Do you want to sell your farm goods here on our platform? Follow the prompts below, easy as 1,2,3</p>

  <div class="signup-container">
    <h2>Supplier Sign Up</h2>
    <form id="supplierForm" action="process_signup.php" method="POST">
      <label for="fullname">Full Name*</label>
      <input type="text" id="fullname" name="fullname" required>
      <div id="fullname-error" class="error"></div>

      <label for="email">Email Address*</label>
      <input type="email" id="email" name="email" required>
      <div id="email-error" class="error"></div>

      <label for="phone">Phone Number*</label>
      <input type="tel" id="phone" name="phone" required>
      <div id="phone-error" class="error"></div>

      <label for="farmname">Business Name*</label>
      <input type="text" id="farmname" name="farmname" required>
      <div id="farmname-error" class="error"></div>

      <label for="password">Create Password*</label>
      <input type="password" id="password" name="password" required
        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
        title="Password must be at least 8 characters and include an uppercase letter, a lowercase letter, a number, and a special character.">
      <div id="password-error" class="error"></div>

      <button type="button" class="tc-btn" onclick="window.location.href='terms.html'">Supplier Terms & Conditions</button>
      <button type="submit" class="signup-btn">Sign Up</button>
    </form>
    <a href="supplier_login.php" class="login-link">Already have an account? Log in</a>
  </div>

  <div id="footer-placeholder"></div>
  <script src="script.js"></script>

  <script>
    // Header and footer loading
    fetch("header.html")
      .then(res => res.text())
      .then(data => document.getElementById("header-placeholder").innerHTML = data);

    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data);

    // Form validation
    document.getElementById('supplierForm').addEventListener('submit', function(e) {
      let valid = true;

      // Clear previous errors
      document.querySelectorAll('.error').forEach(el => el.textContent = '');

      // Validate email format
      const email = document.getElementById('email').value;
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('email-error').textContent = 'Please enter a valid email address';
        valid = false;
      }

      // Validate password strength
      const password = document.getElementById('password').value;
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/;

      if (!passwordRegex.test(password) || password.length < 8) {
        document.getElementById('password-error').textContent =
          'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
