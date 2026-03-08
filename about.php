
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - Fresh Patch</title>
  <link rel="stylesheet" href="style.css">
  <a href="index.php"></a>
  <style>
    .about-section {
      max-width: 800px;
      margin: 60px auto;
      padding: 20px;
      background-color: #f9fff9;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      font-size: 18px;
      line-height: 1.6;
      color: #333;
    }

    .about-section h2 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #228127;
    }

    header {
      background-color: #6ec072;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
    }

    nav a {
      margin: 0 10px;
      font-weight: bold;
      color: white;
      text-decoration: none;
    }

    nav a:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #6ec072;
      color: white;
    }

    footer img {
      height: 80px;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
  <section class="about-section">
    <h2>About Fresh Patch</h2>
    <p>
      Fresh Patch is your local digital farmers' market. We work with trusted farmers to bring you the freshest fruits, vegetables, and dairy products — all delivered directly to your door.
    </p>
    <p>
      Our mission is to make healthy eating convenient, affordable, and accessible. Whether you're shopping for your weekly groceries or stocking up on seasonal produce, Fresh Patch makes it easy.
    </p>
    <p>
      We are based in South Africa and focus on sourcing from local farms to support small businesses and reduce environmental impact.
    </p>
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

</body>
</html>
