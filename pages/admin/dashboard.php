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
    <div class="main-content">
        <div class="header-text">
            <div class="text-container">
                <h2>Dashboard Overview</h2>
                <p>Welcome back, Admin. Here's what's happening today.</p>
            </div>
        </div>

        <div class="concon">
            <div class="con-top">
                <div class="con1">
                    <div class="box-total-rev">
                        <svg width="32" height="32" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.1001 4.2C8.32572 4.2 7.7001 4.82562 7.7001 5.6V8.4H6.6501C6.06822 8.4 5.6001 8.86812 5.6001 9.45C5.6001 10.0319 6.06822 10.5 6.6501 10.5H7.7001V11.9H6.6501C6.06822 11.9 5.6001 12.3681 5.6001 12.95C5.6001 13.5319 6.06822 14 6.6501 14H7.7001V22.4C7.7001 23.1744 8.32572 23.8 9.1001 23.8C9.87447 23.8 10.5001 23.1744 10.5001 22.4V18.2H14.7001C17.5701 18.2 20.0376 16.4719 21.1182 14H22.7501C23.332 14 23.8001 13.5319 23.8001 12.95C23.8001 12.3681 23.332 11.9 22.7501 11.9H21.6651C21.687 11.6681 21.7001 11.4362 21.7001 11.2C21.7001 10.9637 21.687 10.7319 21.6651 10.5H22.7501C23.332 10.5 23.8001 10.0319 23.8001 9.45C23.8001 8.86812 23.332 8.4 22.7501 8.4H21.1182C20.0376 5.92812 17.5701 4.2 14.7001 4.2H9.1001ZM17.8326 8.4H10.5001V7H14.7001C15.9426 7 17.0626 7.5425 17.8326 8.4ZM10.5001 10.5H18.8432C18.8826 10.7275 18.9001 10.9594 18.9001 11.2C18.9001 11.4406 18.8782 11.6725 18.8432 11.9H10.5001V10.5ZM17.8326 14C17.0626 14.8575 15.947 15.4 14.7001 15.4H10.5001V14H17.8326Z" fill="white"/>
                        </svg>
                    </div>
                    <p>Total Revenue (Monthly)</p>

                    <div class="statValue"><?php echo $totalRevenue; ?></div>
                </div>
                <div class="con2">
                    <div class="box-total-order">
                        <svg width="32" height="32" viewBox="0 0 27 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.49986 9.32353V8.44118C4.49986 7.62235 4.49986 7.21118 4.53986 6.86706C4.72108 5.2419 5.53529 3.72246 6.84378 2.56759C8.15226 1.41273 9.87407 0.693881 11.7159 0.53353C12.1059 0.5 12.5719 0.5 13.4999 0.5C14.4279 0.5 14.8939 0.5 15.2839 0.535294C17.1257 0.695193 18.8477 1.41361 20.1566 2.56816C21.4654 3.72271 22.2801 5.24195 22.4619 6.86706C22.4999 7.21118 22.4999 7.62235 22.4999 8.44118V9.32353M20.4999 18.1471V14.6176M6.49986 18.1471V14.6176M0.5 15.6766C0.5 12.6818 0.5 11.1836 1.554 10.2536C2.608 9.32361 4.306 9.32361 7.7 9.32361H19.3C22.694 9.32361 24.392 9.32361 25.446 10.2536C26.5 11.1836 26.5 12.6818 26.5 15.6766V19.9118C26.5 24.9024 26.5 27.3995 24.742 28.9489C22.986 30.5001 20.156 30.5001 14.5 30.5001H12.5C6.844 30.5001 4.014 30.5001 2.258 28.9489C0.5 27.3995 0.5 24.9024 0.5 19.9118V15.6766Z" stroke="white" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <p>Total Orders</p>
                    <div class="statValue"><?php echo $totalOrders; ?></div>
                </div>
                <div class="con3">
                    <div class="box-total-user">
                        <svg width="32" height="32" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.25 24.5C26.25 24.5 28 24.5 28 22.75C28 21 26.25 15.75 19.25 15.75C12.25 15.75 10.5 21 10.5 22.75C10.5 24.5 12.25 24.5 12.25 24.5H26.25ZM12.2885 22.75L12.25 22.743C12.2517 22.281 12.5422 20.9405 13.58 19.733C14.546 18.6007 16.2435 17.5 19.25 17.5C22.2547 17.5 23.9522 18.6025 24.92 19.733C25.9578 20.9405 26.2465 22.2827 26.25 22.743L26.236 22.7465L26.2115 22.75H12.2885ZM19.25 12.25C20.1783 12.25 21.0685 11.8813 21.7249 11.2249C22.3813 10.5685 22.75 9.67826 22.75 8.75C22.75 7.82174 22.3813 6.9315 21.7249 6.27513C21.0685 5.61875 20.1783 5.25 19.25 5.25C18.3217 5.25 17.4315 5.61875 16.7751 6.27513C16.1187 6.9315 15.75 7.82174 15.75 8.75C15.75 9.67826 16.1187 10.5685 16.7751 11.2249C17.4315 11.8813 18.3217 12.25 19.25 12.25ZM24.5 8.75C24.5 9.43944 24.3642 10.1221 24.1004 10.7591C23.8365 11.396 23.4498 11.9748 22.9623 12.4623C22.4748 12.9498 21.896 13.3365 21.2591 13.6004C20.6221 13.8642 19.9394 14 19.25 14C18.5606 14 17.8779 13.8642 17.2409 13.6004C16.604 13.3365 16.0252 12.9498 15.5377 12.4623C15.0502 11.9748 14.6635 11.396 14.3996 10.7591C14.1358 10.1221 14 9.43944 14 8.75C14 7.35761 14.5531 6.02226 15.5377 5.03769C16.5223 4.05312 17.8576 3.5 19.25 3.5C20.6424 3.5 21.9777 4.05312 22.9623 5.03769C23.9469 6.02226 24.5 7.35761 24.5 8.75ZM12.138 16.24C11.4376 16.0211 10.7161 15.8762 9.9855 15.8077C9.5749 15.7677 9.16254 15.7484 8.75 15.75C1.75 15.75 0 21 0 22.75C0 23.9167 0.583333 24.5 1.75 24.5H9.128C8.86869 23.9536 8.73932 23.3547 8.75 22.75C8.75 20.9825 9.40975 19.1765 10.6575 17.668C11.0828 17.1535 11.578 16.6722 12.138 16.24ZM8.61 17.5C7.57492 19.0565 7.01548 20.8808 7 22.75H1.75C1.75 22.295 2.037 20.9475 3.08 19.733C4.03375 18.62 5.691 17.535 8.61 17.5018V17.5ZM2.625 9.625C2.625 8.23261 3.17812 6.89726 4.16269 5.91269C5.14726 4.92812 6.48261 4.375 7.875 4.375C9.26739 4.375 10.6027 4.92812 11.5873 5.91269C12.5719 6.89726 13.125 8.23261 13.125 9.625C13.125 11.0174 12.5719 12.3527 11.5873 13.3373C10.6027 14.3219 9.26739 14.875 7.875 14.875C6.48261 14.875 5.14726 14.3219 4.16269 13.3373C3.17812 12.3527 2.625 11.0174 2.625 9.625ZM7.875 6.125C6.94674 6.125 6.0565 6.49375 5.40013 7.15013C4.74375 7.8065 4.375 8.69674 4.375 9.625C4.375 10.5533 4.74375 11.4435 5.40013 12.0999C6.0565 12.7563 6.94674 13.125 7.875 13.125C8.80326 13.125 9.6935 12.7563 10.3499 12.0999C11.0063 11.4435 11.375 10.5533 11.375 9.625C11.375 8.69674 11.0063 7.8065 10.3499 7.15013C9.6935 6.49375 8.80326 6.125 7.875 6.125Z" fill="white"/>
                        </svg>
                    </div>
                    <p>Active Users</p>
                    <div class="statValue"><?php echo $totalUsers; ?></div>
                </div>
                <div class="con4">
                    <div class="box-ave-order">
                        <svg width="32" height="32" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.125 4.125V26.125C4.125 26.8543 4.41473 27.5538 4.93046 28.0695C5.44618 28.5853 6.14565 28.875 6.875 28.875H28.875" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M26.125 12.375L19.25 19.25L13.75 13.75L9.625 17.875" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p>Avg. Order Value</p>
                    <div class="statValue"><?php echo $AvgOV; ?></div>
                </div>
            </div>
            <div class="con-bottom">
                <div class="conb1">
                    <div class="recentorder-text-container">
                        <p class="conb-text">Recent Orders</p>    
                    </div>

                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ORDER ID</th>
                                <th>CUSTOMER</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $orders = $conn->query("
                                SELECT orders.*, users.username 
                                FROM orders 
                                JOIN users ON orders.user_id = users.id 
                                WHERE orders.order_status = 'pending'
                                ORDER BY order_date DESC 
                                LIMIT 10
                            ");
                            if($orders->num_rows > 0){
                                while($order = $orders->fetch_assoc()){
                            ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo $order['username']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align:center; padding: 20px; color: #888;'>No pending orders</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="conb2">
                    <div class="lowstock-text-container">
                        <p class="conb-text">Low Stock Alert</p>    
                    </div>

                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>CATEGORY</th>
                                <th>STOCK</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $low_stock = $conn->query("
                                SELECT products.*, categories.name AS category_name 
                                FROM products 
                                JOIN categories ON products.category_id = categories.id
                                WHERE products.stock_quantity <= 20
                                ORDER BY products.stock_quantity ASC
                            ");

                            if($low_stock->num_rows > 0){

                                while($item = $low_stock->fetch_assoc()){
                            ?>
                                <tr>
                                    <td id="prodname-text"><?php echo $item['name']; ?></td>
                                    <td><span id="catcon"><?php echo $item['category_name']; ?></span></td>
                                    <td style="color: #dc2626; font-weight: bold;">
                                        <?php echo $item['stock_quantity']; ?> left
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3' style='text-align:center; padding: 20px; color: #888;'>No low stock items</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>