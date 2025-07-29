<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Check if product already exists in cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if product exists
        $update_sql = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $update_stmt->execute();
    } else {
        // Insert new cart item
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insert_stmt->execute();
    }

    header("Location: products.php");
    exit();
}
?>