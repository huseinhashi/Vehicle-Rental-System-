<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/jpg" href="images/logo1.jpg">
    <title>Dalka Rentals</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("includes/db.php");

            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($connection, $_POST['email']);
                $password = mysqli_real_escape_string($connection, $_POST['password']);

                $result = mysqli_query($connection, "SELECT * FROM users WHERE email='$email' AND password='$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if (is_array($row) && !empty($row)) {
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    $_SESSION['contact_number'] = $row['contact_number'];
                    $_SESSION['address'] = $row['address'];
                    if ($_SESSION['role'] === 'admin') {
                        header("Location: admin/index.php");
                    } else if ($_SESSION['role'] === 'user') {
                        header("Location: user/index.php");
                    }
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Wrong Username or Password',
                            }).then(function() {
                                window.location.href = 'index.php';
                            });
                        </script>";
                }
            } else {
                ?>
                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" autocomplete="off">
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off">
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <!-- <div class="links">
                        Don't have an account? <a href="register.php">Sign Up Now</a>
                    </div> -->
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>