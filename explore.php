<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Explore Our Story - Fresh Patch</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #e0f8e3, #f5fff6);
      overflow-x: hidden;
    }

    header {
      background-color: #6ec072;
      padding: 20px 40px;
      color: white;
      text-align: center;
    }

    .hero {
      text-align: center;
      padding: 60px 20px;
      animation: fadeIn 1s ease-out;
    }

    .hero h1 {
      font-size: 48px;
      color: #2b572d;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 20px;
      color: #555;
      max-width: 700px;
      margin: 0 auto;
    }

    .animated-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 60px 40px;
      gap: 40px;
      animation: slideUp 1s ease-out;
    }

    .animated-section:nth-child(even) {
      flex-direction: row-reverse;
    }

    .animated-section img {
      max-width: 50%;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .animated-section .text {
      flex: 1;
    }

    .animated-section .text h2 {
      color: #2b572d;
      margin-bottom: 15px;
    }

    .animated-section .text p {
      color: #333;
      font-size: 18px;
      line-height: 1.6;
    }

    footer {
      background-color: #6ec072;
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .animated-section {
        flex-direction: column !important;
      }

      .animated-section img {
        max-width: 100%;
      }
    }
    .dropdown {
  position: relative;
  display: inline-block;
}
.dropbtn {
  background-color: transparent;
  color: white;
  font-weight: bold;
  border: none;
  cursor: pointer;
  padding: 10px;
  font-size: 16px;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #6ec072;
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside dropdown */
.dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}


.show {
  display: block;
}
  </style>
</head>
  <div id="header-placeholder"></div>
  <header class="hero-header">
    <nav>
      <div style="margin-bottom: 20px; text-align: left; padding-left: 20px;">
  <img src="images/FP logo.png" style="height:80px;">
  <a href="home.html" style="color: white; text-decoration: none; font-weight: bold;">Home</a>
    <div class="dropdown">
  <button onclick="toggleDropdown()" class="dropbtn">Products</button>
  <div id="dropdownMenu" class="dropdown-content">
    <a href="products.html" style="color: white; text-decoration: none; font-weight: bold;">All Products</a>
    <a href="FPfavouritepicks.html">Favourite Picks</a>
    <a href="newarrivals.html">New Arrivals</a>
  </div>
</div>
    <a href="about.html" style="color: white; text-decoration: none; font-weight: bold;">About</a>
    <a href="contact.html" style="color: white; text-decoration: none; font-weight: bold;">Contact</a>
    <a href="login.html" style="color: white; text-decoration: none; font-weight: bold;">Login/Register</a>
</nav>
  </header>
  <body>
  </div>
    <h1>Explore Our Story</h1>
    <p>Discover what makes Fresh Patch truly fresh</p>
  <div style="text-align: center; margin-top: 20px;">
  <a href="home.html" style="text-decoration: none; background-color: #2b572d; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold;">
    ← Back to Home
  </a>
</div>

  <section class="hero">
    <h1>Rooted in Freshness</h1>
    <p>We began with a mission to bring truly fresh produce directly to your home—locally sourced, sustainably grown, and carefully packaged for your lifestyle.But it’s more than just delivering food. It’s about building a community that values health, supports local farmers, and celebrates the joy of eating well. Every item we offer is handpicked to ensure quality, freshness, and flavor you can trust.
From the soil to your doorstep, we’re committed to freshness you can feel, taste, and believe in—every single time.</p>
  </section>

  <section class="animated-section">
    <div class="text">
      <h2>Locally Grown Goodness</h2>
      <p>Our produce is handpicked from nearby farms, supporting local communities and ensuring peak freshness. Every box is a tribute to quality and care. By choosing local, we reduce environmental impact, shorten delivery times, and build strong relationships with farmers who share our values.
It’s about more than just great taste—it’s about knowing where your food comes from, how it’s grown, and the people behind it. With every bite, you’re investing in a healthier you and a thriving local economy.</p>
    </div>
    <img src="images/farm.png" alt="Farm Fresh">
  </section>

  <section class="animated-section">
    <div class="text">
      <h2>Sustainability First</h2>
      <p>We use eco-friendly packaging and support regenerative farming methods. Our impact matters, and we work every day to make it positive.</p>
    </div>
    <img src="images/sustainable.png" alt="Sustainable Practices">
  </section>

  <section class="animated-section">
    <div class="text">
      <h2>Our Happy Customers</h2>
      <p>Join thousands of satisfied customers who trust Fresh Patch for their weekly produce needs. Healthy eating starts with healthy choices—like us.</p>
    </div>
    <img src="images/happydeliveries.png" alt="Happy Customers">
  </section>

  <!-- Footer Section -->
<footer style="background: #6ec072; color: #eee; padding:15px; text-align: center; font-family:Impact, Haettenschweiler, 'Arial', sans-serif ;">

  <!-- Logo -->
  <div style="margin-bottom: 20px;">
    <img src="images/FP logo.png" alt="Fresh Patch Logo" style="height: 80px;">
  </div>

  <!-- Find us on text with space for logos -->
  <div style="margin-bottom: 15px; font-size: 18px; color: white;">
    Follow Us<br>
    <span style="margin-left: 10px; display: inline-flex; align-items: center; gap: 12px; justify-content: center;">
      <img src="images/insta logo.png" style="height: 35px;">
      
      <img src="images/fb logo.png" style="height: 35px;">
      
      <img src="images/tt logo.png" style="height: 35px;">
    </span>
  </div>
  <!-- Copyright -->
  <div style="font-size: 14px; color: white;">
    &copy; 2025 Fresh Patch. All rights reserved.
  </div>
</footer>
</div>
<script>
    fetch("header.html")
      .then(res => res.text())
      .then(data => document.getElementById("header-placeholder").innerHTML = data);

    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data);
      <!-- Products Button -->

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
