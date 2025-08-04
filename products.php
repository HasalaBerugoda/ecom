<?php 
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php?redirect=products.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .status {
            font-weight: bold;
            background-color: green;
        }
        .out {
            background-color: red;
        }
        
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .list-aligned {
            list-style: none;
            padding: 0;
        }

        .list-aligned li {
            display: grid;
            grid-template-columns: 150px 1fr;
            margin-bottom: 1rem;
        }

        .list-aligned li strong {
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 12px;
            
        }

        .card-hov {
            transition: transform 0.3s;
        }

        .card-hov:hover {
            transform: translateY(-5px);
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .btn-details {
            color: white;
            background-color: #1d1d1d;
            border: none;
            border-radius: 5px;
            width: 90%;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            justify-self: center;
            align-items: center;
        }

        .btn-details:hover {
            background-color: rgb(255, 145, 0);
        }

        .btn-order {
            color: white;
            background-color: #6e6e6eff;
            border: none;
            border-radius: 5px;
            width: 80%;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            justify-self: center;
            align-items: center;
        }

        .btn-order:hover {
            background-color: rgb(255, 145, 0);
        }

        .filter-section {
            background-color: #f3f3f3ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .btn-apply {
            color: white;
            background-color: #1d1d1d;
            border: none;
            border-radius: 5px;
            width: 20%;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            display: block;
            justify-self: center;
            align-items: center;
        }

        .btn-apply:hover {
            background-color: rgb(255, 145, 0);
        }
        
        .no-products {
            text-align: center;
            padding: 20px;
            font-size: 1.2rem;
            color: #666;
        }
    </style>
</head>

<body>
    <nav class="navbar ">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div class="d-flex flex-wrap">
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="contact.php">Contact</a>
                <a class="btn btn-outline-light me-2" href="about.php">About Us</a>
                <a class="btn btn-outline-light m" href="order_history.php"><i class="bi bi-bag-fill"></i> Orders</a>
                <a class="btn btn-outline-light m" href="cart.php"><i class="bi bi-cart-fill"></i> Cart</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                         Logout <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <h1 class="text-center">All Products</h1>

        <!-- Filter Section -->
        <div class="filter-section h-100 shadow mt-4">
            <form method="GET" action="products.php">
                <div class="row">
                    <div class="col-md-4">
                        <div class="filter-group">
                            <h5 class="filter-title">Brand</h5>
                            <select class="form-select" name="brand">
                                <option value="">All Brands</option>
                                <option value="Asus" <?= isset($_GET['brand']) && $_GET['brand'] == 'Asus' ? 'selected' : '' ?>>Asus</option>
                                <option value="Dell" <?= isset($_GET['brand']) && $_GET['brand'] == 'Dell' ? 'selected' : '' ?>>Dell</option>
                                <option value="Acer" <?= isset($_GET['brand']) && $_GET['brand'] == 'Acer' ? 'selected' : '' ?>>Acer</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="filter-group">
                            <h5 class="filter-title">Price Range</h5>
                            <div class="price-range-inputs">
                                <input type="number" class="form-control" name="min_price" placeholder="Min" 
                                       value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '' ?>">
                                <input type="number" class="form-control mt-2" name="max_price" placeholder="Max"
                                       value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="filter-group">
                            <h5 class="filter-title">Status</h5>
                            <select class="form-select" name="status">
                                <option value="">All status</option>
                                <option value="in stock" <?= isset($_GET['status']) && $_GET['status'] == 'in stock' ? 'selected' : '' ?>>In Stock</option>
                                <option value="out of stock" <?= isset($_GET['status']) && $_GET['status'] == 'out of stock' ? 'selected' : '' ?>>Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn-apply">Apply Filters</button>
                        <a href="products.php" class="btn btn-secondary">Reset Filters</a>
                    </div>
                </div>              
            </form>
        </div>

        <!-- Products Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-3">
            <?php 
            // Build the SQL query based on filters
            $sql = "SELECT * FROM products WHERE 1=1";
            $params = [];
            $types = '';
            
            // Brand filter
            if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                $sql .= " AND brand = ?";
                $params[] = $_GET['brand'];
                $types .= 's';
            }
            
            // Price range filter
            if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
                $sql .= " AND price >= ?";
                $params[] = $_GET['min_price'];
                $types .= 'd';
            }
            if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
                $sql .= " AND price <= ?";
                $params[] = $_GET['max_price'];
                $types .= 'd';
            }
                        
            // Status filter
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $sql .= " AND status = ?";
                $params[] = $_GET['status'];
                $types .= 's';
            }
            
            // Prepare and execute the query
            $stmt = $conn->prepare($sql);
            
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $imagePath = 'images/' . htmlspecialchars($row['image']);
                    $statusClass = ($row['status'] === 'in stock') ? 'status' : 'out';
            ?>
                <div class="col">
                    <div class="card-hov card h-100 shadow">
                        <span class="badge position-absolute top-0 end-0 m-2 <?= $statusClass ?>">
                            <?= ucfirst(htmlspecialchars($row['status'])) ?>
                        </span>
                        <img class="card-img-top" src="<?= $imagePath ?>" alt="Product Image">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($row['model']) ?></h6>
                            <p class="card-text text-danger mb-0">Rs. <?= isset($row['price']) ? number_format(htmlspecialchars($row['price']), 2) : 'N/A' ?></p>
                            <?php if (!empty($row['old_price'])): ?>
                                <small class="text-muted text-decoration-line-through">Rs. <?= number_format(htmlspecialchars($row['old_price']), 2) ?></small>
                            <?php endif; ?>
                            <button class="btn-details" data-bs-toggle="modal" data-bs-target="#productModal<?= $row['id'] ?>">
                                More Details
                            </button>
                            <button class="btn-order" data-bs-toggle="modal" data-bs-target="#orderModal<?= $row['id'] ?>">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Modal -->
                <div class="modal fade" id="productModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="productModalLabel<?= $row['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4 text-center" id="productModalLabel<?= $row['id'] ?>"><?= htmlspecialchars($row['model']) ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['model']) ?>" class="img-fluid mb-3" style="max-height: 250px;">
                                    <p><strong><?= htmlspecialchars($row['description']) ?></strong></p>
                                </div>
                            
                                <h5><strong>Product Specification</strong></h5><br>
                                <ul class="list-aligned">
                                    <li><strong>Model:</strong> <?= htmlspecialchars($row['model']) ?></li>
                                    <li><strong>Processor:</strong> <?= htmlspecialchars($row['processor']) ?></li>
                                    <li><strong>Memory:</strong> <?= htmlspecialchars($row['memory']) ?></li>
                                    <li><strong>Storage:</strong> <?= htmlspecialchars($row['storage']) ?></li>
                                    <li><strong>Graphics:</strong> <?= htmlspecialchars($row['graphics']) ?></li>
                                    <li><strong>Display:</strong> <?= htmlspecialchars($row['display']) ?></li>
                                    <li><strong>OS:</strong> <?= htmlspecialchars($row['os']) ?></li>
                                    <li><strong>I/O Ports:</strong> <?= htmlspecialchars($row['ioports']) ?></li>
                                    <li><strong>Color:</strong> <?= htmlspecialchars($row['colours']) ?></li>
                                    <li><strong>Warranty:</strong> <?= htmlspecialchars($row['warranty']) ?></li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#orderModal<?= $row['id'] ?>">Place Order</button>
                                <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#cartModal<?= $row['id'] ?>">Add Cart</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Modal -->
                <div class="modal fade" id="orderModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="orderModalLabel<?= $row['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4 text-center" id="orderModalLabel<?= $row['id'] ?>">Order <?= htmlspecialchars($row['model']) ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="process_order.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="number" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Shipping Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn-details">Confirm Order</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Modal -->
                <div class="modal fade" id="cartModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="cartModalLabel<?= $row['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4 text-center" id="cartModalLabel<?= $row['id'] ?>">Add <?= htmlspecialchars($row['model']) ?> to Cart</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['model']) ?>">
                                    <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                                    <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['image']) ?>">
                                    
                                    <div class="mb-3">
                                        <label for="cart_quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="cart_quantity" name="quantity" min="1" value="1" required>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn-details">Add to Cart</button><br>
                                        <button type="button" class="btn-apply" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php 
                endwhile;
            else:
                echo '<div class="container text-center"><div class="no-products">No products found matching your criteria!</div></div>';
            endif;

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

    <footer class="footer text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0"><i class="bi bi-c-circle"></i> 2025 NewZone. All rights reserved.</p>
        </div>
    </footer>

    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>