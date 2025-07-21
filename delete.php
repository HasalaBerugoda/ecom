<?php

include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$uid = $_SESSION['user_id'];

$delete = $conn->query("DELETE FROM products WHERE id=$id AND user_id=$uid");

if($delete){
    echo "<script>alert('Task Deleted successfully'); window.location.href='product.php'; </script>";
}else{
    echo "<script>alert('Failed to Delete task')</script>";
}


?>