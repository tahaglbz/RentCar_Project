<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Doğru require ifadesi
    require __DIR__ . "/database.php";

    // SQL enjeksiyonunu önlemek için hazırlıklı ifadeler kullanmanız önerilir
    $sql = "SELECT * FROM users WHERE email = '%s'";
    $sql = sprintf($sql, $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    if ($result) {
        $user = $result->fetch_assoc();
        if ($user) {
            // Şifreyi doğrulama
            if (password_verify($_POST["password"], $user["password_hash"])) {
                echo "<p>Login succesfully</p>";
                sleep(2);
                session_start();
                $_SESSION["user_id"] = $user["id"];
                header("Location : /index.html");
                exit;
            }
        } else {
            echo "<p>Not found user</p>";
        }
    }
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

</head>

<body>
    <h1>LOG IN</h1>
    <?php if ($is_invalid): ?>
        <em>Invalid Logib</em>
    <?php endif; ?>


    <form method="post" action="" novalidate>
        <div><label for="email">E-mail</label>
            <input type="text" name="email" placeholder="Enter your email adress"
                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>

        </div>
        <div> <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter passtord">
            <div>
                <button name="submit">Log In</button>
                <a href="signup_page.php">You are not a member?</a>
    </form>
    </div>
</body>

</html>