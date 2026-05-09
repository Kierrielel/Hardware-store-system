<?php
session_start();
include 'db_connect.php';

/*
---------------------------------------------------
CHECK IF USER IS LOGGED IN
---------------------------------------------------
This checks if a user is logged in.

Why?
Only logged-in users should be allowed
to place an order.

If no session exists, redirect the user
to the login page.
*/
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}


/*
---------------------------------------------------
CHECK IF FORM WAS SUBMITTED
---------------------------------------------------
This checks if the request method is POST.

POST means data was sent through a form,
such as clicking the "Place Order" button.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the logged-in user's ID.
    $user_id = $_SESSION['user']['id'];

    // Get the total amount submitted from the form.
    $total_amount = $_POST['total_amount'];


    /*
    ---------------------------------------------------
    GET USER'S CART ITEMS
    ---------------------------------------------------
    This query gets all products inside the
    logged-in user's cart.

    It also joins the products table to get:
    - stock quantity
    - product price

    JOIN combines data from cart and products.
    */
    $cart_check = $conn->prepare("SELECT cart.*, products.stock_quantity, products.price
                               FROM cart 
                               JOIN products ON cart.product_id = products.id
                               WHERE cart.user_id = ?");

    // Bind the user ID to the query.
    $cart_check->bind_param("i", $user_id);

    // Execute the query.
    $cart_check->execute();

    // Get the query result.
    $cart_result = $cart_check->get_result();


    /*
    ---------------------------------------------------
    CHECK IF CART IS EMPTY
    ---------------------------------------------------
    If the user has no items in the cart,
    redirect them back to the cart page.

    This prevents empty orders from being placed.
    */
    if($cart_result->num_rows === 0) {
        header("Location: ../pages/customer/cart.php");
        exit;
    }


    /*
    ---------------------------------------------------
    CREATE A NEW ORDER
    ---------------------------------------------------
    Insert a new row into the orders table.

    order_status is automatically set to "pending"
    because the admin still needs to process it.
    */
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_status) VALUES (?, ?, 'pending')");

    // Bind user ID and total amount.
    // "i" = integer
    // "d" = decimal/double
    $order_stmt->bind_param("id", $user_id, $total_amount);

    // Execute insert query.
    $order_stmt->execute();

    // Get the ID of the newly created order.
    // This is important for linking order items.
    $order_id = $conn->insert_id;


    /*
    ---------------------------------------------------
    SAVE EACH CART ITEM TO ORDER ITEMS
    ---------------------------------------------------
    Loop through every item in the cart.

    Each product will be saved in the
    order_items table.
    */
    while($item = $cart_result->fetch_assoc()) {

        /*
        Insert each product into order_items.

        This stores:
        - order ID
        - product ID
        - quantity
        - product price
        */
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

        // Bind values to query.
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);

        // Execute insert query.
        $item_stmt->execute();


        /*
        ---------------------------------------------------
        UPDATE PRODUCT STOCK
        ---------------------------------------------------
        Reduce the stock quantity after ordering.

        Example:
        Stock = 20
        Ordered = 3
        New stock = 17
        */
        $stock_stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");

        // Bind quantity and product ID.
        $stock_stmt->bind_param("ii", $item['quantity'], $item['product_id']);

        // Execute stock update query.
        $stock_stmt->execute();
    }


    /*
    ---------------------------------------------------
    CLEAR USER CART
    ---------------------------------------------------
    After the order is placed successfully,
    remove all items from the cart.

    This prevents duplicate orders.
    */
    $clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");

    // Bind user ID.
    $clear->bind_param("i", $user_id);

    // Execute delete query.
    $clear->execute();


    /*
    ---------------------------------------------------
    REDIRECT AFTER SUCCESS
    ---------------------------------------------------
    Send the user back to the cart page
    with a success message.
    */
    header("Location: ../pages/customer/cart.php?success=order_placed");
    exit;
}
?>