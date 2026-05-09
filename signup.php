<?php
// ================= SESSION + DATABASE =================
// Start the session so we can store and access user data if needed
session_start();

// Include database connection (used later when registering user)
include 'backend/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ================= PAGE SETUP ================= -->
    <!-- Basic settings for encoding and responsive layout -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS files for styling -->
    <link rel="stylesheet" href="resources/css/login.css">
    <link rel="stylesheet" href="resources/css/alert.css">

    <title>Sign-up</title>
</head>
<body>

    <!-- ================= ALERT MESSAGES ================= -->
    <!-- Displays success or error messages based on URL parameters -->
    <div class="alert-container">

        <!-- Success message (after successful registration) -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert-success">
                <?php 
                // If account was created successfully
                if($_GET['success'] === 'created') echo "You can now login!";
                ?>
            </div>
        <?php endif; ?>
            
        <!-- Error messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?php 
                // Different error messages depending on what failed
                if($_GET['error'] === 'noaction') echo "No action provided.";
                if($_GET['error'] === 'inputrequired') echo "Registration failed: email, phone number and password are required.";
                if($_GET['error'] === 'wrongformat') echo "Registration failed: invalid email format.";
                if($_GET['error'] === 'dberror') echo "Registration failed: database error.";
                if($_GET['error'] === 'tooshort') echo "Registration failed: password must be at least 6 characters.";
                if($_GET['error'] === 'exist') echo "Registration failed: email or phone number exists already.";
                ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ================= SIGNUP FORM CONTAINER ================= -->
    <!-- This is the main registration box -->
    <div class="signup_container">

        <!-- Logo -->
        <div id="logo">
            <img src="resources/images/logo.png" alt="logo" height="50px" width="50px">
        </div>

        <!-- Page title -->
        <h1>Create an Account</h1>

        <!-- ================= SIGNUP FORM ================= -->
        <!-- This form sends user data to process_login.php for registration -->
        <form action="backend/process_login.php" method="post">

            <!-- Hidden field tells backend this is a REGISTER action -->
            <input type="hidden" name="action" value="register">

            <!-- Username input -->
            <div class="input-container">
                <input type="username" name="username" id="username" placeholder=" " required>
                <label for="username">Username</label>
            </div>

            <!-- Email input -->
            <div class="input-container">
                <input type="email" name="email" id="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>
            
            <!-- Phone number input -->
            <div class="input-container">
                <input type="text" name="phone_no" id="phone_no" placeholder=" " required>
                <label for="phone_no">Phone no.</label>
            </div>
        
            <!-- Password input -->
            <div class="input-container">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn-signup">Sign up</button>
        </form>

        <!-- Link back to login page -->
        <a href="login.php" class="btn-create">Already have an Account</a>
    </div>

</body>
</html>