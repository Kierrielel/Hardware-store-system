<?php
// Start the session so we can access user login data
session_start();

// Connect to the database
include 'db_connect.php';

// Check if the user is logged in
// If not, redirect them to the login page
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user']['id'];

// Get the cart item ID and action (increase or decrease) from the form
$cart_id = (int)$_POST['cart_id'];
$action = $_POST['action'];


// --------------------------------------------------
// FETCH CURRENT CART ITEM AND PRODUCT STOCK
// --------------------------------------------------
// This query gets:
// 1. The current quantity of the item in the cart
// 2. The available stock of that product
// It ensures the cart item belongs to the logged-in user
$stmt = $conn->prepare("SELECT cart.quantity, products.stock_quantity 
                         FROM cart 
                         JOIN products ON cart.product_id = products.id 
                         WHERE cart.id = ? AND cart.user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

// If no item is found (invalid cart ID or not owned by user),
// redirect back to the cart page
if (!$item) {
    header("Location: ../pages/customer/cart.php");
    exit;
}

// Store the current quantity in a variable
$new_quantity = $item['quantity'];


// --------------------------------------------------
// HANDLE USER ACTION (INCREASE OR DECREASE QUANTITY)
// --------------------------------------------------
// If the user clicks "increase"
if ($action === 'increase') {

    // Only increase if stock is still available
    if ($new_quantity < $item['stock_quantity']) {
        $new_quantity++;
    }

// If the user clicks "decrease"
} elseif ($action === 'decrease') {

    // Reduce the quantity by 1
    $new_quantity--;
}


// --------------------------------------------------
// UPDATE OR DELETE CART ITEM BASED ON NEW QUANTITY
// --------------------------------------------------
// If the quantity becomes 0 or less,
// remove the item from the cart completely
if ($new_quantity <= 0) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();

} else {

    // Otherwise, update the cart with the new quantity
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $new_quantity, $cart_id, $user_id);
    $stmt->execute();
}


// --------------------------------------------------
// REDIRECT BACK TO CART PAGE
// --------------------------------------------------
// After updating or deleting, send the user back to the cart page
header("Location: ../pages/customer/cart.php");
exit;
?>