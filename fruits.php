<?php include 'header.php'; ?>
<style>
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
</style>

<img src="images/fruit banner.png" alt="Fruits Banner" class="full-width-banner">

<section class="product-list-section">
  <h1 style="text-align: center; margin-bottom: 40px;">FRESH FRUITS</h1>

  <!-- Category Dropdown -->
<label for="product-category" style="font-weight: bold; font-size: 16px;">Browse Products:</label>
<select id="product-category" onchange="handleCategoryChange()" style="margin-left: 10px; padding: 5px;">
  <option value="">-- Select a Category --</option>
  <option value="veggies">Veggies</option>
  <option value="fruits">Fruits</option>
  <option value="freshjuice">Juices</option>
  <option value="dairy">Dairy</option>
  <option value="marketplace">Marketplace</option>
</select>

<script>
  function handleCategoryChange() {
    const category = document.getElementById("product-category").value;
    if (category) {
      window.location.href = category + ".php";
    }
  }
</script>
  <div class="product-grid">
    <div class="product-card">
      <img src="images/redapple.jpg" alt="Red Apples">
      <div class="product-info">
        <h2>Top Red Apples 1.5kg</h2>
        <div class="price">R25</div>
        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/greenapples.jpg" alt="Green Apples">
      <div class="product-info">
        <h2>Granny Smith Apples</h2>
        <div class="price">R25</div>
        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/bananas.jpg" alt="Bananas">
      <div class="product-info">
        <h2>Fresh Bananas</h2>
        <div class="price">R25</div>
        <ul>
          <li>Organic</li>
          <li>Locally grown</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/wgrapes.jpg" alt="White Grapes">
      <div class="product-info">
        <h2>Seedless White Grapes</h2>
        <div class="price">R20</div>
        <ul>
          <li>Washed & ready to eat</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/lemons.png" alt="Lemons">
      <div class="product-info">
        <h2>Citrus Lemons 850g</h2>
        <div class="price">R28</div>
        <ul>
          <li>Rich in vitamins</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/redgrapes.jpg" alt="Seedless Red Grapes">
      <div class="product-info">
        <h2>Seedless Red Grapes</h2>
        <div class="price">R20</div>
        <ul>
          <li>Washed & ready to eat</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/pineapple.jpg" alt="Juicy Pineapple">
      <div class="product-info">
        <h2>Juicy Pineapple</h2>
        <div class="price">R15</div>
        <ul>
          <li>Farm fresh</li>
          <li>Hydrating</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/oranges.jpg" alt="Oranges">
      <div class="product-info">
        <h2>Oranges</h2>
        <div class="price">R15</div>
        <ul>
          <li>Farm fresh</li>
          <li>Hydrating</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <div class="product-card">
      <img src="images/tomatoes.jpg" alt="Tomatoes">
      <div class="product-info">
        <h2>Juicy Tomatoes</h2>
        <div class="price">R15</div>
        <ul>
          <li>Farm fresh</li>
          <li>Hydrating</li>
        </ul>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
  </div>
</section>

<div id="footer-placeholder"></div>

<script>
    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer-placeholder").innerHTML = data)
      .catch(err => console.error("Footer load error:", err));
</script>
</body>
</html>
