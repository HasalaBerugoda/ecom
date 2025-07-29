<?php include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>      
        .table-container {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
                
                <a class="btn btn-outline-light me-2" href="admin.php">Add Products</a>
                <a class="btn btn-outline-light me-2" href="view_product.php">View Products</a>
                <a class="btn btn-outline-light me-2" href="view_order.php">Orders</a>
                <a class="btn btn-outline-light m" href="logout.php">Logout</a>
                
            </div>

        </div>
    </nav>

    <div class= "m-5">
    <!-- Display Tasks -->
    <div class="table-container">
        <h2 class="mb-4">Product Management</h2>
        <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Images</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $uid = $_SESSION['user_id'];
            $res = $conn->query("SELECT * FROM products WHERE user_id = $uid");

            while($row = $res->fetch_assoc()){
                $img = $row['image'] ? "<img scr='images/{$row['image']}' width = '70'>":'NO IMAGE';
                echo "
                <tr>
                <td>{$row['id']}</td>
                <td>{$row['brand']}</td>
                <td>{$row['description']}</td>
                <td>$img</td>
                <td>{$row['status']}</td>
                <td>
                <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-success m-1'>Edit</a>
                <a href='delete_product.php?id={$row['id']}' class='btn btn-sm btn-danger m-1'>Delet</a>
                </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</html>