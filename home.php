<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>laps.lk</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <nav class="navbar">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>

            <div>
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="product.html">Products</a>
                <a class="btn btn-outline-light me-2" href="contact.html">Contact</a>
                <a class="btn btn-outline-light m" href="about.php">About Us</a>
                

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light m" href="logout.php">
                        Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light m" href="login.php">Login</a>
                <?php endif; ?>

            </div>

        </div>
    </nav>

    <!-- Welcome bord -->
    <div class="cantainer text-black text-center py-5 bgcolor" id="Welcomebord">
        <h1 class="text-center display-4"><strong>Welcome to Laps.lk</strong></h1>
        <p class="text-center lead">Chose your favorite laptop.</p>
    </div>

    <!-- Carousel -->
    <div id="carouselExampleSlidesOnly" class="carousel slide " data-bs-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/12877878/pexels-photo-12877878.jpeg?auto=compress&cs=tinysrgb&w=300" class="d-block w-100" alt="...">

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h3 class="display-6"><strong>Best Laptop Products in Here</strong></h3>
                    <p class="lead"><strong> Top ASUS Laptops Available Now</strong></p>
                    <a class="btn btn-light me-2" href="asus.html">Asus Products</a>
                </div>

            </div>
            <div class="carousel-item">
                <img src="https://media.gettyimages.com/id/1236250965/photo/dell-logo-displayed-on-a-phone-screen-and-a-laptop-keyboard-are-seen-in-this-illustration.jpg?s=612x612&w=0&k=20&c=3MSNjBwnL7rwP19ZKRYWyw6IFgWdahjdqVUVp-x334Q=" class="d-block w-100" alt="...">

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h3 class="display-6"><strong>Best Laptop Products in Here</strong></h3>
                    <p class="lead-"><strong> Top Dell Laptops Available Now</strong></p>
                    <a class="btn btn-light me-2" href="dell.html">Dell Products</a>
                </div>
            </div>
            <div class="carousel-item">

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h3 class="display-6"><strong>Best Laptop Products in Here</strong></h3>
                    <p class="lead"><strong> Top Acer Laptops Available Now</strong></p>
                    <a class="btn btn-light me-2" href="acer.html">Acer Products</a>
                </div>
                <img src="https://media.gettyimages.com/id/2165869781/photo/acer-logo-is-seen-on-a-laptop-in-this-illustration-photo-taken-in-poland-on-august-11-2024.jpg?s=612x612&w=0&k=20&c=4lMy2-3P0xi7e-FSfAqIE7CzhDcr6xk0pdNZ7KUAhTM=" class="d-block w-100" alt="...">
            </div>
        </div>
    </div>
    <!-- carousel end -->

    <!-- patttern -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#1d1d1d" fill-opacity="1" d="M0,256L24,229.3C48,203,96,149,144,122.7C192,96,240,96,288,128C336,160,384,224,432,240C480,256,528,224,576,229.3C624,235,672,277,720,293.3C768,309,816,299,864,266.7C912,235,960,181,1008,186.7C1056,192,1104,256,1152,266.7C1200,277,1248,235,1296,234.7C1344,235,1392,277,1416,298.7L1440,320L1440,0L1416,0C1392,0,1344,0,1296,0C1248,0,1200,0,1152,0C1104,0,1056,0,1008,0C960,0,912,0,864,0C816,0,768,0,720,0C672,0,624,0,576,0C528,0,480,0,432,0C384,0,336,0,288,0C240,0,192,0,144,0C96,0,48,0,24,0L0,0Z"></path></svg>

    <!--We are  -->
    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="https://images.pexels.com/photos/205421/pexels-photo-205421.jpeg?auto=compress&cs=tinysrgb&w=300" alt="Team" class="img-fluid rounded shadow" />
            </div>
            <div class="col-md-6">
                <h2>Who We Are</h2>
                <p>
                    At Laps.lk, we specialize in offering the latest and most reliable laptops from leading brands like
                    ASUS, Dell, HP, and Acer. Our mission is to deliver value, trust, and technology to customers across
                    Sri Lanka.
                </p>
                <p>
                    With over 10 years in the tech retail industry, we’ve built a reputation for quality service and
                    authentic products.
                </p>
            </div>
        </div>
    </section>



    <!-- pattern -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#1d1d1d" fill-opacity="1" d="M0,128L24,154.7C48,181,96,235,144,224C192,213,240,139,288,128C336,117,384,171,432,176C480,181,528,139,576,101.3C624,64,672,32,720,58.7C768,85,816,171,864,192C912,213,960,171,1008,181.3C1056,192,1104,256,1152,266.7C1200,277,1248,235,1296,181.3C1344,128,1392,64,1416,32L1440,0L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z"></path></svg>

    <!-- Homepage Video Section -->
    <div class="container-fluid p-0">
        <div class="video-wrapper position-relative">
            <video class="w-100" autoplay muted loop playsinline>
                <source src="videos/homepage-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div
                class="video-overlay text-white text-center d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4">Our Laptop Store</h1>
                <p class="lead">Top ASUS, Dell, and Acer Laptops Available Now</p>
                <a href="login.php" class="btn btn-outline-light mt-3">Login</a>
            </div>
        </div>
    </div>

    <footer class="footer text-center mt-3 py-3">

        <p><i class="bi bi-c-circle"></i> 2025 NewZone.All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>