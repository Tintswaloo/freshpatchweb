<?php 
session_start();

// Redirect to login if admin not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['action'])) {
    $supplier_id = (int) $_POST['id'];
    $action = $_POST['action'];

    // Only allow 'approve' or 'reject' actions
    if (!in_array($action, ['approve', 'reject'])) {
        die("Invalid action.");
    }

    // Translate action to status value
    $new_status = $action === 'approve' ? 'approved' : 'rejected';

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "freshpatch");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update supplier status
    $stmt = $conn->prepare("UPDATE suppliers SET status = ? WHERE supplier_id = ?");
    $stmt->bind_param("si", $new_status, $supplier_id);

    if ($stmt->execute()) {
        // Success — redirect back
        header("Location: admin_suppliers.php");
        exit();
    } else {
        echo "❌ Error: Could not update status.";
    }

    // Close resources
    $stmt->close();
    $conn->close();
} else {
    echo "❌ Invalid request.";
}
