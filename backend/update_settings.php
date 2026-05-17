<?php
// Start session
session_start();

// Connect to database
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    unset($_SESSION['user']); // remove session
    session_regenerate_id(true); // prevent session hijacking
    header("Location: ../login.php");
    exit;
}

// Handle account update form
if (isset($_POST['update_account'])) {

    // Get and clean inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_no']);
    $user_id = $_SESSION['user']['id'];

    // Validate phone format (must start with 09 and 11 digits)
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        header("Location: ../pages/admin/settings.php?error=wrongformat");
        exit;    
    }

    // Update user info in database
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone_no = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $user_id);

    if ($stmt->execute()) {

        // Update session values
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_no'] = $phone;

        header("Location: ../pages/admin/settings.php?success=account");
        exit;

    } else {
        header("Location: ../pages/admin/settings.php?error=account");
        exit;
    }
}

// Handle password change form
if (isset($_POST['change_password'])) {

    // Get passwords
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
        header("Location: ../pages/admin/settings.php?error=wrong_password");
        exit;
    }

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        header("Location: ../pages/admin/settings.php?error=password_mismatch");
        exit;
    }

    // Check minimum length
    if (strlen($new_password) < 8) {
        header("Location: ../pages/admin/settings.php?error=password_short");
        exit;
    }

    // Hash new password
    $hashed = password_hash($new_password, PASSWORD_ARGON2I);

    // Update password in database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed, $user_id);

    if ($stmt->execute()) {
        header("Location: ../pages/admin/settings.php?success=password");
        exit;
    } else {
        header("Location: ../pages/admin/settings.php?error=password");
        exit;
    }
}
?>