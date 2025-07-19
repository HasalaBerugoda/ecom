<?php include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>

    <!-- Display Tasks -->
    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titlec</th>
                <th>Description</th>
                <th>Images</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $uid = $_SESSION['user_id'] = $row['id'];
            $res = $conn->query("SELECT * FROM task WHERE user_id = $uid");

            while($row = $res->fetch_assoc()){
                $img = $row['image'] ? "<img scr='uploads/{$row['image']}' width = '70'>":'NO IMAGE';
                echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>$img</td>
                <td>{$row['created_at']}</td>
                <td>
                <a href='update.php?id={$row['id']}' class='btn btn-sm btn-success'>Edit</a>
                <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delet</a>
                </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</html>