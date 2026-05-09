<?php
// ================= SESSION + SETUP =================
// Start the session so we can access logged-in admin data
session_start();

// Include the admin header (top navigation / design)
include '../../includes/header_admin.php';

// Include database connection so we can query the database
include '../../backend/db_connect.php';
?>

<div class="body-container">

        <!-- ================= SIDEBAR NAVIGATION ================= -->
        <!-- This is the menu on the left side for navigating different admin pages -->
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

        <!-- ================= USERS PAGE CONTENT ================= -->
        <!-- This section displays all registered customers -->
        <div class="user-content">

            <!-- Page header -->
            <div class="header-text">
                <div class="text-container">
                    <h2>Users</h2>
                    <p>View and manage registered customer accounts</p>
                </div>
            </div>

            <div class="users-table-container">

            <?php
                // ================= CHECK IF THERE ARE USERS =================
                // Count how many users have the role "customer"
                $check_sql = "SELECT COUNT(*) as total FROM users WHERE role = 'customer'";
                $check_result = mysqli_query($conn, $check_sql);
                $check_row = mysqli_fetch_assoc($check_result);

                // If no users exist, show a message instead of a table
                if($check_row['total'] == 0) {
                ?>
                    <div class="empty-container">
                        <h3>There are no users</h3>
                    </div>

                <?php
                } else {
                ?>

                <!-- ================= USERS TABLE ================= -->
                <!-- This table displays all customer accounts -->
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Phone no.</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            // ================= FETCH USERS FROM DATABASE =================
                            // Get all users with role "customer"
                            $sql = "SELECT * FROM users WHERE role = 'customer'";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are results
                            if(mysqli_num_rows($result) > 0){

                                // Loop through each user and display them in the table
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>";
                                    ?>

                                    <!-- Display username -->
                                    <td id="name-text"><?php echo $row["username"] ?></td>

                                    <!-- Display phone number -->
                                    <td id="phone-text"><?php echo $row["phone_no"]; ?></td>

                                    <!-- Display email -->
                                    <td><span id="email-con"> <?php echo $row["email"]; ?></span></td>

                                    <!-- ================= ACTION BUTTON ================= -->
                                    <!-- Delete button allows admin to remove a user -->
                                    <td>
                                        <div class="action-buttons">

                                            <!-- Sends user ID to delete_user.php -->
                                            <!-- confirm() shows a popup before deleting -->
                                            <a href="../../backend/delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to remove this user?')">
                                                <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 10V16M12 10V16M17 5V19C17 19.5304 16.7893 20.0391 16.4142 20.4142C16.0391 20.7893 15.5304 21 15 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5M1 5H19M6 5V3C6 2.46957 6.21071 1.96086 6.58579 1.58579C6.96086 1.21071 7.46957 1 8 1H12C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V5" stroke="#F52A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>

                                        </div>
                                    </td>

                                    <?php
                                    echo "</tr>";
                                }    
                            }
                        ?>

                    </tbody>
                </table>

                <?php
                }
            ?>

        </div>
    </div>
</body>
</html>