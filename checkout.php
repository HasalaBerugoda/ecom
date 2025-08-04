<?php
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT c.*, p.model, p.price, p.image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

// Calculate total
$total = 0;
$cart_count = $cart_items->num_rows;
while ($item = $cart_items->fetch_assoc()) {
    $total += $item['price'] * $item['quantity'];
}
$cart_items->data_seek(0); // Reset pointer for later use

// Process checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($address)) $errors[] = "Shipping address is required";
    
    if (empty($errors) && $cart_count > 0) {
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Insert each cart item as a separate order
            while ($item = $cart_items->fetch_assoc()) {
                $item_price = $item['price'] * $item['quantity']; // Calculate total price for this item
                
                $order_sql = "INSERT INTO orders (
                    product_id, 
                    product_name, 
                    quantity, 
                    price, 
                    customer_name, 
                    customer_email, 
                    customer_phone, 
                    shipping_address,
                    status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
                
                $order_stmt = $conn->prepare($order_sql);
                
                // Correct parameter binding - all at once with correct types
                $order_stmt->bind_param(
                    "isidssss", 
                    $item['product_id'],
                    $item['model'],
                    $item['quantity'],
                    $item_price,
                    $name,
                    $email,
                    $phone,
                    $address
                );
                
                $order_stmt->execute();
                $order_stmt->close();
            }

            // Clear cart
            $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
            $clear_stmt = $conn->prepare($clear_cart_sql);
            $clear_stmt->bind_param("i", $user_id);
            $clear_stmt->execute();
            $clear_stmt->close();
            
            // Commit transaction
            $conn->commit();
            
            // Store order success in session
            $_SESSION['order_success'] = true;
            $_SESSION['customer_email'] = $email;
            $_SESSION['order_id'] = $conn->insert_id; // Store the last inserted order ID
            
            // Redirect to order confirmation
            header("Location: order_confirmation.php");
            exit();
            
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            $errors[] = "Error processing your order: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .cart-item-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
        }
        .payment-method {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30">
            </a>

            <div class="d-flex flex-wrap">
                <a class="btn btn-outline-light me-2" href="home.php"><i class="bi bi-house"></i> Home</a>
                <a class="btn btn-outline-light me-2" href="products.php"><i class="bi bi-laptop"></i> Products</a>
                <a class="btn btn-outline-light me-2" href="contact.php"><i class="bi bi-envelope"></i> Contact</a>
                <a class="btn btn-outline-light me-2" href="about.php"><i class="bi bi-info-circle"></i> About</a>
                <a class="btn btn-outline-light me-2" href="order_history.php"><i class="bi bi-bag-fill"></i> Orders</a>
                <a class="btn btn-outline-light me-2" href="cart.php"><i class="bi bi-cart-fill"></i> Cart</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="checkout-container">
        <h1 class="my-4"><i class="bi bi-credit-card"></i> Checkout</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <h5><i class="bi bi-exclamation-triangle"></i> Please fix the following errors:</h5>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($cart_count == 0): ?>
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                <h4 class="mt-3">Your cart is empty</h4>
                <p class="mb-0">Browse our products and make your first purchase!</p>
                <a href="products.php" class="btn btn-primary mt-3">
                    <i class="bi bi-cart-plus"></i> Shop Now
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-7">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="bi bi-truck"></i> Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 
                                                    (isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 
                                                    (isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                        value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required><?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?></textarea>
                                </div>
                               
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-check-circle"></i> Place Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="bi bi-receipt"></i> Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group mb-3">
                                <?php while ($item = $cart_items->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="images/<?= htmlspecialchars($item['image']) ?>" class="cart-item-img me-3" alt="<?= htmlspecialchars($item['model']) ?>">
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($item['model']) ?></h6>
                                                <small class="text-muted">Qty: <?= $item['quantity'] ?></small>
                                            </div>
                                        </div>
                                        <span class="text-danger">Rs. <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            
                            <div class="order-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>Rs. <?= number_format($total, 2) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>Rs. 0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h5>Total:</h5>
                                    <h5>Rs. <?= number_format($total, 2) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer text-center mt-5 py-3 bg-dark text-white">
        <p><i class="bi bi-c-circle"></i> 2025 NewZone. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>