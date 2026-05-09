<?php

// Start the session so we can access logged-in user data
session_start();

// Connect to the database
include 'db_connect.php';


/*
---------------------------------------------------
CHECK IF USER IS AN ADMIN
---------------------------------------------------
This checks if:
1. A user is logged in
2. The logged-in user is an admin

If the user is not an admin, redirect them
to the login page and stop the script.
*/
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}


/*
---------------------------------------------------
CHECK IF FORM WAS SUBMITTED
---------------------------------------------------
This only runs when the user submits the form
using POST method.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form values and remove extra spaces using trim()
    $name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim($_POST['description']);


    /*
    ---------------------------------------------------
    CHECK REQUIRED FIELDS
    ---------------------------------------------------
    Make sure important fields are not empty.

    If required fields are missing,
    redirect back to inventory page with an error.
    */
    if (empty($name) || empty($price) || empty($stock) || empty($category_id)) {
        header("Location: ../pages/admin/inventory.php?error=missing_fields");
        exit;
    }   


    /*
    ---------------------------------------------------
    CHECK IF PRODUCT ALREADY EXISTS
    ---------------------------------------------------
    This checks the database to see if a product
    with the same name already exists.

    We use prepared statements (?) for security
    to avoid SQL injection.
    */
    $check_product = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $check_product->bind_param("s", $name);
    $check_product->execute();
    $check_product->store_result();

    // If product already exists, stop adding it
    if ($check_product->num_rows > 0) {
        header("Location: ../pages/admin/inventory.php?error=product_exists");
        exit;
    }


    /*
    ---------------------------------------------------
    HANDLE IMAGE UPLOAD
    ---------------------------------------------------
    If the user uploads an image:

    1. Create upload folder path
    2. Create a unique file name using time()
       so images do not overwrite each other
    3. Save image path to database
    4. Move uploaded image to the folder
    */
    $image_path = null;

    if (!empty($_FILES['image']['name'])) {

        $upload_dir = '../resources/products/';

        // Add current timestamp to make filename unique
        $image_name = time() . '_' . $_FILES['image']['name'];

        // Save image path for database
        $image_path = 'resources/products/' . $image_name;

        // Move image to the upload folder
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $upload_dir . $image_name
        );
    }


    /*
    ---------------------------------------------------
    INSERT PRODUCT INTO DATABASE
    ---------------------------------------------------
    Add the new product into the products table.

    Values:
    - category_id
    - name
    - brand
    - description
    - price
    - stock quantity
    - image path
    */
    $sql = "INSERT INTO products (
                category_id,
                name,
                brand,
                description,
                price,
                stock_quantity,
                image_path
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare SQL query
    $stmt = $conn->prepare($sql);

    // Bind values safely into query
    $stmt->bind_param(
        "isssdis",
        $category_id,
        $name,
        $brand,
        $description,
        $price,
        $stock,
        $image_path
    );


    /*
    ---------------------------------------------------
    EXECUTE QUERY
    ---------------------------------------------------
    If insert is successful:
    redirect back with success message.

    Otherwise:
    show database error.
    */
    if ($stmt->execute()) {
        header("Location: ../pages/admin/inventory.php?success=added");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    // Close prepared statement to free memory
    $stmt->close();
}

?>