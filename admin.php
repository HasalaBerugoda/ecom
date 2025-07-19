<?php include 'connection.php';

// if(!isset($_SESSION['user_id'])){
//     header("Location: login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div>
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="product.php">Add Products</a>
                <a class="btn btn-outline-light me-2" href="order.php">Orders</a>
                <a class="btn btn-outline-light m" href="logout.php">Logout</a>
                
            </div>

        </div>
    </nav>

    <div class="container mt-5">
        <h2>Add Product Details</h2>
     
    <!-- Add Task Form-- -->
    <form action="add.php" method="POST" enctype="multipart/form-data" class="mb-4 mt-3">
        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
        <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
        <input type="file" name="image" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>

    </div>

    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>>

</html>