<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo "<p>E-posta gereklidir</p>";
        } elseif (strlen($_POST["password"]) < 8) {
            echo "<p>password must be at least 8 characters</p>";
        } elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
            echo "<p>Password must contain at least one letter</p>";
        } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
            echo "<p>Password must contain at least one number</p>";
        } elseif ($_POST["password"] !== $_POST["pass2"]) {
            echo "<p>Passwords must match</p>";
        } else {
            $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $mysqli = require __DIR__ . "/database.php";
            $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $mysqli->stmt_init();
            if (!$stmt->prepare($sql)) {
                echo "<p>SQL error: " . $mysqli->error . "</p>";
            } else {
                $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $password_hash);
                if ($stmt->execute()) {
                    header("Location: /index.html");
                    exit;
                } else {
                    if ($mysqli->errno === 1062) {
                        echo "<p>This email already exists</p>";
                    } else {
                        echo "<p>db errorı: " . $mysqli->error . " (" . $mysqli->errno . ")</p>";
                    }
                }
            }
        }
    }
    ?>

    <h1>SIGN UP</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="enter username" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="enter email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="enter password" required>
        </div>
        <div>
            <label for="pass2">Password Repeat</label>
            <input type="password" name="pass2" id="pass2" placeholder="enter password again" required>
        </div>
        <button name="submit">Sign Up</button>
    </form>
</body>

</html>