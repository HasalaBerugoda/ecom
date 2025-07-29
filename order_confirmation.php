<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php?redirect=products.php");
        exit();
    }
}

// Get order details
$order_id = $_SESSION['order_id'] ?? null;

if (!$order_id) {
    header("Location: products.php");
    exit();
}

$order_stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order = $order_stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found. Please check your order history or contact support.");
}

// Clear session variables
unset($_SESSION['order_success']);
unset($_SESSION['order_id']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
    
    <nav class="navbar">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div>
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="products.php">Products</a>
                <a class="btn btn-outline-light me-2" href="contact.html">Contact</a>
                <a class="btn btn-outline-light m" href="about.php">About Us</a>
                

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light m" href="logout.php">
                        Logout <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light m" href="login.php">Login</a>
                <?php endif; ?>

            </div>

        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h2>Order Confirmation</h2>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <h4>Thank you for your order!</h4>
                    <p>Your order has been placed successfully. Here are your order details:</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h4>Order Information</h4>
                        <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                        <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['order_date'])) ?></p>
                        <p><strong>Status:</strong> <span class="badge bg-info"><?= ucfirst($order['status']) ?></span></p>
                    </div>
                    <div class="col-md-6">
                        <h4>Product Information</h4>
                        <p><strong>Product:</strong> <?= $order['product_name'] ?></p>
                        <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
                        <p><strong>Total Price:</strong> Rs. <?= number_format($order['price'], 2) ?></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h4>Customer Information</h4>
                    <p><strong>Name:</strong> <?= $order['customer_name'] ?></p>
                    <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
                    <p><strong>Phone:</strong> <?= $order['customer_phone'] ?></p>
                    <p><strong>Shipping Address:</strong> <?= nl2br($order['shipping_address']) ?></p>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    <a href="order_history.php" class="btn btn-secondary">View Order History</a>
                </div>
            </div>
        </div>
    </div>
    
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


</html>