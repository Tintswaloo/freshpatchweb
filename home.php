<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset ="UTF-8">
        <title>Fresh Patch | Ecommerce Website Design</title>
<link rel="stylesheet" href="style.css">  
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    #productFilter {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    #productGrid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 20px;
    }

    .product-item {
      background: #f0f0f0;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      font-size: 18px;
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

/* Show the dropdown on click */
.show {
  display: block;
}
</style>
 </head>
  <body>
    <div id="header-placeholder"></div>


</div>
<div class="row">
    <div class="col-2">
<h1>Fresh Patch – Where Fresh Starts Local!</h1>
<p>Discover the heart of your community at Fresh Patch – your online farmers market. <br>We make it easy to shop fresh, local, and seasonal goods from trusted growers and artisans near you.<br>From crisp veggies to handcrafted treats, everything you need is just a click away.<br> Support local. Eat better. Live fresh.<br></p>
<h2><b>DAILY FRESH GOODS DELIVERED TO YOUR HOME<h2></b>
 <a href="explore.php" class="explore-btn">Explore Our Story</a>
    </div>
    <div class="col-2">
        <img src="images/pic1.jpg">
        </div>
</div>
</div>
    <!-- Products Section -->
  <div class="small-container">
    <h2 style="text-align:center; margin: 20px 0;"></h2>

    <h1>FEATURED PRODUCTS</h1>
       <div class="product-grid">
    <div class="box-container">
    <div class="box-card">
        <h3>FRESH BOX OPTION 1<br>(R500)</h3>
         <p>Fresh Fruit and Veggies delivered to you!</p>
         <img src="images/option1.png">
          <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
    </div>
     <div class="box-card">
      <h3>FRESH BOX OPTION 2<br>(R500)</h3>
      <p>Fresh Fruit and Veggies delivered to you!</p>
      <img src="images/option2.png">
      <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
</div>

      <div class="box-card">
      <h3>FRESH BOX OPTION 3<br>(R400)</h3>
      <p>Fresh Fruit and Veggies delivered to you!</p>
      <img src="images/option3.png">
      <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
</div>
    <div class="box-card">
      <h3><br>FRESH BOX OPTION 4<br>(R400)</h3>
      <p>Fresh Fruit and Veggies delivered to you!</p>
      <img src="images/option4.png">
      <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
      </div>
    <div class="box-card">
      <h3><br>FRESH BOX OPTION 5<br>(R400)</h3>
      <p>Fresh Fruit and Veggies delivered to you!</p>
      <img src="images/option5.png">
      <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
</div>
<div class="box-card">
      <h3><br>FRESH BOX OPTION 6<br>(R400)</h3>
      <p>Fresh Fruit and Veggies delivered to you!</p>
      <img src="images/option6.png">
      <a href="freshboxoptions.html" class="shop-btn">Shop Now ➜</a>
</div>
<section class="info-section">
  <div class="info-box">
    <i class="fa fa-car"></i>
    <h3>Reliable Delivery to Your Door</h3>
    <p>Delivery to your door</p>
  </div>
  <div class="info-box">
    <i class="fa fa-money-bill-wave"></i>
    <h3>Huge Savings</h3>
    <p>Products at the lowest price</p>
  </div>
  <div class="info-box">
    <i class="fa fa-heart"></i>
    <h3>Locally Sourced Goodness</h3>
    <p>100% Guarantee</p>
  </div>
</section>
</div>
<!-- Customer Reviews Section -->
<section id="customerReviews" style="padding-top: 100px; padding:40px 20px; background: #f9f9f9; text-align: center;">
  <h2 style="font-family: Arial, sans-serif; color: #333;">What Our Customers Say</h2>
  <div style="max-width: 1000px; margin: 20px auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <div style="background: white; padding: 20px; border-radius: 50px ; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
      <p>"Fresh Patch delivers fresh veggies every time. Love their reliable service!"</p>
      <div style="color: #f5b301; font-size: 20px; margin-bottom: 8px;">
        ★★★★☆
      </div>
      <strong>Thando. M.</strong>
    </div>

    <div style="background: white; padding: 20px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
      <p>"Great quality and quick delivery. Highly recommend for local produce. Oh and they deliver same day!"</p>
      <div style="color: #f5b301; font-size: 20px; margin-bottom: 8px;">
        ★★★★★
      </div>
      <strong>Jabulani K.</strong>
    </div>

    <div style="background: white; padding: 20px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
      <p>"Customer service is friendly and helpful. Fresh Patch is my go-to now!"</p>
      <div style="color: #f5b301; font-size: 20px; margin-bottom: 8px;">
        ★★★☆☆
      </div>
      <strong>Bianca M.</strong>
    </div>
</section>
  </div>
</section>
 <!-- Footer Section -->
<div id="footer-placeholder"></div>
<script src="script.js"></script>
      </body>
      </html>
