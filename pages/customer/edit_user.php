<?php
// Start the session so we can access logged-in user data (like username, email, etc.)
session_start();

// Connect to the database (this file likely contains your DB connection code)
include '../../backend/db_connect.php';

// Include the header (navigation bar, styles, etc.)
include '../../includes/header.php';
?>


<main class="account-container">
    <!-- Sidebar navigation for account pages -->
    <aside class="account-sidebar">
        <div class="account-links">
            <!-- Link to account overview page -->
            <a href="/Hardware_Store_System/pages/customer/account.php">
                <div class="sidebar-text">
                    <p>Overview</p>
                </div>
            </a>    

            <!-- Link to edit account page -->
            <a href="/Hardware_Store_System/pages/customer/edit_user.php">
                <div class="sidebar-text">
                    <p>Manage My Account</p>
                </div>
            </a>

            <!-- Logout form -->
            <!-- When submitted, it sends a request to process_login.php to log the user out -->
            <form action="/Hardware_Store_System/backend/process_login.php" method="post" onsubmit="return confirm('Are you sure you want to logout?');">
                <input type="hidden" name="action" value="signout">
                <button id="signbutton" type="submit">
                    <div class="signout">
                        <!-- SVG icon for logout -->
                        <svg width="33" height="35" viewBox="0 0 33 35" fill="none">
                        <path d="M28.5571 17.4999H10.9873" stroke="black"/>
                        <path d="M25.0649 12.7241L29.5887 17.5002L25.0649 22.2777" stroke="black"/>
                        <path d="M17.8816 24.2447V27.9895C17.8816 29.6464 16.5385 30.9895 14.8816 30.9895H6.41113C4.75428 30.9895 3.41113 29.6464 3.41113 27.9895V7.01037C3.41113 5.35352 4.75428 4.01038 6.41113 4.01038H14.8816C16.5385 4.01038 17.8816 5.35352 17.8816 7.01038V10.7552" stroke="black"/>
                        </svg>
                        Sign Out
                    </div>
                </button>   
            </form>    
        </div>    
    </aside>

    <!-- Main content area -->
    <section class="user-container">

        <!-- SUCCESS MESSAGE DISPLAY -->
        <!-- Checks if a success message exists in the URL and shows it -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert-success">
                <?php 
                if($_GET['success'] === 'account') echo "Account information updated successfully!";
                if($_GET['success'] === 'address') echo "Billing address updated successfully!";
                if($_GET['success'] === 'password') echo "Password changed successfully!";
                ?>
            </div>
        <?php endif; ?>
        
        <!-- ERROR MESSAGE DISPLAY -->
        <!-- Shows error messages based on URL parameters -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?php 
                if($_GET['error'] === 'account') echo "Failed to update account information.";
                if($_GET['error'] === 'wrongformat') echo "mobile number must be 11 digits and start with 09.";
                if($_GET['error'] === 'wrong_password') echo "Current password is incorrect.";
                if($_GET['error'] === 'password_mismatch') echo "New passwords do not match.";
                if($_GET['error'] === 'password_short') echo "Password must be at least 8 characters.";
                if($_GET['error'] === 'password') echo "Failed to change password.";
                if($_GET['error'] === 'invalid_addres') echo "Failed to update address.";
                ?>
            </div>
        <?php endif; ?>

        <div class="align-container">

            <!-- ================= ACCOUNT INFORMATION FORM ================= -->
            <!-- Allows user to update username, email, and phone number -->
            <div class="user-info-container">
                <div class="card-header">
                    <h3>Account Information</h3>
                </div>
                <div class="card-body">
                    <!-- Form sends updated data to update_user.php -->
                    <form action="../../backend/update_user.php" method="POST" onsubmit="return confirm('Update your account information?');">
                        
                        <!-- Username and Email -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Username</label>
                                <!-- Pre-filled with current session data -->
                                <input type="text" name="username" value="<?= $_SESSION['user']['username'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= $_SESSION['user']['email'] ?>" required>
                            </div>
                        </div>

                        <!-- Phone number -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_no" value="<?= $_SESSION['user']['phone_no'] ?>" required>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="form-buttons">
                            <button type="submit" name="update_account" class="savebtn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ================= CHANGE PASSWORD FORM ================= -->
            <!-- Lets user change their password -->
            <div class="account-setting-container">
                <div class="card-header">
                    <h3>Change Password</h3>
                </div>
                <div class="card-body">
                    <!-- Sends password data to backend -->
                    <form action="../../backend/update_user.php" method="POST" onsubmit="return confirm('Update your password?');">

                        <!-- Current and new password -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password" required>
                            </div>
                        </div>

                        <!-- Confirm password -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" name="change_password" class="savebtn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= BILLING ADDRESS FORM ================= -->
        <!-- Lets user add or update their address -->
        <div class="address-form">
            <div class="address-form-container">
                <div class="card-header">
                    <h3>Billing Address</h3>
                </div>
                <div class="card-body">
                    <form action="../../backend/update_user.php" method="POST" onsubmit="return confirm('Add/Update your billing address?');">

                        <?php 
                        // Get user ID from session
                        if(isset($_SESSION['user']['id'])){
                            $user_id = $_SESSION['user']['id'];

                            // Prepare SQL query to get user's current address
                            $check_address = $conn->prepare("SELECT name, province, city, unit, barangay FROM users WHERE id = ?");
                            $check_address->bind_param("i", $user_id);
                            $check_address->execute();

                            // Get result and store in $user_data
                            $check_result = $check_address->get_result();
                            $user_data = $check_result->fetch_assoc();    
                        }

                        // Only show form if user data exists
                        if($user_data):
                        ?>

                        <!-- Full name -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" value="<?= $user_data['name'] ?? '' ?>" placeholder="e.g Juan Makasalanan" required>
                            </div>  
                        </div>

                        <!-- Address fields -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit" value="<?= $user_data['unit'] ?? '' ?>" placeholder="e.g Blk 2 Lot 4, Phanse 1 or N/a" required>
                            </div>
                            <div class="form-group">
                                <label>Province</label>
                                <input type="text" name="province" value="<?= $user_data['province'] ?? '' ?>"  placeholder="e.g Bulacan" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" value="<?= $user_data['city'] ?? '' ?>" placeholder="e.g San Miguel" required>
                            </div>
                            <div class="form-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" value="<?= $user_data['barangay'] ?? '' ?>" placeholder="Poblacion" required>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="form-buttons">
                            <button type="submit" name="update_address" class="savebtn">Add/Save</button>
                        </div>

                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

    </section>
</main>

</body>
</html>

<?php
// Include footer (bottom part of the page)
include '../../includes/footer.php';
?>