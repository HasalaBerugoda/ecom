<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php?redirect=products.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']); // Basic phone sanitization
    $address = htmlspecialchars(trim($_POST['address']));
    
    // Get product details
    $product_stmt = $conn->prepare("SELECT model, price FROM products WHERE id = ?");
    $product_stmt->bind_param("i", $product_id);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();
    
    if ($product_result->num_rows === 1) {
        $product = $product_result->fetch_assoc();
        $total_price = $product['price'] * $quantity;
        
        // Insert order into database
        $order_stmt = $conn->prepare("INSERT INTO orders (
            product_id, 
            product_name, 
            quantity, 
            price, 
            customer_name, 
            customer_email, 
            customer_phone, 
            shipping_address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $order_stmt->bind_param(
            "isidssss", 
            $product_id,
            $product['model'],
            $quantity,
            $total_price,
            $name,
            $email,
            $phone,
            $address
        );
        
        if ($order_stmt->execute()) {
            // Order successful
            $_SESSION['order_success'] = true;
            $_SESSION['order_id'] = $conn->insert_id;
            header("Location: order_confirmation.php");
            exit();
        } else {
            // Database error
            $_SESSION['order_error'] = "Failed to process your order. Please try again.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        // Product not found
        $_SESSION['order_error'] = "Product not found.";
        header("Location: products.php" . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Invalid request method
    header("Location: products.php");
    exit();
}
?>