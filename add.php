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

$imageName = '';

if(isset($_FILES['image'])){
    $imageName = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'],"images/$imageName");
}

$uid = $_SESSION['user_id'] = 1 ;

$result = $conn->query("INSERT INTO products (model,processor,memory,storage,graphics,display,os,ioports,colours,warranty,description,image) VALUES ('$model','$processor','$memory','$storage','$graphics','$display','$os','$ioport','$colours','$warranty','$desc','$imageName')");

if($result){
    echo "<script>alert('Successfully Added');window.location.href='admin.php';</script>";
}else{
    echo "<script>alert('Doesn't Submit');</script>";
}

?>