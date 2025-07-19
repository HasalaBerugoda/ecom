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

    <style>
        button {

            color: rgb(255, 255, 255);
            background-color: rgb(255, 145, 0);
            border: none;
            border-radius: 5px;
            width: 25%;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            justify-self: center;
            align-items: center;

        }

        button:hover {
            background-color: #1d1d1d;
        }
    </style>

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

        <input type="text" name="model" class="form-control mb-3" placeholder="Model" required>
        <input type="text" name="processor" class="form-control mb-3" placeholder="Processor" required>
        <input type="text" name="memory" class="form-control mb-3" placeholder="Memory" required>
        <input type="text" name="storege" class="form-control mb-3" placeholder="Storege" required>
        <input type="text" name="graphics" class="form-control mb-3" placeholder="Graphics" required>
        <input type="text" name="display" class="form-control mb-3" placeholder="Display" required>
        <input type="text" name="os" class="form-control mb-3" placeholder="OS" required>
        <input type="text" name="i/o ports" class="form-control mb-3" placeholder="I/O Ports" required>
        <input type="text" name="colours" class="form-control mb-3" placeholder="Colours" required>
        <input type="text" name="warranty" class="form-control mb-3" placeholder="Warranty" required>

        <textarea name="description" class="form-control mb-3" placeholder="Description" required></textarea>

        <input type="file" name="image" class="form-control mb-3 ">

        <button type="submit" >Add Product</button>
    </form>

    </div>

    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</html>