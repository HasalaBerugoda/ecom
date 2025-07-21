<?php

include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

$id = (int)$_GET['id'];

$result = $conn->query("SELECT * FROM products WHERE id=$id AND user_id=$uid");

$task = $result->fetch_assoc();

if(!$task){
    echo "<script>alert('Task Not Found');</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $_POST['id'];
    $model = $_POST['model'];
    $processor = $_POST['processor'];
    $memory = $_POST['memory'];
    $storage = $_POST['storage'];
    $graphics = $_POST['graphics'];
    $display = $_POST['display'];
    $os = $_POST['os'];
    $ioports = $_POST['ioports'];
    $colours = $_POST['colours'];
    $warranty = $_POST['warranty'];
    $desc = $_POST['description'];
    $brand = $_POST['brand'];
    $status = $_POST['status'];

    $imageName = '';

    if(!empty($_FILES['image']['name'])){
        $imageName = basename($_FILES['image']['name']);
        $targetPath = "images/". $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'],$targetPath)){
            if(!empty($task['image']) && file_exists("images/". $task['image'])){
                unlink("images/". $task['image']);
            }
        }else{
            echo "<script>alert('Failed to upload image Password');</script>";
        }
    }
    
    $update_task = $conn->query("UPDATE products SET model='$model' , processor='$processor' , memory='$memory' , storage='$storage' , graphics='$graphics' , display='$display' , os='$os' , ioports='$ioports' , colours='$colours' , warranty='$warranty' , description='$desc' , brand='$brand' , status='$status' WHERE id='$id' AND user_id='$uid' ");

    if($update_task){
        echo "<script>alert('Task updated successfully');window.location.href='product.php';</script>";        
    }else{
        echo "<script>alert('Failed to update Task');</script>";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body class="container mt-4 ">

<h3>Edit Task</h3>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$task['id']?>">

<div class="mb-3">
    <label>Model</label>
    <input type="text" name="model" class="form-control" value="<?=htmlspecialchars($task['model'])?>" required>
</div>

<div class="mb-3">
    <label>processor</label>
    <input type="text" name="processor" class="form-control" value="<?=htmlspecialchars($task['processor'])?>" required>
</div>

<div class="mb-3">
    <label>Memory</label>
    <input type="text" name="memory" class="form-control" value="<?=htmlspecialchars($task['memory'])?>" required>
</div>

<div class="mb-3">
    <label>storage</label>
    <input type="text" name="storage" class="form-control" value="<?=htmlspecialchars($task['storage'])?>" required>
</div>

<div class="mb-3">
    <label>graphics</label>
    <input type="text" name="graphics" class="form-control" value="<?=htmlspecialchars($task['graphics'])?>" required>
</div>

<div class="mb-3">
    <label>Display</label>
    <input type="text" name="display" class="form-control" value="<?=htmlspecialchars($task['display'])?>" required>
</div>

<div class="mb-3">
    <label>OS</label>
    <input type="text" name="os" class="form-control" value="<?=htmlspecialchars($task['os'])?>" required>
</div>

<div class="mb-3">
    <label>I/O Ports</label>
    <input type="text" name="ioports" class="form-control" value="<?=htmlspecialchars($task['ioports'])?>" required>
</div>

<div class="mb-3">
    <label>colours</label>
    <input type="text" name="colours" class="form-control" value="<?=htmlspecialchars($task['colours'])?>" required>
</div>

<div class="mb-3">
    <label>warranty</label>
    <input type="text" name="warranty" class="form-control" value="<?=htmlspecialchars($task['warranty'])?>" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control"><?=htmlspecialchars($task['description'])?></textarea>
</div>

<div class="mb-3">
    <label>Current Image</label><br>
    <?php if(!empty($task['image'])) :?>
        <img src="images/<?= $task['image']?>" width="100" alt="Task Image">
    <?php else:?>
        <p>No Image</p>
    <?php endif;?>

</div>

<div class="mb-3">
    <label>Change Image (optional)</label>
    <input type="file" name="image" class="form-control">
</div>

<div class="mb-3">
    <label>Brand</label>
    <input type="text" name="brand" class="form-control" value="<?=htmlspecialchars($task['brand'])?>" required>
</div>
<div class="mb-3">
    <label>Status</label>
    <input type="text" name="status" class="form-control" value="<?=htmlspecialchars($task['status'])?>" required>
</div>

<button type="submit" class="btn btn-primary mb-5">Update Task</button>
<a href="product.php" class="btn btn-secondary mb-5"> Cancel</a>

</form>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</html>