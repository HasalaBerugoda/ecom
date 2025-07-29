<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];

    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

header("Location: cart.php");
exit();
?>