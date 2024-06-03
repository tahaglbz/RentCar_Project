<?php
session_start();
// Veritabanı bağlantısını dahil et
require __DIR__ . "/login-signup/database.php";

// Kullanıcı oturumu kontrolü
if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
        } else {
            echo "<p>Database error: Unable to fetch user data.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Database error: Unable to prepare statement.</p>";
    }
} else {
    // Kullanıcı oturumu yoksa giriş sayfasına yönlendir
    // header("Location: /login_page.php");
    // exit;
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
        <p>İlk kiralamada %40 indirimli. SAKIN KAÇIRMA!!!</p>
        <div>
            <button><a href="service.php?couponCode=POPUPDİSCOUNT" class="promo-link">Beni kampanyaya götür</a></button>
          
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