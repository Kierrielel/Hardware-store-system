<?php
session_start();
include 'db_connect.php';

/*
---------------------------------------------------
CHECK USER AUTHENTICATION AND ROLE
---------------------------------------------------
This checks if:
1. The user is logged in
2. The user is an admin

Why?
Deleting categories is an admin-only action.
If the user is not an admin, redirect them
to the login page for security.
*/
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}


/*
---------------------------------------------------
GET CATEGORY ID
---------------------------------------------------
This gets the category ID from the URL.

Example URL:
delete_category.php?id=3

The value of "id" will be 3.
*/
$id = $_GET['id'];


/*
---------------------------------------------------
CHECK IF CATEGORY HAS PRODUCTS
---------------------------------------------------
Before deleting a category, we first check
if there are products connected to it.

Why?
If a category still contains products,
deleting it may cause errors or broken data.

COUNT(*) counts how many products are using
this category ID.
*/
$check = $conn->prepare("SELECT COUNT(*) as total FROM products WHERE category_id = ?");

// Bind the category ID to the query.
// "i" means integer.
$check->bind_param("i", $id);

// Run the query.
$check->execute();

// Get the result.
$result = $check->get_result();

// Convert the result into an associative array.
$row = $result->fetch_assoc();


/*
---------------------------------------------------
STOP DELETION IF CATEGORY HAS PRODUCTS
---------------------------------------------------
If the category contains one or more products,
do not allow deletion.

Redirect back with an error message.
*/
if ($row['total'] > 0) {
    header("Location: ../pages/admin/categories.php?error=has_products");
    exit;
}


/*
---------------------------------------------------
DELETE CATEGORY
---------------------------------------------------
If the category has no connected products,
it is safe to delete.

DELETE removes the row from the categories table.
*/
$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");

// Bind the category ID.
// "i" means integer.
$stmt->bind_param("i", $id);


/*
---------------------------------------------------
EXECUTE DELETE QUERY
---------------------------------------------------
Run the delete command.

If successful, redirect back to the category page
and show a success message.
*/
if ($stmt->execute()) {
    header("Location: ../pages/admin/categories.php?success=deleted");
    exit;
}
?>