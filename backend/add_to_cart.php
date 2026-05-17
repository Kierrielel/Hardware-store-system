<?php
session_start();
include 'db_connect.php';

// Check login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Get user ID
    $user_id = $_SESSION['user']['id'];

    // Check quantity
    if ($quantity < 1) {
        header("Location: ../pages/customer/products.php?error=invalid_quantity");
        exit;
    }

    // Check product stock
    $check = $conn->prepare("SELECT id, stock_quantity, name FROM products WHERE id = ?");
    $check->bind_param("i", $product_id);
    $check->execute();

    // Get product data
    $result = $check->get_result();
    $product = $result->fetch_assoc();

    // Redirect if product not found
    if (!$product) {
        header("Location: ../pages/customer/products.php?error=product_not_found");
        exit;
    }

    // Check stock availability
    if ($quantity > $product['stock_quantity']) {
        header("Location: ../pages/customer/product_page.php?prod_id=$product_id&error=not_enough_stock");
        exit;
    }

    // Check existing cart item
    $cart_check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $cart_check->bind_param("ii", $user_id, $product_id);
    $cart_check->execute();

    // Get cart item
    $cart_result = $cart_check->get_result();
    $cart_item = $cart_result->fetch_assoc();

    // Update quantity if item exists
    if ($cart_item) {

        // Add quantity
        $new_quantity = $cart_item['quantity'] + $quantity;

        // Check stock limit
        if ($new_quantity > $product['stock_quantity']) {
            header("Location: ../pages/customer/product_page.php?prod_id=$product_id&error=not_enough_stock");
            exit;
        }

        // Update cart
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $new_quantity, $cart_item['id']);
        $update->execute();

    } else {

        // Add new cart item
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $user_id, $product_id, $quantity);
        $insert->execute();
    }

    // Redirect after success
    header("Location: ../pages/customer/product_page.php?prod_id=$product_id&success=added");
    exit;
}
?>