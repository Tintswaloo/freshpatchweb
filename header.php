<?php
// Start session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the cart from session
$cart = $_SESSION['cart'] ?? [];

// Count total quantity
$cartCount = 0;
foreach ($cart as $item) {
    $cartCount += $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Fresh Patch</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <header style="background-color: #6ec072; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
    <div style="display: flex; align-items: center; gap: 10px;">
      <img src="images/FP logo.png" alt="Fresh Patch Logo" style="height: 80px;">
    </div>

    <nav style="display: flex; gap: 10px;">
      <a href="home.php" style="color: white; text-decoration: none; font-weight: bold;">Home</a>
      <div class="dropdown">
        <button onclick="toggleDropdown()" class="dropbtn">Products</button>
        <div id="dropdownMenu" class="dropdown-content">
          <a href="products.php">All Products</a>
          <a href="FPfavouritepicks.html">Favourite Picks</a>
          <a href="newarrivals.html">New Arrivals</a>
        </div>
      </div>
      <a href="about.php" style="color: white; text-decoration: none; font-weight: bold;">About</a>
      <a href="contact.php" style="color: white; text-decoration: none; font-weight: bold;">Contact</a>
      <a href="login-register.php" style="color: white; text-decoration: none; font-weight: bold;">Login/Register</a>
    </nav>

    <div class="cart-icon" style="position: relative; display: inline-block;">
      <a href="view_cart.php" style="position: relative; display: inline-block;">
        <i style="color: white; font-size: 24px;" class="fa-solid fa-cart-shopping"></i>
        <?php if ($cartCount > 0): ?>
        <span style="position: absolute; top: -5px; right: -8px; background-color: red; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"><?= $cartCount ?></span>
        <?php endif; ?>
      </a>
    </div>
  </header>

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
