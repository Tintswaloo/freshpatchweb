<?php include 'header.php'; ?>
<style>
    .image-box {
      width: 800px;    
      height: 200px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }
    .center-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 50px 20px;
    }
    h2 {
      color: #2b7a2b;
      font-weight: bold;
      margin-bottom: 20px;
      align-items: center;
    }
    .image-box img {
      max-width: 300%;
      height: 100%;
      border-radius: 8px;
      align-items: center;
  }
      /*object-fit: contain;*/
  
    .contact-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      max-width: 1200px;
      margin: 50px auto;
      padding: 20px;
    }
    .contact-form, .contact-info {
      flex: 1 1 500px;
      background: #f9fff9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .contact-form h2, .contact-info h2 {
      color: #228127;
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-group {
      display: flex;
      gap: 20px;
      margin-bottom: 15px;
    }

    .form-group input {
      flex: 1;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .query-types {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 15px;
    }

    .query-types label {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .store-select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
    }

    .submit-button {
      background-color: #6ec072;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    .submit-button:hover {
      background-color: #45a049;
    }

    .contact-info h3 {
      margin-bottom: 10px;
      color: #333;
    }

    .contact-info p {
      margin: 6px 0;
    }

    .contact-info a {
      color: #228127;
      text-decoration: none;
      font-weight: bold;
    }
</style>
</head>
<body>
  <div class="contact-wrapper">
    <div class="contact-form">
      <h2><strong>CUSTOMER</strong> SERVICE</h2>
      <div class="image-box">
  <img src="images/fpworkers.png" alt="Fresh Patch Team">
</div>


      <div class="form-group">
        <input type="text" placeholder="First Name (Required)">
        <input type="text" placeholder="Last Name (Required)">
      </div>
      <div class="form-group">
        <input type="email" placeholder="Email (Required)">
        <input type="text" placeholder="Mobile (Required)">
      </div>

      <div class="query-types">
        <label><input type="radio" name="query"> Compliment</label>
        <label><input type="radio" name="query"> Complaint</label>
        <label><input type="radio" name="query"> General</label>
      </div>

      <select class="store-select">
        <option>Select Location (Required)</option>
        <option>Midrand</option>
        <option>Vaal</option>
      </select>

      <button class="submit-button">Submit</button>
    </div>

    <div class="contact-info">
      <h2>CONTACT <strong>HEAD OFFICE</strong></h2>

      <h3>📍Address</h3>
      <p>Raine Avenue</p>
      <p>Raine Business Park</p>
      <p>Midrand</p>
      <p>1682</p>

      <h3>📞Contact Numbers</h3>
      <p>Reception <strong>081 140 9600</strong></p>
      <p>Customer Care <strong>062 369 6254</strong></p>

      <h3>✉️Email Address</h3>
      <p>hello@freshpatch.co.za</p>
    </div>
  </div>
<section style="background-color: #f9fff9; padding: 40px 20px; text-align: center;">
  <h2 style="color: #228127;"><strong>QUICK</strong> LINKS</h2>
  <p style="font-size: 16px; color: #444;">
    To view our Frequently Asked Questions, visit our
    <a href="faq.html" style="color: #228127; font-weight: bold;">FAQ page</a>.
  </p>
  <p style="font-size: 16px; color: #444;">
    To learn more about our team or where your food comes from, check out our
    <a href="about.html" style="color: #228127; font-weight: bold;">About page</a>.
  </p>
  <p style="font-size: 16px; color: #444;">
    Want to become a supplier? check out our
    <a href="supplier_signup.html" style="color: #228127; font-weight: bold;"> Become a Supplier page</a>.
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
  </div>
</footer>
</body>
</html>

