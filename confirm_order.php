<?php
include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    
    // Update order status to confirmed
    $stmt = $conn->prepare("UPDATE orders SET status = 'confirmed' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    if($stmt->execute()) {
        header("Location: view_order.php?confirmed=1");
    } else {
        header("Location: view_order.php?error=1");
    }
    $stmt->close();
} else {
    header("Location: view_order.php");
}
exit();
?>