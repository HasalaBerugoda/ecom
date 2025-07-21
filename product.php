<?php include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Products</title>
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
                <a class="btn btn-outline-light me-2" href="admin.php">Add Products</a>
                <a class="btn btn-outline-light me-2" href="product.php">View Products</a>
                <a class="btn btn-outline-light me-2" href="order.php">Orders</a>
                <a class="btn btn-outline-light m" href="logout.php">Logout</a>
                
            </div>

        </div>
    </nav>

    <div class= "m-5">
    <!-- Display Tasks -->
    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Images</th>
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
                <td>
                <a href='update.php?id={$row['id']}' class='btn btn-sm btn-success'>Edit</a>
                <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delet</a>
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