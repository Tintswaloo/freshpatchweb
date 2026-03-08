<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Supplier Login - Fresh Patch</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2fff2;
      margin: 0;
      padding: 0;
    }

    .login-container {
      max-width: 400px;
      margin: 80px auto;
      padding: 30px;
      background-color: white;
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

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .login-btn {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    .login-btn:hover {
      background-color: #45a049;
    }

    .signup-link {
      margin-top: 15px;
      text-align: center;
      display: block;
      color: #2d572c;
      text-decoration: none;
    }

    .signup-link:hover {
      text-decoration: underline;
    }
  </style>
  </style>
  <div id ="header-placeholder"></div>
<body>

  <div class="login-container">
    <h2>Supplier Login</h2>
    <form action="supplier_dashboard.html" method="GET">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" class="login-btn">Login</button>
    </form>
    <a href="supplier_signup.html" class="signup-link">Don't have an account? Sign up</a>
  </div>
</section>
  <div id="footer-placeholder"></div>
<script>
 fetch("header.html")
      .then(res => res.text())
      .then(data => document.getElementById("header-placeholder").innerHTML = data);

    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data);
      <!-- Products Button -->
      
      function handleCategoryChange() {
    const category = document.getElementById("product-category").value;
    if (category) {
      // redirect or load content dynamically
      window.location.href = category + ".html";
    }
  }
      function toggleDropdown() {
    document.getElementById("dropdownMenu").classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
  </script>
</body>
</html>