<?php
// ================= SESSION + DATABASE =================
// Start the session so we can store and access user login data
session_start();

// Include database connection (used later in login processing)
include 'backend/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ================= PAGE SETUP ================= -->
    <!-- Character encoding and responsive design settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link CSS files for styling the login page -->
    <link rel="stylesheet" href="resources/css/login.css">
    <link rel="stylesheet" href="resources/css/alert.css">

    <title>Log-in</title>
</head>
<body>

    <!-- ================= ALERT MESSAGES ================= -->
    <!-- This section displays success or error messages based on URL parameters -->
    <div class="alert-container">

        <!-- Show success message (example: after logout) -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert-success">
                <?php 
                // If user successfully logged out
                if($_GET['success'] === 'logout') echo "logged out successfully!";
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Show error messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?php 
                // Different errors depending on what went wrong
                if($_GET['error'] === 'noaction') echo "No action provided.";
                if($_GET['error'] === 'inputrequired') echo "Login failed: email, phone number and password are required.";
                if($_GET['error'] === 'invalid') echo "Login failed: invalid username or password.";
                if($_GET['error'] === 'dberror') echo "Login failed: database error.";
                ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ================= LOGIN FORM CONTAINER ================= -->
    <!-- This is the main login box -->
    <div class="login_container">

        <!-- Logo -->
        <div id="logo">
            <img src="resources/images/logo.png" alt="logo" height="50px" width="50px">
        </div>

        <!-- Store name -->
        <h1>RM LAZARO ENTERPRISES</h1>

        <!-- ================= LOGIN FORM ================= -->
        <!-- This form sends user input to process_login.php -->
        <form action="backend/process_login.php" method="post">

            <!-- Hidden field tells backend that this is a login action -->
            <input type="hidden" name="action" value="login">

            <!-- Username / Email / Phone input -->
            <div class="input-container">
                <!-- User can log in using username, email, or phone -->
                <input type="text" name="login_id" id="login_id" placeholder=" " required>
                <label for="login_id">Username/Email/Phone no.</label>
            </div>
            
            <!-- Password input -->
            <div class="input-container">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn-login">Log In</button>
        </form>

        <!-- ================= EXTRA LINKS ================= -->
        <!-- Forgot password (not yet implemented) -->
        <a href="#" class="forgot-password">Forgot Password?</a>

        <!-- Link to signup page -->
        <a href="signup.php" class="btn-create">Create Account</a>
    </div>
</body>
</html>