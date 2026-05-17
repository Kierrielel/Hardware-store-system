<?php
// Start session
session_start();

// Connect to database
include 'db_connect.php';

// Check if logged in as customer
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    unset($_SESSION['user']); // clear session
    session_regenerate_id(true); // prevent session hijacking
    header("Location: ../login.php");
    exit;
}

// Handle account update
if (isset($_POST['update_account'])) {

    // Get and clean inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_no']);
    $user_id = $_SESSION['user']['id'];

    // Validate phone (09 + 11 digits)
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        header("Location: ../pages/customer/edit_user.php?error=wrongformat");
        exit;    
    }

    // Update account info
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone_no = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $user_id);

    if ($stmt->execute()) {

        // Update session values
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_no'] = $phone;

        header("Location: ../pages/customer/edit_user.php?success=account");
        exit;

    } else {
        header("Location: ../pages/customer/edit_user.php?error=account");
        exit;
    }
}

// Handle password change
if (isset($_POST['change_password'])) {

    // Get password inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user']['id'];

    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        header("Location: ../pages/customer/edit_user.php?error=wrong_password");
        exit;
    }

    // Check password match
    if ($new_password !== $confirm_password) {
        header("Location: ../pages/customer/edit_user.php?error=password_mismatch");
        exit;
    }

    // Check minimum length
    if (strlen($new_password) < 8) {
        header("Location: ../pages/customer/edit_user.php?error=password_short");
        exit;
    }

    // Hash new password
    $hashed = password_hash($new_password, PASSWORD_ARGON2I);

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed, $user_id);

    if ($stmt->execute()) {
        header("Location: ../pages/customer/edit_user.php?success=password");
        exit;
    } else {
        header("Location: ../pages/customer/edit_user.php?error=password");
        exit;
    }
}

// Handle address update
if (isset($_POST['update_address'])) {

    // Format inputs (capitalize words)
    $name = trim(ucwords($_POST['name']));
    $province = trim(ucwords($_POST['province']));
    $city = trim(ucwords($_POST['city']));
    $unit = trim(ucwords($_POST['unit']));
    $barangay = trim(ucwords($_POST['barangay']));
    $user_id = $_SESSION['user']['id'];

    // Update address fields
    $stmt = $conn->prepare("UPDATE users SET province = ?, name = ?, city = ?, unit = ?, barangay = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $province, $name, $city, $unit, $barangay, $user_id);

    if ($stmt->execute()) {

        // Update session values
        $_SESSION['user']['province'] = $province;
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['city'] = $city;
        $_SESSION['user']['unit'] = $unit;
        $_SESSION['user']['barangay'] = $barangay;

        header("Location: ../pages/customer/edit_user.php?success=address");
        exit;

    } else {
        header("Location: ../pages/customer/edit_user.php?error=invalid_address");
        exit;
    }
}
?>