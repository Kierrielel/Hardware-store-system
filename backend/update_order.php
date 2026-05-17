<?php
// Start session
session_start();

// Connect to database
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get order ID and status
    $order_id = (int)$_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Allowed status values
    $allowed = ['pending', 'processing', 'completed', 'cancelled'];

    // Check if status is valid
    if (!in_array($order_status, $allowed)) {
        header("Location: ../pages/admin/orders.php?error=invalid_status");
        exit;
    }

    // Update order status
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    $stmt->bind_param("si", $order_status, $order_id);

    // If update is successful
    if ($stmt->execute()) {

        // Redirect based on source
        if(isset($_POST['redirect']) && $_POST['redirect'] === 'order_details') {
            header("Location: ../pages/admin/order_details.php?id=$order_id&success=1");
        } else {
            header("Location: ../pages/admin/orders.php?success=status_updated");
        }
        exit;
    }
}
?>