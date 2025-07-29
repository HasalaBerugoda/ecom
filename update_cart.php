<?php
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}
?>