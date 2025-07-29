<?php 
include 'connection.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$message = '';
if(isset($_GET['confirmed'])) {
    $message = '<div class="alert alert-success">Order confirmed successfully!</div>';
} elseif(isset($_GET['shipped'])) {
    $message = '<div class="alert alert-info">Order marked as shipped!</div>';
} elseif(isset($_GET['delivered'])) {
    $message = '<div class="alert alert-success">Order marked as delivered!</div>';
} elseif(isset($_GET['error'])) {
    $message = '<div class="alert alert-danger">Error processing your request</div>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Management</title>
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

        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .action-buttons .btn {
            margin: 2px;
            font-size: 0.8rem;
        }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div>
                
                <a class="btn btn-outline-light me-2" href="admin.php">Add Products</a>
                <a class="btn btn-outline-light me-2" href="view_product.php">View Products</a>
                <a class="btn btn-outline-light me-2" href="view_order.php">Orders</a>
                <a class="btn btn-outline-light" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>    

    <div class="table-container">
        <h2 class="mb-4">Order Management</h2>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_date DESC");
                $stmt->execute();
                $result = $stmt->get_result();
                
                while($row = $result->fetch_assoc()) {
                    $status_class = [
                        'pending' => 'bg-warning',
                        'confirmed' => 'bg-primary',
                        'shipped' => 'bg-info',
                        'delivered' => 'bg-success',
                        'cancelled' => 'bg-danger'
                    ][$row['status']] ?? 'bg-secondary';
                    
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['product_name']} <br>(Qty: {$row['quantity']})</td>
                        <td>Rs. ".number_format($row['price'], 2)."</td>
                        <td>{$row['customer_name']}<br><small>{$row['customer_email']}</small></td>
                        <td>".date('M j, Y', strtotime($row['order_date']))."</td>
                        <td>
                            <span class='status-badge $status_class'>
                                ".ucfirst($row['status'])."
                            </span>
                        </td>
                        <td class='action-buttons'>";
                    
                    // Show appropriate action buttons based on current status
                    switch($row['status']) {
                        case 'pending':
                            echo "<a href='update_status.php?id={$row['id']}&status=processing' class='btn btn-sm btn-primary'>Confirm</a>";
                            break;
                        case 'processing':
                            echo "<a href='update_status.php?id={$row['id']}&status=shipped' class='btn btn-sm btn-info'>Mark as Shipped</a>";
                            break;
                        case 'shipped':
                            echo "<a href='update_status.php?id={$row['id']}&status=delivered' class='btn btn-sm btn-success'>Mark as Delivered</a>";
                            break;
                    }
                    
                    echo "<a href='delete_order.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this order?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>