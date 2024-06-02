<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $_POST["email"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
            if ($user) {
                if (password_verify($_POST["password"], $user["password_hash"])) {
                    session_start();
                    $_SESSION["user_id"] = $user["id"];
                    header("Location: /index.php");
                    exit;
                } else {
                    $is_invalid = true;
                }
            } else {
                $is_invalid = true;
            }
        } else {
            $is_invalid = true;
        }
        $stmt->close();
    } else {
        $is_invalid = true;
    }
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
        <em>Invalid Login</em>
    <?php endif; ?>

    <form method="post" action="" novalidate>
        <div>
            <label for="email">E-mail</label>
            <input type="text" name="email" placeholder="Enter your email address"
                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
        <div>
            <button name="submit">Log In</button>
            <a href="signup_page.php">You are not a member?</a>
        </div>
    </form>
</body>

</html>