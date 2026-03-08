<?php
// Suppress error display for production (remove in development if needed)
error_reporting(0);
ini_set('display_errors', 0);

session_start();
include "db.php";

// Check if connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products"; 
$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fresh Patch - Fruits</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
      display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
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
  flex-direction: row; /* Stack image and text vertically */
  justify-content: space-between;
  align-items: center;
  width: 250px;
  height: 100%;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #fefefe;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  text-align: center;
}
    .product-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 10px;
}
    .product-info {
      flex: 1;
      width: 100%;
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
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <h1 style="text-align: center; margin-bottom: 40px;">ALL PRODUCTS</h1>

  <!-- Category Dropdown -->
<label for="product-category" style="font-weight: bold; font-size: 16px;">Filter Products:</label>
<select id="product-category" onchange="handleCategoryChange()" style="margin-left: 10px; padding: 5px;">
  <option value="">-- Select a Category --</option>
  <option value="veggies">Veggies</option>
  <option value="fruits">Fruits</option>
  <option value="juices">Juices</option>
  <option value="dairy">Dairy</option>
  <option value="marketplace">Marketplace</option>
</select>

<div class="product-grid">
  <?php
  while($row = $result->fetch_assoc()){
?>
    <div class="product-card">
      <img src="images/<?php echo $row['image']?>" alt="Red Apples">
      <div class="product-info">
        <h2><?php echo $row['name']?></h2>
        <div class="price">R<?php echo $row['price']?></div>
      <p><?php echo $row['description']?></p>

       <form action="add_to_cart.php" method="post">
  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
  <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
  <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
  <input type="hidden" name="quantity" value="1">
  <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
</form>
      </div>
    </div>
  <?php 
  }
  ?>
  
</div>
  <div id="footer-placeholder"></div>

<script>
    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data);
      
      function handleCategoryChange() {
    const category = document.getElementById("product-category").value;
    if (category) {
      // Try .php first, fallback to .html
      window.location.href = category + ".php";
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