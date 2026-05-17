<?php
// Start session
session_start();

// Connect to database
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form inputs
    $id = $_POST['product_id'];
    $name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim($_POST['description']);

    // Check if product name already exists (excluding current product)
    $check = $conn->prepare("SELECT id FROM products WHERE name = ? AND id != ?");
    $check->bind_param("si", $name, $id);
    $check->execute();
    $check->store_result();

    // If duplicate found, redirect with error
    if ($check->num_rows > 0) {
        header("Location: ../pages/admin/edit_product.php?id=$id&error=exists");
        exit;
    }

    // Get current image path
    $get_current = $conn->query("SELECT image_path FROM products WHERE id = $id");
    $current = $get_current->fetch_assoc();
    $image_path = $current['image_path'];

    // Handle image upload (if new file is selected)
    if (!empty($_FILES['image']['name'])) {

        // Upload directory
        $upload_dir = '../resources/products/';

        // Create unique file name
        $image_name = time() . '_' . $_FILES['image']['name'];

        // Save new image path
        $image_path = 'resources/products/' . $image_name;

        // Move uploaded file
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
    }

    // Update product data
    $stmt = $conn->prepare("UPDATE products SET name=?, brand=?, category_id=?, price=?, stock_quantity=?, description=?, image_path=? WHERE id=?");
    $stmt->bind_param("ssidissi", $name, $brand, $category_id, $price, $stock, $description, $image_path, $id);

    // Execute update
    if ($stmt->execute()) {

        // Redirect on success
        header("Location: ../pages/admin/inventory.php?success=updated");
        exit;

    } else {

        // Redirect on failure
        header("Location: ../pages/admin/edit_product.php?id=$id&error=failed");
        exit;
    }
}
?>