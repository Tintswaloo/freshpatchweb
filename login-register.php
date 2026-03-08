<?php include 'header.php'; ?>
<style>
  body {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%);
    min-height: 100vh;
    padding: 0 20px 40px 20px;
    margin: 0;
    font-family: 'Poppins', sans-serif;
  }

  .login-container {
    max-width: 450px;
    margin: 20px auto;
    animation: fadeInUp 0.6s ease-out;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .login-box {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    position: relative;
    overflow: hidden;
  }

  .login-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #6ec072 0%, #45a049 100%);
  }

  .home-link {
    display: inline-flex;
    align-items: center;
    color: #6ec072;
    text-decoration: none;
    font-size: 14px;
    margin-bottom: 20px;
    transition: color 0.3s;
    font-weight: 500;
  }

  .home-link:hover {
    color: #45a049;
    text-decoration: underline;
  }

  .login-box h1 {
    text-align: center;
    color: #2b572d;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
    letter-spacing: -0.5px;
  }

  .login-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    background: #f5f5f5;
    padding: 5px;
    border-radius: 12px;
  }

  .login-tab {
    flex: 1;
    padding: 12px 20px;
    border: none;
    background: transparent;
    color: #666;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
  }

  .login-tab:hover {
    color: #6ec072;
    background: rgba(110, 192, 114, 0.1);
  }

  .login-tab.active {
    background: #6ec072;
    color: white;
    box-shadow: 0 2px 8px rgba(110, 192, 114, 0.3);
  }

  .login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    animation: slideIn 0.4s ease-out;
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(-10px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .login-form.hidden {
    display: none;
  }

  .input-group {
    position: relative;
  }

  .input-group i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6ec072;
    font-size: 18px;
  }

  .login-form input {
    width: 100%;
    padding: 15px 15px 15px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.3s ease;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
  }

  .login-form input:focus {
    outline: none;
    border-color: #6ec072;
    background: white;
    box-shadow: 0 0 0 3px rgba(110, 192, 114, 0.1);
  }

  .login-form input::placeholder {
    color: #999;
  }

  .login-form button[type="submit"] {
    background: linear-gradient(135deg, #6ec072 0%, #45a049 100%);
    color: white;
    padding: 16px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(110, 192, 114, 0.3);
    font-family: 'Poppins', sans-serif;
    margin-top: 10px;
  }

  .login-form button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(110, 192, 114, 0.4);
    background: linear-gradient(135deg, #45a049 0%, #6ec072 100%);
  }

  .login-form button[type="submit"]:active {
    transform: translateY(0);
  }

  .success-message {
    background: #e8f5e9;
    color: #2e7d32;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid #4caf50;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideIn 0.4s ease-out;
  }

  .error-message {
    background: #ffebee;
    color: #c62828;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid #f44336;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideIn 0.4s ease-out;
  }

  .forgot-password {
    text-align: center;
    margin-top: 15px;
  }

  .forgot-password a {
    color: #6ec072;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.3s;
  }

  .forgot-password a:hover {
    color: #45a049;
    text-decoration: underline;
  }

  @media (max-width: 480px) {
    .login-box {
      padding: 30px 20px;
    }
    
    .login-box h1 {
      font-size: 28px;
    }
  }
</style>
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <a href="index.php" class="home-link">← Back to Home</a>

      <h1>🌱 Fresh Patch</h1>

      <div class="login-tabs">
        <button id="loginTab" class="login-tab active" onclick="showForm('login')">Login</button>
        <button id="registerTab" class="login-tab" onclick="showForm('register')">Register</button>
      </div>

      <!-- Success message -->
      <?php if (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
        <div class="success-message">
          <span>✅</span>
          <span>Registration successful! Please log in.</span>
        </div>
      <?php endif; ?>

      <!-- Error message -->
      <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
          <span>⚠️</span>
          <span>
            <?php
              if ($_GET['error'] === 'nouser') echo "No user found with this email.";
              elseif ($_GET['error'] === 'wrongpassword') echo "Incorrect password.";
              elseif ($_GET['error'] === 'emptyfields') echo "Please fill in all fields.";
            ?>
          </span>
        </div>
      <?php endif; ?>

      <!-- Login Form -->
      <form id="loginForm" action="login.php" method="POST" class="login-form">
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email address" required />
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <button type="submit">Login</button>
        <div class="forgot-password">
          <a href="#">Forgot password?</a>
        </div>
      </form>

      <!-- Register Form -->
      <form id="registerForm" action="register.php" method="POST" class="login-form hidden">
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="full_name" placeholder="Full Name" required />
        </div>
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email address" required />
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <button type="submit">Create Account</button>
      </form>
    </div>
  </div>

  <script>
    function showForm(type) {
      const loginForm = document.getElementById("loginForm");
      const registerForm = document.getElementById("registerForm");
      const loginTab = document.getElementById("loginTab");
      const registerTab = document.getElementById("registerTab");

      if (type === "login") {
        loginForm.classList.remove("hidden");
        registerForm.classList.add("hidden");
        loginTab.classList.add("active");
        registerTab.classList.remove("active");
      } else {
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
        loginTab.classList.remove("active");
        registerTab.classList.add("active");
      }
    }

    // Auto-show login tab if there's an error or success
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("error") || urlParams.get("success") === "registered") {
      showForm("login");
    }
  </script>
</body>
</html>
