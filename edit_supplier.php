<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

require 'db.php';

if (!isset($_GET['id'])) {
    die("Supplier ID missing.");
}

$supplier_id = (int)$_GET['id'];
$success = "";
$error = "";

// Fetch supplier info
$stmt = $conn->prepare("SELECT fullname, email, phone, business_name, status FROM suppliers WHERE supplier_id = ?");
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Supplier not found.");
}

$supplier = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $business_name = trim($_POST['business_name']);
    $status = $_POST['status'];

    // Simple validation
    if (!$fullname || !$email || !$phone || !$business_name || !$status) {
        $error = "All fields are required.";
    } else {
        $update = $conn->prepare("UPDATE suppliers SET fullname=?, email=?, phone=?, business_name=?, status=? WHERE supplier_id=?");
        $update->bind_param("sssssi", $fullname, $email, $phone, $business_name, $status, $supplier_id);
        if ($update->execute()) {
            $success = "Supplier updated successfully.";
            // Refresh supplier data
            $supplier = [
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'business_name' => $business_name,
                'status' => $status
            ];
        } else {
            $error = "Failed to update supplier: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Edit Supplier</title>
<style>
  body {
    font-family: Arial, sans-serif;
    padding: 30px;
    background: #f5f5f5;
    max-width: 600px;
    margin: auto;
  }
  h2 {
    color: #2e7d32;
    text-align: center;
  }
  form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px #ccc;
  }
  label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
  }
  input, select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 5px;
    border: 1px solid #aaa;
    font-size: 16px;
  }
  button {
    margin-top: 20px;
    background: #4caf50;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
  }
  .success {
    color: green;
    margin-top: 15px;
    font-weight: bold;
  }
  .error {
    color: red;
    margin-top: 15px;
    font-weight: bold;
  }
  a.back-link {
    display: block;
    text-align: center;
    margin-top: 25px;
    color: #2e7d32;
    font-weight: bold;
    text-decoration: none;
  }
  a.back-link:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<h2>Edit Supplier</h2>

<?php if ($success): ?>
  <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<?php if ($error): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
  <label for="fullname">Full Name</label>
  <input type="text" id="fullname" name="fullname" required value="<?= htmlspecialchars($supplier['fullname']) ?>">

  <label for="email">Email</label>
  <input type="email" id="email" name="email" required value="<?= htmlspecialchars($supplier['email']) ?>">

  <label for="phone">Phone</label>
  <input type="text" id="phone" name="phone" required value="<?= htmlspecialchars($supplier['phone']) ?>">

  <label for="business_name">Business Name</label>
  <input type="text" id="business_name" name="business_name" required value="<?= htmlspecialchars($supplier['business_name']) ?>">

  <label for="status">Status</label>
  <select id="status" name="status" required>
    <option value="pending" <?= $supplier['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
    <option value="approved" <?= $supplier['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
    <option value="rejected" <?= $supplier['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
  </select>

  <button type="submit">Save Changes</button>
</form>

<a class="back-link" href="admin_suppliers.php">← Back to Suppliers</a>

</body>
</html>
