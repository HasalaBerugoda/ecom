<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <style>
        .product {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px;
            width: 250px;
            float: left;
        }
        .status {
            font-weight: bold;
            color: green;
        }
        .out {
            color: red;
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
                <a class="btn btn-outline-light me-2" href="products.php">Products</a>
                <a class="btn btn-outline-light me-2" href="contact.html">Contact</a>
                <a class="btn btn-outline-light m" href="about.php">About Us</a>
                

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light m" href="logout.php">
                        Logout <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light m" href="login.php">Login</a>
                <?php endif; ?>

            </div>

        </div>
    </nav>

    <h1>All Products</h1>
    <?php 
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $imagePath = 'images/' . htmlspecialchars($row['image']);
    ?>
        <div class="product">
            <img src="<?= $imagePath ?>" width="200" height="200" alt="Product Image">
            <h3><?= htmlspecialchars($row['model']) ?></h3>
            <p>Price: <?= isset($row['price']) ? htmlspecialchars($row['price']) : 'N/A' ?></p>
            <p class="status <?= $row['status'] === 'out of stock' ? 'out' : '' ?>">
                <?= ucfirst(htmlspecialchars($row['status'])) ?>
            </p>
        </div>
    <?php 
            endwhile;
        else:
            echo "<script>alert('No product found');</script>";
        endif;

        $conn->close();
    ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>
