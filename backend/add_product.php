<?php

// Start session
session_start();

// Connect database
include 'db_connect.php';

// Check admin access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim($_POST['description']);

    // Check required fields
    if (empty($name) || empty($price) || empty($stock) || empty($category_id)) {
        header("Location: ../pages/admin/inventory.php?error=missing_fields");
        exit;
    }

    // Check duplicate product
    $check_product = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $check_product->bind_param("s", $name);
    $check_product->execute();
    $check_product->store_result();

    // Redirect if product exists
    if ($check_product->num_rows > 0) {
        header("Location: ../pages/admin/inventory.php?error=product_exists");
        exit;
    }

    // Upload product image
    $image_path = null;

    if (!empty($_FILES['image']['name'])) {

        $upload_dir = '../resources/products/';

        // Create unique filename
        $image_name = time() . '_' . $_FILES['image']['name'];

        // Save image path
        $image_path = 'resources/products/' . $image_name;

        // Move image file
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $upload_dir . $image_name
        );
    }

    // Insert product
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

    // Prepare query
    $stmt = $conn->prepare($sql);

    // Bind values
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

    // Execute query
    if ($stmt->execute()) {
        header("Location: ../pages/admin/inventory.php?success=added");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

?>