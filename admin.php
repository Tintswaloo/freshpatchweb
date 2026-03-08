<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

require 'db.php';

// Admin credentials
$admin_email = "admin@site.com";
$admin_pass = "admin123";

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['admin'])) {
    if ($_POST['email'] === $admin_email && $_POST['password'] === $admin_pass) {
        $_SESSION['admin'] = true;
    } else {
        $error = "❌ Invalid admin credentials.";
    }
}

// HTML starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Fresh Patch</title>
    <link rel="stylesheet" href="style.css">  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f9f4;
            padding: 30px;
        }

        .admin-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #3a9a5d;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }

        button {
            background-color: #3a9a5d;
            color: white;
            border: none;
            font-weight: 600;
        }

        button:hover {
            background-color: #328c50;
        }

        .logout-link {
            color: red;
            float: right;
            font-size: 14px;
        }

        ul {
            padding-left: 18px;
        }

        li {
            margin-bottom: 10px;
            background: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-form, .product-list {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php if (!isset($_SESSION['admin'])): ?>
            <h2>🔐 Admin Login</h2>
            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
            <form method="POST">
                <label>Email:
                    <input type="email" name="email" required>
                </label>
                <label>Password:
                    <input type="password" name="password" required>
                </label>
                <button type="submit">Login as Admin</button>
            </form>
        <?php else: ?>
            <h2>🛒 Admin Dashboard</h2>
            <a class="logout-link" href="admin.php?logout=true">🚪 Logout</a>

            <!-- Product Form -->
            <div class="product-form">
                <h3>➕ Add New Product</h3>
                <form method="POST" action="add_product.php" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Product Name" required>
                    <input type="number" name="price" placeholder="Price" step="0.01" required>
                    <textarea name="description" placeholder="Product Description" rows="4"></textarea>
                    <input type="file" name="image">

                    <!-- Supplier Dropdown -->
                    <?php $suppliers = $conn->query("SELECT * FROM suppliers"); ?>
                    <select name="supplier_id" required>
                        <option value="">-- Select Supplier --</option>
                        <?php while ($s = $suppliers->fetch_assoc()): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['store']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <button type="submit">Add Product</button>
                </form>
            </div>

                <a href="manage_products.php" class="button">📋 Manage Products</a><br><br>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
