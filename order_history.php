<?php
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=order_history.php");
    exit();
}

// Get user's email - either from session or database
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
} else {
    // Fallback to query database if email not in session
    $user_stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $_SESSION['user_id']);
    $user_stmt->execute();
    $user = $user_stmt->get_result()->fetch_assoc();
    $email = $user['email'] ?? null;
    
    if (!$email) {
        die("Could not retrieve your account information. Please contact support.");
    }
}

// Get user's orders
$sql = "SELECT * FROM orders WHERE customer_email = ? ORDER BY order_date DESC";
$orders_stmt = $conn->prepare($sql);

if (!$orders_stmt) {
    die("Error preparing statement: " . $conn->error);
}

$orders_stmt->bind_param("s", $email);
$orders_stmt->execute();
$orders = $orders_stmt->get_result();

if (!$orders) {
    die("Error getting results: " . $orders_stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>

        .btn-shopping {
            color: white;
            background-color: #1d1d1d;
            border: none;
            border-radius: 5px;
            width: 25%;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            display: block;
            justify-self: center;
            align-items: center;
        }

        .btn-shopping:hover {
            background-color: rgb(255, 145, 0);
        }

        .status-badge {
            min-width: 90px;
            display: inline-block;
            text-align: center;
        }
        .order-row:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar" data-bs-theme="dark">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div class="d-flex">
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="products.php">Products</a>
                <a class="btn btn-outline-light me-2" href="contact.php">Contact</a>
                <a class="btn btn-outline-light me-2" href="about.php">About Us</a>
                <a class="btn btn-outline-light me-2" href="cart.php">
                    <i class="bi bi-cart-fill"></i> Cart
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="login.php">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-clock-history"></i> Your Order History</h2>
            <button href="products.php" class="btn-shopping">
                <i class="bi bi-cart-plus"></i> Continue Shopping
                </button>
        </div>
        
        <?php if ($orders->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr class="order-row">
                            <td>#<?= htmlspecialchars($order['id']) ?></td>
                            <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                            <td><?= htmlspecialchars($order['product_name']) ?></td>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                            <td>Rs. <?= number_format($order['price'], 2) ?></td>
                            <td>
                                <span class="badge rounded-pill status-badge
                                    <?= $order['status'] == 'pending' ? 'bg-warning' : 
                                       ($order['status'] == 'processing' ? 'bg-info' : 
                                       ($order['status'] == 'shipped' ? 'bg-primary' : 'bg-success')) ?>">
                                    <?php 
                                        $icon = match($order['status']) {
                                            'pending' => 'bi-hourglass',
                                            'processing' => 'bi-gear',
                                            'shipped' => 'bi-truck',
                                            'delivered' => 'bi-check-circle',
                                            default => 'bi-question-circle'
                                        };
                                    ?>
                                    <i class="bi <?= $icon ?>"></i> <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                <h4 class="mt-3">You haven't placed any orders yet.</h4>
                <p class="mb-0">Browse our products and make your first purchase!</p>
                <a href="products.php" class="btn btn-primary mt-3">
                    <i class="bi bi-cart-plus"></i> Shop Now
                </a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0"><i class="bi bi-c-circle"></i> 2025 NewZone. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>