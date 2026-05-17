<?php
session_start();
include '../../backend/db_connect.php';
if (!isset($_GET['prod_id'])) {
    header("Location: products.php");
    exit;
}
$prod_id = $_GET['prod_id'];

$stmt = $conn->prepare("SELECT products.*, categories.name AS category_name 
                         FROM products 
                         JOIN categories ON products.category_id = categories.id 
                         WHERE products.id = ?");
$stmt->bind_param("i", $prod_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: products.php");
    exit;
}

include '../../includes/header.php';
?>

<main class="prod-page-container">

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">
            <?php 
            if($_GET['success'] === 'added') echo "Added to cart successfully!";
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

    <div class="prod-card-align">
        <div class="prod-page-card">
            <div class="prod-page-img">
                <img src="/Hardware_Store_System/<?php echo $product['image_path']; ?>" 
                     alt="<?php echo $product['name']; ?>">
            </div>
            <div class="prod-page-details">
                <span class="prod-page-category"><?php echo $product['category_name']; ?></span>
                <?php if(!empty($product['brand'])): ?>
                    <span class="prod-page-brand"><?php echo $product['brand']; ?></span>
                <?php endif; ?>
                <h1 class="prod-page-name"><?php echo $product['name']; ?></h1>
                <p class="prod-page-price">₱<?php echo number_format($product['price'], 2); ?></p>
                <p class="prod-page-stock <?= $product['stock_quantity'] <= 20 ? 'low-stock' : '' ?>">
                    <?php if($product['stock_quantity'] > 0): ?>
                        <?php echo $product['stock_quantity']; ?> left in stock
                    <?php else: ?>
                        Out of stock
                    <?php endif; ?>
                </p>
                <?php if($product['stock_quantity'] > 0): ?>
                    <form action="/Hardware_Store_System/backend/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <div class="qty-container">
                            <label>Quantity</label>
                            <div class="qty-input">
                                <input type="number" name="quantity" value="1" min="1" 
                                       max="<?php echo $product['stock_quantity']; ?>">
                            </div>
                        </div>

                        <?php 
                        if(isset($_SESSION['user'])):
                        ?>
                        <button type="submit" class="add-to-cart-btn">
                            Add to Cart
                        </button>

                        <?php
                        else:
                        ?>        
                        <a href="../../login.php" onclick="add_to_cart_error()" class="add-to-cart-btn">
                            Add to Cart
                        </a>

                        <?php        
                        endif
                        ?>
                    </form>

                <?php else: ?>
                    <button class="add-to-cart-btn disabled" disabled>Out of Stock</button>

                <?php endif; ?>
            </div>
        </div>
        <div class="prod-page-card2">
            <?php if(!empty($product['description'])): ?>
                <div class="prod-page-desc">
                    <h4>Description</h4>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
function add_to_cart_error() {
  alert("Please login first!");
}
</script>

</body>
</html>

<?php
include '../../includes/footer.php';
?>