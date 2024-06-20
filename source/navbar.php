<?php



if (isset($_GET['logout'])) {

    session_unset();

    session_destroy();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="source/navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <header>
        <nav>
            <ul class="menu">
                <li class="marka"><a href="index.php"><img src="image/car.png" alt="car Icon"></a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="service.php">Rental</a></li>
                <li><a href="contact.php">Contact</a></li>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <img src="image/user.png" alt="">
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile_page.php">Profile</a></li>
                        <li><a class="dropdown-item" href="login-signup/login_page.php">Log In</a></li>
                        <li><a class="dropdown-item" href="login-signup/signup_page.php">Sign Up</a></li>
                        <li><a href="?logout">Log Out</a></li>
                    </ul>
                </div>
            </ul>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>