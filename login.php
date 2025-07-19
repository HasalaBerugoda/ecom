<?php
session_start();
$_SESSION['user_logged_in'] = true;
header("Location: home.php");
?>


<!DOCTYPE html>
<html>

    <head>
        <title>Login</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f0f2f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .login {

                background-color: #ffffff;
                border-radius: 10px;
                padding: 30px;
                width: 400px;
                box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
            }

            h1 {

                text-align: center;
                margin-bottom: 40px;
            }

            .index {

                height: 100%;
                background: transparent;
                border: 2px solid rgba(134, 133, 133, 0.336);
                border-radius: 10px;
                font-size: 16px;
                color: #fff;
                padding: 15px;
                margin-bottom: 20px;

            }

            .alert{
                justify-self: center;
                align-item: center;
            }

            input {

                background-color: transparent;
                border: none;
                outline: none;
                font-size: 17px;
                width: 100%;
                padding: 2px 0;

            }

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

            p {
                justify-self: center;
                align-items: center;
            }
        </style>
    </head>

    <body>
        <div class="login">

            <h1>Laps.lk Login</h1>

            <form method = "POST">
                <div class="index">
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="index">
                    <input type="password" name="password" placeholder="Password">
                </div>


                <button type="submit">Login</button>
                <p>Don't have an account?<a href="register.php" class="btn btn-link">Register</a></p>
                
            </form>

            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");

                    if ($check-> num_rows == 1){
                        $row = $check->fetch_assoc();

                        if (password_verify($password, $row['password'])){

                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['user_name'] = $row['name'];
                            $_SESSION['role'] = $row['role'];

                            if($row['role'] == 'admin'){
                                header('Location:admin.php');
                            }
                            else{
                                header('Location:home.php');
                                
                            }
                            exit();

                        }else {
                        echo "<script>alert('Invalid Password');</script>";
                        }
                    }else{
                        echo "<script>alert('Invalid Logging');</script>";
                    }
                }
            ?>

        </div>

    </body>

</html>