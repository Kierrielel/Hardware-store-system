<?php
session_start();
include '../../includes/header_admin.php';
include '../../backend/db_connect.php';
?>

<div class="body-container">
        <div class="sidebar-container">
            <nav>
                <div class="sidebar">
                    <h4>MENU</h4>
                    <a href="../admin/dashboard.php">
                        <div class="home">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
                            <p class="home-text">Dashboard</p>
                        </div>
                    </a>
                    <a href="../admin/inventory.php">
                        <div class="products">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Zm120 20Z"/></svg>
                            <p class="products-text">Products</p>
                        </div>
                    </a>
                    <a href="../admin/categories.php">
                        <div class="categories">
                            <svg width="32" height="32" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.00004 12.5H14V13.5H7.00004V12.5ZM3.58504 13L2.29504 14.29L3.00004 15L5.00004 13L3.00004 11L2.29004 11.705L3.58504 13ZM7.00004 7.5H14V8.5H7.00004V7.5ZM3.58504 8L2.29504 9.29L3.00004 10L5.00004 8L3.00004 6L2.29004 6.705L3.58504 8ZM7.00004 2.5H14V3.5H7.00004V2.5ZM3.58504 3L2.29504 4.29L3.00004 5L5.00004 3L3.00004 1L2.29004 1.705L3.58504 3Z" fill="white"/>
                            </svg>
                            <p class="categories-text">Categories</p>
                        </div>
                    </a>
                    <a href="../admin/finance.php">
                        <div class="finance">
                            <svg width="32" height="32" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.125 4.125V26.125C4.125 26.8543 4.41473 27.5538 4.93046 28.0695C5.44618 28.5853 6.14565 28.875 6.875 28.875H28.875" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M26.125 12.375L19.25 19.25L13.75 13.75L9.625 17.875" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>                            
                            <p class="finance-text">Finance Report</p>
                        </div>
                    </a>
                    <a href="../admin/orders.php">
                        <div class="orders">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M223.5-103.5Q200-127 200-160t23.5-56.5Q247-240 280-240t56.5 23.5Q360-193 360-160t-23.5 56.5Q313-80 280-80t-56.5-23.5Zm400 0Q600-127 600-160t23.5-56.5Q647-240 680-240t56.5 23.5Q760-193 760-160t-23.5 56.5Q713-80 680-80t-56.5-23.5ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg>
                            <p class="orders-text">Orders</p>
                        </div>
                    </a>
                    <a href="../admin/users.php">
                        <div class="users">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M555-435q-35-35-35-85t35-85q35-35 85-35t85 35q35 35 35 85t-35 85q-35 35-85 35t-85-35ZM400-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T640-360q56 0 106.5 13.5T842-306q18 11 28 30t10 40v76H400Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm182.5-251.5Q680-503 680-520t-11.5-28.5Q657-560 640-560t-28.5 11.5Q600-537 600-520t11.5 28.5Q623-480 640-480t28.5-11.5ZM640-520Zm0 280ZM120-400v-80h320v80H120Zm0-320v-80h480v80H120Zm324 160H120v-80h360q-14 17-22.5 37T444-560Z"/></svg>
                            <p class="users-text">Users</p>
                        </div>
                    </a>
                    <a href="../admin/settings.php">
                        <div class="settings">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                            <p class="settings-text">Settings</p>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
        <div class="settings-content">
            <div class="header-text">
                <div class="text-container">
                    <h2>Settings</h2>
                    <p>Configure your store preferences and account details</p>
                </div>
            </div>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert-success">
                    <?php 
                    if($_GET['success'] === 'account') echo "Account information updated successfully!";
                    if($_GET['success'] === 'password') echo "Password changed successfully!";
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert-error">
                    <?php 
                    if($_GET['error'] === 'account') echo "Failed to update account information.";
                    if($_GET['error'] === 'wrongformat') echo "mobile number must be 11 digits and start with 09.";
                    if($_GET['error'] === 'wrong_password') echo "Current password is incorrect.";
                    if($_GET['error'] === 'password_mismatch') echo "New passwords do not match.";
                    if($_GET['error'] === 'password_short') echo "Password must be at least 8 characters.";
                    if($_GET['error'] === 'password') echo "Failed to change password.";
                    ?>
                </div>
            <?php endif; ?>
            <div class="setting-card-container">
                <div class="align-container">
                    <div class="store-info-container">
                        <div class="card-header">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 12.7188C13.468 12.7188 15.4688 10.718 15.4688 8.25C15.4688 5.78198 13.468 3.78125 11 3.78125C8.53198 3.78125 6.53125 5.78198 6.53125 8.25C6.53125 10.718 8.53198 12.7188 11 12.7188Z" stroke="#0C933E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.78125 19.5938C3.78125 16.1562 6.53125 12.7188 11 12.7188C15.4688 12.7188 18.2188 16.1562 18.2188 19.5938" stroke="#0C933E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>      
                            <h3>Account Information</h3>
                        </div>

                        <div class="card-body">
                            <form action="../../backend/update_settings.php" method="POST" onsubmit="return confirm('Update your account information?');">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" value="<?= $_SESSION['user']['username'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" value="<?= $_SESSION['user']['email'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone_no" value="<?= $_SESSION['user']['phone_no'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <input type="text" value="<?= $_SESSION['user']['role'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-buttons">
                                    <button type="submit" name="update_account" class="savebtn">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="account-setting-container">
                        <div class="card-header">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.586 17.414C2.2109 17.789 2.00011 18.2976 2 18.828V21C2 21.2653 2.10536 21.5196 2.29289 21.7071C2.48043 21.8947 2.73478 22 3 22H6C6.26522 22 6.51957 21.8947 6.70711 21.7071C6.89464 21.5196 7 21.2653 7 21V20C7 19.7348 7.10536 19.4805 7.29289 19.2929C7.48043 19.1054 7.73478 19 8 19H9C9.26522 19 9.51957 18.8947 9.70711 18.7071C9.89464 18.5196 10 18.2653 10 18V17C10 16.7348 10.1054 16.4805 10.2929 16.2929C10.4804 16.1054 10.7348 16 11 16H11.172C11.7024 15.9999 12.211 15.7891 12.586 15.414L13.4 14.6C14.7898 15.0842 16.3028 15.0823 17.6915 14.5948C19.0801 14.1072 20.2622 13.1629 21.0444 11.9162C21.8265 10.6695 22.1624 9.19421 21.9971 7.73178C21.8318 6.26934 21.1751 4.90629 20.1344 3.86561C19.0937 2.82493 17.7307 2.16822 16.2683 2.00293C14.8058 1.83763 13.3306 2.17353 12.0839 2.95568C10.8372 3.73782 9.89279 4.91991 9.40525 6.30856C8.91771 7.69721 8.91585 9.2102 9.4 10.6L2.586 17.414Z" stroke="#0C933E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.5 8C16.7761 8 17 7.77614 17 7.5C17 7.22386 16.7761 7 16.5 7C16.2239 7 16 7.22386 16 7.5C16 7.77614 16.2239 8 16.5 8Z" fill="#0C933E" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Change Password</h3>
                        </div>

                        <div class="card-body">
                            <form action="../../backend/update_settings.php" method="POST" onsubmit="return confirm('Update your password?');">
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
                <form action="/Hardware_Store_System/backend/process_login.php" method="post" onsubmit="return confirm('Are you sure you want to logout?');">
                    <input type="hidden" name="action" value="signout">

                    <button id="signbutton" type="submit">
                        <div class="signout">
                            <svg width="33" height="35" viewBox="0 0 33 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.5571 17.4999H10.9873" stroke="black" stroke-linecap="square"/>
                                <path d="M25.0649 12.7241L29.5887 17.5002L25.0649 22.2777" stroke="black" stroke-linecap="square"/>
                                <path d="M17.8816 24.2447V27.9895C17.8816 29.6464 16.5385 30.9895 14.8816 30.9895H6.41113C4.75428 30.9895 3.41113 29.6464 3.41113 27.9895V7.01037C3.41113 5.35352 4.75428 4.01038 6.41113 4.01038H14.8816C16.5385 4.01038 17.8816 5.35352 17.8816 7.01038V10.7552" stroke="black" stroke-linecap="square"/>
                            </svg>
                            Sign Out
                        </div>
                    </button>   
                </form>  

            </div>
        </div>
    </div>
</body>
</html>