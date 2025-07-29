<?php 
include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }
        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .quantity-control input {
            width: 60px;
            text-align: center;
            margin: 0 10px;
        }
        .cart-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .btn-checkout {
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div class="d-flex flex-wrap">
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="products.php">Products</a>
                <a class="btn btn-outline-light me-2" href="contact.php">Contact</a>
                <a class="btn btn-outline-light me-2" href="about.php">About Us</a>
                <a class="btn btn-outline-light m" href="order_history.php"><i class="bi bi-bag-fill"></i> Order</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">
                         Logout <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="login.php"> Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="my-4"><i class="bi bi-cart-fill"></i> Your Shopping Cart</h2>
        
        <?php
        $user_id = $_SESSION['user_id'];
        $total = 0;
        
        // Get cart items with product details
        $sql = "SELECT c.*, p.model, p.price, p.image, p.status 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0): ?>
            <div class="row">
                <div class="col-md-8">
                    <?php while ($row = $result->fetch_assoc()): 
                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                        $imagePath = 'images/' . htmlspecialchars($row['image']);
                    ?>
                        <div class="cart-item row align-items-center">
                            <div class="col-md-2">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['model']) ?>" class="cart-item-img">
                            </div>
                            <div class="col-md-6 ">
                                <h5><?= htmlspecialchars($row['model']) ?></h5>
                                <p class="text-danger">Rs. <?= number_format($row['price'], 2) ?></p>
                                <span class="badge <?= $row['status'] === 'in stock' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </div>
                            <div class="col-md-8 quantity-control">
                                <form action="update_cart.php" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <button type="button" class="btn btn-sm btn-outline-secondary decrease-qty">-</button>
                                    <input type="number" name="quantity" value="<?= $row['quantity'] ?>" min="1" class="form-control form-control-sm">
                                    <button type="button" class="btn btn-sm btn-outline-secondary increase-qty">+</button>
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                </form>
                            </div>
                            <div class="col-md-3 m-6">
                                <p class="fw-bold">Rs. <?= number_format($subtotal, 2) ?></p>
                            </div>
                            <div class="col-md-1">
                                <a href="remove_from_cart.php?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-danger">×</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h4>Order Summary</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span>Rs. <?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span>Rs. 0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5>Rs. <?= number_format($total, 2) ?></h5>
                        </div>
                        <a href="checkout.php" class="btn btn-primary btn-checkout">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Your cart is empty. <a href="products.php" class="alert-link">Continue shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer text-center mt-5 py-3 bg-dark text-white">
        <p><i class="bi bi-c-circle"></i> 2025 NewZone. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Quantity control buttons
        document.querySelectorAll('.increase-qty').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.decrease-qty').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.nextElementSibling;
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    </script>
</body>
</html>