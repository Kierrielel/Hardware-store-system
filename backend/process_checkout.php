<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get user ID and total amount
    $user_id = $_SESSION['user']['id'];
    $total_amount = $_POST['total_amount'];

    // Get user's cart items with stock and price
    $cart_check = $conn->prepare("SELECT cart.*, products.stock_quantity, products.price
                               FROM cart 
                               JOIN products ON cart.product_id = products.id
                               WHERE cart.user_id = ?");
    $cart_check->bind_param("i", $user_id);
    $cart_check->execute();
    $cart_result = $cart_check->get_result();

    // If cart is empty, go back
    if($cart_result->num_rows === 0) {
        header("Location: ../pages/customer/cart.php");
        exit;
    }

    // Create new order
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_status) VALUES (?, ?, 'pending')");
    $order_stmt->bind_param("id", $user_id, $total_amount);
    $order_stmt->execute();

    // Get new order ID
    $order_id = $conn->insert_id;

    // Save each cart item
    while($item = $cart_result->fetch_assoc()) {

        // Insert into order_items
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $item_stmt->execute();

        // Update product stock
        $stock_stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
        $stock_stmt->bind_param("ii", $item['quantity'], $item['product_id']);
        $stock_stmt->execute();
    }

    // Clear user's cart
    $clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear->bind_param("i", $user_id);
    $clear->execute();

    // Redirect after success
    header("Location: ../pages/customer/cart.php?success=order_placed");
    exit;
}
?>