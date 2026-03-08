<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fresh Patch - Fresh Juice</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }

    header {
      background-color: #6ec072;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
    }

    header .logo-title {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    header img {
      height: 80px;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
      font-weight: bold;
      font-size: 14px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .full-width-banner {
      width: 100%;
      display: block;
      margin-bottom: 30px;
      max-height: 300px;
      object-fit: cover;
    }

    .product-list-section {
      max-width: 1100px;
      margin: 0 auto;
      padding: 30px 20px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }
.product-card p, .product-card h3 {
  font-size: 0.9rem;
}
    .product-card {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #fefefe;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .product-card img {
    width: 180px;
    height: 200px;
    object-fit: cover;
    border-radius: 15px;
    }
      #carrot-box, .peppers-box {
  height: 200px;
  width: 180px;
  overflow: hidden;
}
    .product-info {
      flex: 1;
    }

    .product-info h2 {
      margin: 4px 0;
      font-size: 15px;
      color: #2b572d;
    }

    .price {
      font-size: 16px;
      font-weight: bold;
      color: #228127;
      margin-bottom: 8px;
    }

    .product-info ul {
      list-style-type: disc;
      font-size: 14px;
      padding-left: 20px;
      margin-top: 5px;
    }

    .add-to-cart {
      padding: 10px 20px;
      background-color: #6ec072;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
    }

    .add-to-cart:hover {
      background-color: #45a049;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #6ec072;
      color: white;
    }

    footer img {
      height: 60px;
    }
    #carrot-box, .peppers-box {
  height: 200px;
  width: 180px;
  overflow: hidden;
}
  </style>
</head>
<body>

<header>
  <div class="logo-title">
    <img src="images/FP logo.png" alt="Fresh Patch Logo">
  </div>
  <nav>
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
    <img src="images/cart.png" width="30px" height="20px"> 
  </nav>
</header>

<img src="images/fruit banner.png" alt="Veggies Banner" class="full-width-banner">

<section class="product-list-section">
  <h1 style="text-align: center; margin-bottom: 40px;">FRESH COLD PRESSED JUICES</h1>
  <!-- Category Dropdown -->
<label for="product-category" style="font-weight: bold; font-size: 16px;">Browse Products:</label>
<select id="product-category" onchange="handleCategoryChange()" style="margin-left: 10px; padding: 5px;">
  <option value="">-- Select a Category --</option>
  <option value="veggies">Veggies</option>
  <option value="fruits">Fruits</option>
  <option value="juices">Juices</option>
  <option value="dairy">Dairy</option>
  <option value="marketplace">Marketplace</option>
</select>

<script>
  function handleCategoryChange() {
    const category = document.getElementById("product-category").value;
    if (category) {
      // redirect or load content dynamically
      window.location.href = category + ".html";
    }
  }
</script>
  <div class="product-grid">
    <div class="product-card">
      <img src="images/grjuice.png" alt="Cold Pressed Green Juice">
      <div class="product-info">
        <h2>Cold Pressed Green Juice</h2>
        <div class="price">R25</div>

        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>

        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
      <div class="product-card">
      <img src="images/ojjuice.png" alt= "Cold Pressed Orange Juice">
      <div class="product-info">
        <h2>Cold Pressed Orange Juice</h2>
        <div class="price">R25</div>

        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
      </div>
      <div class="product-card">
      <img src="images/freshfruitjuice.png" alt= "Fruit Jiuce">
      <div class="product-info">
        <h2>Karoo Fresh Co Cold Pressed Juice</h2>
        <div class="price">R25</div>

        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
      </div>
    <div class="product-card">
      <img src="images/mangojuice.png" alt="Mango Juice">
      <div class="product-info">
        <h2>Karoo Fresh Co Cold Pressed Mango Juice</h2>
        <div class="price">R20</div>

        <ul>
          <li>Washed & ready to eat</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>

    <div class="product-card">
      <img src="images/pinejuice.png" alt="Pineapple Juice">
      <div class="product-info">
        <h2>Karoo Fresh Co Cold Pressed Pineapple Juice</h2>
        <div class="price">R28</div>

        <ul>
        <li>Rich in vitamins</li>
      </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/applejuice.png" alt="Apple Juice">
      <div class="product-info">
        <h2>Karoo Fresh Co Cold Pressed Apple Juice</h2>
        <div class="price">R20</div>

        <ul>
          <li>Washed & ready to eat</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
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
  <div id="footer-placeholder"></div>
</footer>
<script>
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