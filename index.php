<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    require __DIR__ . "/login-signup/database.php";

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
        } else {
            echo "<p>Database error</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Database error</p>";
    }
} else {
    header("Location: /login_page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <div class="promotion" id="promotion">
        <div class="promotion-inner">
            <h2>KAPTIN FIRSATLARI</h2>
            <p>İlk kiralamadan sonra ikinci kiralama %40 indirimli. SAKIN KAÇIRMA!!!</p>
            <div>
                <button>Beni kampanyaya götür</button>
                <button id="closeButton">İlgilenmiyorum</button>
            </div>
        </div>
    </div>

    <?php if (isset($user)): ?>
        <h1>Welcome, <?= htmlspecialchars($user["username"]); ?>!</h1>
        <p>You are successfully logged in.</p>
    <?php endif; ?>

    <script src="index.js"></script>
</body>

</html>