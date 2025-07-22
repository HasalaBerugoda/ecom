<?php 

include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$model = $_POST['model'];
$processor = $_POST['processor'];
$memory = $_POST['memory'];
$storage = $_POST['storage'];
$graphics = $_POST['graphics'];
$display = $_POST['display'];
$os = $_POST['os'];
$ioport = $_POST['ioports'];
$colours = $_POST['colours'];
$warranty = $_POST['warranty'];
$desc = $_POST['description'];
$brand = $_POST['brand'];
$price = $_POST['price'];

$imageName = '';

if(isset($_FILES['image'])){
    $imageName = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'],"images/$imageName");
}

$uid = $_SESSION['user_id'] ;

$result = $conn->query("INSERT INTO products (user_id,model,processor,memory,storage,graphics,display,os,ioports,colours,warranty,description,image,brand) VALUES ($uid,'$model','$processor','$memory','$storage','$graphics','$display','$os','$ioport','$colours','$warranty','$desc','$imageName','$brand','$price')");

if($result){
    echo "<script>alert('Successfully Added');window.location.href='admin.php';</script>";
}else{
    echo "<script>alert('Doesn't Submit');</script>";
}

?>