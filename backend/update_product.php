<?php
// Start the session so we can access user login data
session_start();

// Connect to the database
include 'db_connect.php';


// --------------------------------------------------
// CHECK IF USER IS LOGGED IN AND IS AN ADMIN
// --------------------------------------------------
// This ensures only admins can update product information
// If not logged in or not an admin, redirect to login page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}


// --------------------------------------------------
// HANDLE FORM SUBMISSION (ONLY ACCEPT POST REQUESTS)
// --------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form inputs
    // trim() removes extra spaces before and after text
    $id = $_POST['product_id'];
    $name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim($_POST['description']);


    // --------------------------------------------------
    // CHECK IF PRODUCT NAME ALREADY EXISTS (EXCEPT CURRENT PRODUCT)
    // --------------------------------------------------
    // This prevents duplicate product names in the database
    $check = $conn->prepare("SELECT id FROM products WHERE name = ? AND id != ?");
    $check->bind_param("si", $name, $id);
    $check->execute();
    $check->store_result();

    // If a product with the same name already exists,
    // redirect back with an error
    if ($check->num_rows > 0) {
        header("Location: ../pages/admin/edit_product.php?id=$id&error=exists");
        exit;
    }


    // --------------------------------------------------
    // GET CURRENT IMAGE PATH FROM DATABASE
    // --------------------------------------------------
    // This is used in case the user does NOT upload a new image
    $get_current = $conn->query("SELECT image_path FROM products WHERE id = $id");
    $current = $get_current->fetch_assoc();
    $image_path = $current['image_path'];


    // --------------------------------------------------
    // HANDLE IMAGE UPLOAD (IF USER SELECTED A NEW IMAGE)
    // --------------------------------------------------
    // Check if a new image file was uploaded
    if (!empty($_FILES['image']['name'])) {

        // Define where the image will be stored
        $upload_dir = '../resources/products/';

        // Create a unique file name using current time
        // This prevents file name conflicts
        $image_name = time() . '_' . $_FILES['image']['name'];

        // Save the path that will be stored in the database
        $image_path = 'resources/products/' . $image_name;

        // Move the uploaded file from temporary location to the folder
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
    }


    // --------------------------------------------------
    // UPDATE PRODUCT INFORMATION IN DATABASE
    // --------------------------------------------------
    // Prepare a secure SQL query using placeholders
    $stmt = $conn->prepare("UPDATE products SET name=?, brand=?, category_id=?, price=?, stock_quantity=?, description=?, image_path=? WHERE id=?");

    // Bind the actual values to the query
    // "ssidissi" means:
    // s = string, i = integer, d = double (decimal)
    $stmt->bind_param("ssidissi", $name, $brand, $category_id, $price, $stock, $description, $image_path, $id);

    // Execute the update query
    if ($stmt->execute()) {

        // If successful, go back to inventory page with success message
        header("Location: ../pages/admin/inventory.php?success=updated");
        exit;

    } else {

        // If something goes wrong, go back to edit page with error
        header("Location: ../pages/admin/edit_product.php?id=$id&error=failed");
        exit;
    }
}
?>