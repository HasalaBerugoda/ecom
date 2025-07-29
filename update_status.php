<?php
include 'connection.php';


if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = intval($_GET['id']);
    $status = $_GET['status'];
    
    // Validate status
    $valid_statuses = ['processing', 'shipped', 'delivered'];
    if(!in_array($status, $valid_statuses)) {
        header("Location: view_order.php?error=invalid_status");
        exit();
    }
    
    // Update order status
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    
    if($stmt->execute()) {
        // Redirect with success message based on status
        header("Location: view_order.php?$status=1");
    } else {
        header("Location: view_order.php?error=1");
    }
    $stmt->close();
} else {
    header("Location: view_order.php");
}
exit();
?>