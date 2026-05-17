<?php
session_start();
include '../../backend/db_connect.php';
include '../../includes/header.php';
?>

<main class="cart-main-container">

<?php if (isset($_SESSION['user'])): ?>   
    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">
            <?php 
            if($_GET['success'] === 'added') echo "Added to cart successfully!";
            if($_GET['success'] === 'order_placed') echo "Order placed successfully!";
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert-error">
            <?php 
            if($_GET['error'] === 'not_enough_stock') echo "Invalid product quantity.";
            ?>
        </div>
     <?php endif; ?>

    <div class="cart-card-align"> 
        <div class="cart-list">
            <?php
            if(isset($_SESSION['user'])):
                $user_id = $_SESSION['user']['id'];
                $cart_check = $conn->prepare("SELECT cart.*, products.name, products.price, products.image_path, products.stock_quantity
                                       FROM cart 
                                       JOIN products ON cart.product_id = products.id
                                       WHERE cart.user_id = ?");
                $cart_check->bind_param("i", $user_id);
                $cart_check->execute();

                $cart_result = $cart_check->get_result();

                $total = 0;

                if($cart_result->num_rows > 0):

                    while($cart_item = $cart_result->fetch_assoc()):

                        $subtotal = $cart_item['price'] * $cart_item['quantity'];
                        $total += $subtotal;
                ?>
                    <div class="cart-list-container">
                        <div class="cart-list-img">    
                            <img src="/Hardware_Store_System/<?php echo $cart_item['image_path']; ?>" 
                            alt="<?php echo $cart_item['name']; ?>">
                        </div>
                        <div class="cart-list-name">
                            <a href="/Hardware_Store_System/pages/customer/product_page.php?prod_id=<?= $cart_item['product_id'] ?>">
                                <?php echo $cart_item['name']; ?>
                            </a>
                        </div>
                        <div class="cart-list-price">
                            <p>₱<?php echo number_format($cart_item['price'], 2); ?></p>
                        </div>
                        <div class="button">
                            <div class="add-button">
                                <form action="/Hardware_Store_System/backend/update_cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $cart_item['id'] ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="qty-btn minus-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M4.16699 10H15.8337" stroke="#1E1E1E" stroke-width="2"/>
                                        </svg>
                                    </button>
                                </form>
                                <div class="add-text">
                                    <?php echo $cart_item['quantity']; ?>
                                </div>
                                <form action="/Hardware_Store_System/backend/update_cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $cart_item['id'] ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="qty-btn add-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M11 13H5V11H11V5H13V11H19V13H13V19H11V13Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <a href="/Hardware_Store_System/backend/remove_cart.php?cart_id=<?= $cart_item['id'] ?>" 
                           class="remove-btn" 
                           onclick="return confirm('Are you sure you want to remove this item?')">
                           Remove
                        </a>
                    </div>      

                <?php
                    endwhile;
                else:
                ?>
                    <div class="empty-cart">
                        <p>Your cart is empty.</p>
                        <a href="/Hardware_Store_System/pages/customer/products.php" class="shop-now-btn">Shop Now</a>
                    </div>
                <?php
                endif;
            endif;
            ?>
        </div>
        <div class="cart-summary">

            <?php if(isset($total)): ?>
                <div class="cart-text-summary">

                    <h4>Order Summary</h4>
                    <div class="summary-row">
                        <p>Subtotal</p>
                        <p>₱<?php echo number_format($total, 2); ?></p>
                    </div>
                    <div class="summary-row">
                        <p>Shipping fee</p>
                        <p>Free</p>
                    </div>
                    <hr>
                    <div class="summary-row total-row">
                        <p><strong>Total</strong></p>
                        <p><strong>₱<?php echo number_format($total, 2); ?></strong></p>
                    </div>
                    <hr>
                    <div class="payment-method">
                        <label>Payment Method</label>
                        <input type="text" value="Cash on Delivery" disabled>
                    </div>
                    <hr>
                    <div class="address-summary">
                        <p class="address-label">Delivery Address</p>

                        <?php 
                        $user_id = $_SESSION['user']['id'];

                        $user_check = $conn->prepare("SELECT province, city, unit, barangay FROM users WHERE id = ?");
                        $user_check->bind_param("i", $user_id);
                        $user_check->execute();

                        $user_result = $user_check->get_result();
                        $user = $user_result->fetch_assoc();

                        if(!empty($user['province']) && !empty($user['city']) && !empty($user['unit']) && !empty($user['barangay'])): 
                        ?>
                            <p class="address-text">
                                <?= ($user['unit']); ?>, <?= ($user['barangay']); ?>, <?= ($user['city']); ?>, <?=($user['province']); ?>
                            </p>

                        <?php else: ?>
                            <p class="no-address">
                                No address added yet.
                            </p>
                            <a href="/Hardware_Store_System/pages/customer/edit_user.php" class="add-address-btn">
                                Add Address
                            </a>

                        <?php endif; ?>
                    </div>
                    <?php if(isset($cart_result) && $cart_result->num_rows > 0 && !empty($user['province']) && !empty($user['city']) && !empty($user['unit']) && !empty($user['barangay'])): ?>
                        <hr>
                        <form action="/Hardware_Store_System/backend/process_checkout.php" method="POST">
                            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                            <button type="submit" class="checkout-btn" onclick="return confirm('Confirm your order?')">
                                Proceed to Checkout
                            </button>
                        </form>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>  

<?php else: ?> 

    <div class="login-button-cart">
        <div class="alert-message-login">
            <p>Please log in to manage your items.</p>
        </div>
        <div>
            <a href="/Hardware_Store_System/login.php" class="logincart-btn">
                Login/Signup
            </a>
        </div>
    </div>

<?php endif; ?>  

</main>

</body>
</html>

<?php
include '../../includes/footer.php';
?>