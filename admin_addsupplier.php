<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $business_name = $_POST['business_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password_raw = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $status = $_POST['status'] ?? 'active';

    $fullname = $first_name . ' ' . $last_name;

    if ($first_name && $last_name && $email && $business_name && $password_raw) {
        $check_stmt = $conn->prepare("SELECT supplier_id FROM suppliers WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $error = "Supplier already exists.";
        } else {
            $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO suppliers (fullname, business_name, email, password, phone, address, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fullname, $business_name, $email, $hashed_password, $phone, $address, $status);

            if ($stmt->execute()) {
                $success = "Supplier added successfully.";
            } else {
                $error = "Failed to add supplier. Error: " . $stmt->error;
            }
        }

        $check_stmt->close();
    } else {
        $error = "All required fields must be filled.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Supplier</title>
    <style>
        body {
            font-family: Arial;
            padding: 30px;
            background: #f0f4f3;
        }

        form {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #4caf50;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .success {
            text-align: center;
            margin-top: 10px;
            color: green;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>➕ Add New Supplier</h2>

<form method="POST" action="">
    <label>First Name:</label>
    <input type="text" name="first_name" required>

    <label>Last Name:</label>
    <input type="text" name="last_name" required>

    <label>Phone Number:</label>
    <input type="text" name="phone" required>

    <label>Address:</label>
    <input type="text" name="address" required>

    <label>Email Address:</label>
    <input type="email" name="email" required>

    <label>Farm/Business Name:</label>
    <input type="text" name="business_name" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>Status:</label>
    <select name="status">
        <option value="active" selected>Active</option>
        <option value="inactive">Inactive</option>
    </select>

    <?php
    if (isset($success)) echo "<p class='success'>{$success}</p>";
    if (isset($error)) echo "<p class='error'>{$error}</p>";
    ?>

    <button type="submit">Add Supplier</button>
</form>

<a class="back-link" href="admin_dashboard.php">← Back to Admin Dashboard</a>

</body>
</html>
