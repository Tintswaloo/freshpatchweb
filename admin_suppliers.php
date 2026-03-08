<?php
session_start();

// Block non-admins
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "freshpatch");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch suppliers with status
$sql = "SELECT supplier_id, fullname, email, phone, business_name, created_at, status FROM suppliers ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Suppliers</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f1f8e9;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #2e7d32;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #a5d6a7;
      color: #2e7d32;
    }

    tr:nth-child(even) {
      background-color: #f9fbe7;
    }

    .actions form {
      display: inline;
    }

    .actions button {
      padding: 6px 12px;
      margin-right: 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .approve {
      background-color: #4caf50;
      color: white;
    }

    .reject {
      background-color: #f44336;
      color: white;
    }

    .status {
      font-weight: bold;
      text-transform: capitalize;
    }

    .back {
      display: block;
      margin: 20px auto;
      text-align: center;
      text-decoration: none;
      color: #2e7d32;
      font-weight: bold;
    }
    .actions form {
  display: inline;
  margin-right: 5px;
}
.approve {
  background-color: #4CAF50; /* green */
  color: white;
}
.reject {
  background-color: #f44336; /* red */
  color: white;
}
  </style>
</head>
<body>
  <h1>Registered Suppliers</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Farm Name</th>
        <th>Registered On</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['supplier_id'] ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['business_name']) ?></td>
          <td><?= $row['created_at'] ?></td>
          <td class="status"><?= htmlspecialchars($row['status']) ?></td>
          <td class="actions">
            <form method="POST" action="admin_update_supplier.php">
              <input type="hidden" name="id" value="<?= $row['supplier_id'] ?>">
              <input type="hidden" name="action" value="approve">
              <button type="submit" class="approve">Approve</button>
            </form>
            <form method="POST" action="admin_update_supplier.php">
              <input type="hidden" name="supplier_id" value="<?= $row['supplier_id'] ?>">
              <input type="hidden" name="action" value="reject">
              <button type="submit" class="reject">Reject</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p style="text-align: center;">No suppliers found.</p>
  <?php endif; ?>

  <a class="back" href="admin_dashboard.php">← Back to Dashboard</a>
</body>
</html>

<?php $conn->close(); ?>
