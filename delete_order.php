<?php

include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];


$delete = $conn->query("DELETE FROM orders WHERE id=$id ");

if($delete){
    echo "<script>alert('Task Deleted successfully'); window.location.href='view_order.php'; </script>";
}else{
    echo "<script>alert('Failed to Delete task')</script>";
}


?>