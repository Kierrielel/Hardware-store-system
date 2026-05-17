<?php
session_start();
include '../../backend/db_connect.php';
include '../../includes/header.php';
?>


<main class="account-container">
    <aside class="account-sidebar">
        <div class="account-links">
            <a href="/Hardware_Store_System/pages/customer/account.php">
                <div class="sidebar-text">
                    <p>Overview</p>
                </div>
            </a>    
            <a href="/Hardware_Store_System/pages/customer/edit_user.php">
                <div class="sidebar-text">
                    <p>Manage My Account</p>
                </div>
            </a>    
            <form action="/Hardware_Store_System/backend/process_login.php" method="post" 
                  onsubmit="return confirm('Are you sure you want to logout?');">
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
    </aside>
    <div class="user-container">
        <div class="card-containers">
            <div class="userinfo-card">
                <div class="user-header-text">
                    <p>Account Details</p>
                </div>
                <div class="info-text">
                    <p>Username:<?= $_SESSION['user']['username'] ?></p>
                    <p class="contact">Email: <?= $_SESSION['user']['email'] ?></p>
                    <p class="contact">Phone no.: <?= $_SESSION['user']['phone_no'] ?></p>
                </div>
            </div>
            <div class="address-card">
                <?php 
                if(isset($_SESSION['user']['id'])){
                    $user_id = $_SESSION['user']['id'];

                    $check_address = $conn->prepare("SELECT name, province, city, unit, barangay FROM users WHERE id = ?");
                    $check_address->bind_param("i", $user_id);
                    $check_address->execute();

                    $check_result = $check_address->get_result();
                    $user_data = $check_result->fetch_assoc();    
                }
                if($user_data):
                ?>
                <div class="user-header-text">
                    <p>Billing Details</p>
                </div>

                <div class="info-text">
                    <p class="billing-name">Name: <?= $user_data['name'] ?? '' ?></p>
                    <p>Province: <?= $user_data['province'] ?? '' ?></p>
                    <p class="contact">City: <?= $user_data['city'] ?? ''?></p>
                    <p class="contact">Unit: <?= $user_data['unit'] ?? '' ?></p>
                    <p class="contact">Barangay: <?= $user_data['barangay'] ?? '' ?></p>
                </div>

                <?php endif?>
            </div>
        </div>
        <div class="order-table-container">

            <div class="my-orders-header">
                <h3>My Orders</h3>
            </div>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>ORDER ID</th>
                        <th>NAME</th>
                        <th>PRICE</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    if(isset($_SESSION['user']['id'])):

                        $user_id = $_SESSION['user']['id'];

                        $orders_stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
                        $orders_stmt->bind_param("i", $user_id);
                        $orders_stmt->execute();

                        $orders_result = $orders_stmt->get_result();

                        if($orders_result->num_rows > 0):

                            while($order = $orders_result->fetch_assoc()):

                                $items_stmt = $conn->prepare("SELECT order_items.*, products.name, products.image_path 
                                                              FROM order_items 
                                                              JOIN products ON order_items.product_id = products.id 
                                                              WHERE order_items.order_id = ?");
                                $items_stmt->bind_param("i", $order['id']);
                                $items_stmt->execute();

                                $items_result = $items_stmt->get_result();             
                    ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td>
                                <?php while ($item = $items_result->fetch_assoc()): ?>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="/Hardware_Store_System/<?= $item['image_path'] ?>" 
                                         height="40" width="40" 
                                         style="object-fit:contain; border-radius:5px;">
                                    <span><?= $item['name'] ?></span>
                                </div>
                                <?php endwhile; ?>
                            </td>
                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                            <td><?php echo ucfirst($order['order_status']); ?>  </td>
                        </tr>
                    <?php 
                            endwhile;       
                        endif;  
                    endif;  
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>

<?php
include '../../includes/footer.php';
?>