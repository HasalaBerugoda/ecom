<?php 

include 'connection.php';

// if(!isset($_SESSION['user_id'])){
//     header("Location: login.php");
//     exit();
// }

$model = $_POST['model'];
$processor = $_POST['processor'];
$memory = $_POST['memory'];
$storege = $_POST['storege'];
$graphics = $_POST['graphics'];
$display = $_POST['diaplay'];
$os = $_POST['os'];
$ioport = $_POST['i/o ports'];
$colours = $_POST['colours'];
$warranty = $_POST['warranty'];
$desc = $_POST['description'];

$imageName = '';

if(isset($_SESSION['image'])){
    $imageName = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'],"images/$imageName");
}

$uid = $_SESSION['user_id'];

$result = $conn->query("INSERT INTO products (user_id,model,processor,memory,storege,graphics,display,os,i/o ports,colours,warranty,description) VALUES ($uid,'$model','$processor','$memory','$storege','$graphics','$display','$os','$ioport','$colours','$warranty','$desc')");

if($result){
    echo "<script>alert('Successfully Added');</script>";
}else{
    echo "<script>alert('Dosen't Submit');</script>";
}

?>