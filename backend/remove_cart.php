<?php
// Start the session so we can access logged-in user data
session_start();

// Connect to the database
include 'db_connect.php';

/*
---------------------------------------------------------
CHECK IF USER IS LOGGED IN
---------------------------------------------------------
This prevents guests (not logged in users) from
removing items from the cart.

If there is no logged-in user session, redirect
the user to the login page.
*/
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

/*
---------------------------------------------------------
GET USER ID AND CART ITEM ID
---------------------------------------------------------
Get the logged-in user's ID from the session.

Get the cart ID from the URL using $_GET.
(int) converts the value into an integer for safety.
Example:
remove_cart.php?cart_id=5
*/
$user_id = $_SESSION['user']['id'];
$cart_id = (int)$_GET['cart_id'];

/*
---------------------------------------------------------
DELETE ITEM FROM CART
---------------------------------------------------------
Prepare an SQL query to remove a specific item
from the cart table.

The query only deletes:
1. The selected cart item ID
2. The item that belongs to the logged-in user

This prevents users from deleting another user's cart.
*/
$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");

/*
Bind values to the query:

"ii" means:
i = integer (cart_id)
i = integer (user_id)
*/
$stmt->bind_param("ii", $cart_id, $user_id);

// Execute the delete query
$stmt->execute();

/*
---------------------------------------------------------
REDIRECT USER BACK TO CART PAGE
---------------------------------------------------------
After deleting the item, redirect the user
back to cart.php so they can see the updated cart.
*/
header("Location: ../pages/customer/cart.php");
exit;
?>