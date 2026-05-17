<?php
// Start session
session_start();

// Connect to database
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Get user ID and cart ID
$user_id = $_SESSION['user']['id'];
$cart_id = (int)$_GET['cart_id'];

// Delete item from user's cart
$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();

// Redirect back to cart
header("Location: ../pages/customer/cart.php");
exit;
?>