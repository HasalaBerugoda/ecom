<?php
include 'connection.php';

// Initialize variables
$name = $email = $subject = $message = '';
$errors = [];
$success = false;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }

    if (empty($subject)) {
        $errors['subject'] = 'Subject is required';
    }

    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message should be at least 10 characters';
    }

    // If no errors, process the form
    if (empty($errors)) {
        try {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            $stmt->execute();
            
            $success = true;
            
            // Clear form on success
            $name = $email = $subject = $message = '';
            
            // Optional: Send email notification
            /*
            $to = "your@email.com";
            $headers = "From: $email\r\n";
            $email_subject = "New Contact Form Submission: $subject";
            mail($to, $email_subject, $message, $headers);
            */
            
        } catch (Exception $e) {
            $errors['database'] = 'Error submitting your message. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .contact-info-card {
            transition: transform 0.3s;
        }
        .contact-info-card:hover {
            transform: translateY(-5px);
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid py-3">
            <a class="navbar-brand" href="home.php">
                <img src="images/logo.png" alt="Logo" width="100" height="30" class="d-inline-block align-text-top">
            </a>
            
            <div class="d-flex">
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="products.php">Products</a>
                <a class="btn btn-outline-light me-2" href="about.php">About Us</a>
                <a class="btn btn-outline-light m" href="order_history.php"><i class="bi bi-bag-fill"></i> Order</a>
                <a class="btn btn-outline-light me-2" href="cart.php"><i class="bi bi-cart-fill"></i> Cart</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>  Logout <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="login.php">
                        <i class="bi bi-box-arrow-in-right"></i>   Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center mb-5">
                <h1 class="display-5 fw-bold"><i class="bi bi-envelope-paper-heart"></i> Contact Us</h1>
                <p class="lead">Have questions? We'd love to hear from you!</p>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Thank you! Your message has been sent successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (!empty($errors['database'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= $errors['database'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4">
            <!-- Contact Information -->
            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4"><i class="bi bi-info-circle"></i> Our Information</h3>
                        
                        <div class="d-flex flex-column gap-4">
                            <div class="contact-info-card card border-0 shadow-sm p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Address</h5>
                                        <p class="mb-0 text-muted">123 Tech Street, Colombo 01, Sri Lanka</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-card card border-0 shadow-sm p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-telephone-fill text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Phone</h5>
                                        <p class="mb-0 text-muted">+94 76 123 4567</p>
                                        <p class="mb-0 text-muted">+94 11 234 5678</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-card card border-0 shadow-sm p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-envelope-fill text-warning fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Email</h5>
                                        <p class="mb-0 text-muted">support@newzone.lk</p>
                                        <p class="mb-0 text-muted">sales@newzone.lk</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-card card border-0 shadow-sm p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-clock-fill text-info fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Hours</h5>
                                        <p class="mb-0 text-muted">Monday - Friday: 9AM - 6PM</p>
                                        <p class="mb-0 text-muted">Saturday: 10AM - 4PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4"><i class="bi bi-send"></i> Send Us a Message</h3>
                        
                        <form method="POST" action="contact.php">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                           id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
                                    <?php if (isset($errors['name'])): ?>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> <?= $errors['name'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                                    <?php if (isset($errors['email'])): ?>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> <?= $errors['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>" 
                                           id="subject" name="subject" value="<?= htmlspecialchars($subject) ?>" required>
                                    <?php if (isset($errors['subject'])): ?>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> <?= $errors['subject'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>" 
                                              id="message" name="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
                                    <?php if (isset($errors['message'])): ?>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> <?= $errors['message'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="bi bi-send-fill"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0"><i class="bi bi-c-circle"></i> 2025 NewZone. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>