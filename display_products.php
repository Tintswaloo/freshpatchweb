<?php
$conn = new mysqli("localhost", "root", "MyNewPass", "freshpatch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='product-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='product-card'>
            <img src='images/{$row['image']}' alt='{$row['name']}' />
            <h3>{$row['name']}</h3>
            <p>{$row['description']}</p>
            <p>Price: R{$row['price']}</p>
            <form action='add_to_cart.php' method='post'>
                <input type='hidden' name='product_id' value='{$row['id']}'>
                <input type='number' name='quantity' value='1' min='1'>
                <button type='submit'>Add to Cart</button>
            </form>
        </div>
        ";
    }
    echo "</div>";
} else {
    echo "No products found.";
}

$conn->close();
?>
