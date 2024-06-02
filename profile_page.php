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

    // Eğer form gönderildiyse, bakiyeyi güncelle
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBalance"])) {
        $newBalance = $_POST["addBalance"];
        $userId = $_SESSION["user_id"];

        // Güncel bakiyeyi al ve yeni bakiyeyi ekleyerek güncelle
        $sql = "UPDATE users SET balance = balance + ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("di", $newBalance, $userId);
            if ($stmt->execute()) {
                // Başarılı bir şekilde güncellendi
                // Yeniden kullanıcı verilerini almak için yönlendirme yapılabilir
                header("Location: /profile_page.php");
                exit;
            } else {
                echo "<p>Database error: Unable to update balance.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Database error: Unable to prepare statement.</p>";
        }
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
    <title>User Profile</title>
    <link rel="stylesheet" href="profile_page.css">
</head>

<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <div class="card text-center ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <button id="profile" onclick="showProfile()" class="nav-link text-dark active "><b>Profile Info</b>
                    </button>
                </li>
                <li class="nav-item">
                    <button id="balance" onclick="showBalance()" class="nav-link text-dark"><b>Add Balance</b> </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" ">...</a>
                </li>
            </ul>
        </div>
        <div class=" card-body" id="profileText">
                        <?php if (isset($user)): ?>
                            <h1 class="card-title text-danger">Welcome, <?= htmlspecialchars($user["username"]); ?>!</h1>
                            <p class="card-text">You can control your registiration infos</p>
                            <p class="card-title"><b> Your Email Adress :</b>
                                <?= htmlspecialchars($user["email"]); ?></p>
                            <p class="card-title"><b>Your Balance :</b>
                                <?= htmlspecialchars($user["balance"]); ?></p>
                            <p class="card-title"><b>Your Registered Date :</b>
                                <?= htmlspecialchars($user["registeredDate"]); ?>
                            </p>
                        <?php endif; ?>
                        <a href="#" class="btn btn-danger">Go somewhere</a>
        </div>
        <div id="balanceText" class=" card-body">
            <?php if (isset($user)): ?>
                <h1 class="card-title text-danger">Welcome, <?= htmlspecialchars($user["username"]); ?>!</h1>
                <p class="card-text">Balance Operations</p>
                <p class="card-title"><b>Your Balance :</b>
                    <?= htmlspecialchars($user["balance"]); ?> TL</p>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p class="card-title"><b>Balance to ADD :</b>
                    <span><input type="number" name="addBalance"></span>
                </p>
                <button type="submit" class="btn btn-danger">Add Balance</button>
            </form>


        </div>
    </div>
    <script>
        function showBalance() {
            document.getElementById('profile').classList.remove('active');
            document.getElementById('balance').classList.add('active');
            document.getElementById('profileText').style.display = "none";
            document.getElementById('balanceText').style.display = "block";
        }
        function showProfile() {
            document.getElementById('balance').classList.remove('active');
            document.getElementById('profile').classList.add('active');
            document.getElementById('balanceText').style.display = "none";
            document.getElementById('profileText').style.display = "block";
        }
    </script>
</body>

</html>