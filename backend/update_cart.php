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

// Get user ID, cart ID, and action
$user_id = $_SESSION['user']['id'];
$cart_id = (int)$_POST['cart_id'];
$action = $_POST['action'];

// Get current cart quantity and stock
$stmt = $conn->prepare("SELECT cart.quantity, products.stock_quantity 
                         FROM cart 
                         JOIN products ON cart.product_id = products.id 
                         WHERE cart.id = ? AND cart.user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

// If item not found, go back
if (!$item) {
    header("Location: ../pages/customer/cart.php");
    exit;
}

// Set current quantity
$new_quantity = $item['quantity'];

// Handle increase/decrease
if ($action === 'increase') {

    // Increase if stock allows
    if ($new_quantity < $item['stock_quantity']) {
        $new_quantity++;
    }

} elseif ($action === 'decrease') {

    // Decrease quantity
    $new_quantity--;
}

// Delete if quantity is 0 or less
if ($new_quantity <= 0) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();

} else {

    // Update cart quantity
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $new_quantity, $cart_id, $user_id);
    $stmt->execute();
}

// Redirect back to cart
header("Location: ../pages/customer/cart.php");
exit;
?>