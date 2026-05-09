<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in.
// If there is no logged-in user session,
// redirect them to the login page.
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Check if the form was submitted using POST method.
// This means the user submitted data from a form.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get product ID and quantity from the form.
    // (int) converts the value into an integer number.
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Get the logged-in user's ID from the session.
    $user_id = $_SESSION['user']['id'];

    // Validate quantity.
    // If quantity is less than 1, redirect with an error.
    // This prevents invalid quantities like 0 or negative numbers.
    if ($quantity < 1) {
        header("Location: ../pages/customer/products.php?error=invalid_quantity");
        exit;
    }

    // Check if the product exists in the database
    // and get its stock information.
    $check = $conn->prepare("SELECT id, stock_quantity, name FROM products WHERE id = ?");

    // Bind the product ID to the query.
    // "i" means integer.
    $check->bind_param("i", $product_id);

    // Execute the query.
    $check->execute();

    // Get the query result.
    $result = $check->get_result();

    // Fetch the product data as an associative array.
    $product = $result->fetch_assoc();

    // If no product is found,
    // redirect back with an error message.
    if (!$product) {
        header("Location: ../pages/customer/products.php?error=product_not_found");
        exit;
    }

    // Check if the requested quantity is greater
    // than the available stock.
    // If yes, stop the process and show an error.
    if ($quantity > $product['stock_quantity']) {
        header("Location: ../pages/customer/product_page.php?prod_id=$product_id&error=not_enough_stock");
        exit;
    }

    // Check if the product is already inside the user's cart.
    $cart_check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");

    // Bind user ID and product ID to the query.
    $cart_check->bind_param("ii", $user_id, $product_id);

    // Execute the query.
    $cart_check->execute();

    // Get the result from the query.
    $cart_result = $cart_check->get_result();

    // Fetch cart item if it exists.
    $cart_item = $cart_result->fetch_assoc();

    // If the product already exists in the cart,
    // update the quantity instead of adding a duplicate row.
    if ($cart_item) {

        // Add the new quantity to the existing quantity.
        $new_quantity = $cart_item['quantity'] + $quantity;

        // Check if the updated quantity exceeds stock.
        // Prevent users from ordering more than available stock.
        if ($new_quantity > $product['stock_quantity']) {
            header("Location: ../pages/customer/product_page.php?prod_id=$product_id&error=not_enough_stock");
            exit;
        }

        // Update the cart quantity in the database.
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");

        // Bind the updated quantity and cart ID.
        $update->bind_param("ii", $new_quantity, $cart_item['id']);

        // Execute the update query.
        $update->execute();

    } else {

        // If the product is not yet in the cart,
        // insert it as a new row in the cart table.
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");

        // Bind user ID, product ID, and quantity.
        $insert->bind_param("iii", $user_id, $product_id, $quantity);

        // Execute the insert query.
        $insert->execute();
    }

    // Redirect back to the product page
    // and show a success message.
    header("Location: ../pages/customer/product_page.php?prod_id=$product_id&success=added");
    exit;
}
?>