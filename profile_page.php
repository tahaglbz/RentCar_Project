<?php
session_start();

require __DIR__ . "/login-signup/database.php";

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
    header("Location: login-signup/login_page.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBalance"])) {
    $newBalance = $_POST["addBalance"];
    $userId = $_SESSION["user_id"];

    $sql = "UPDATE users SET balance = balance + ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("di", $newBalance, $userId);
        if ($stmt->execute()) {

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

    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <button id="profile" onclick="showProfile()" class="nav-link text-dark"><b>Profile Info</b></button>
                </li>
                <li class="nav-item">
                    <button id="balance" onclick="showBalance()" class="nav-link text-dark"><b>Add Balance</b></button>
                </li>
            </ul>
        </div>
        <div class="card-body" id="profileText">
            <?php if (isset($user)): ?>
                <h1 class="card-title text-danger">Welcome, <?= htmlspecialchars($user["username"]); ?>!</h1>
                <p class="card-text">You can control your registration infos</p>
                <p class="card-title"><b>Your Email Address:</b> <?= htmlspecialchars($user["email"]); ?></p>
                <p class="card-title"><b>Your Balance:</b> <?= htmlspecialchars($user["balance"]); ?> TL</p>
                <p class="card-title"><b>Your Registered Date:</b> <?= htmlspecialchars($user["registeredDate"]); ?></p>
            <?php endif; ?>
            <a href="#resetPassword" class="btn btn-danger" onclick="showResetPassword()">Reset Password <img
                    src="image/edit.png" alt="edit png"></a>
        </div>
        <div id="balanceText" class="card-body">
            <?php if (isset($user)): ?>
                <h1 class="card-title text-danger">Welcome, <?= htmlspecialchars($user["username"]); ?>!</h1>
                <p class="card-text">Balance Operations</p>
                <p class="card-title"><b>Your Balance:</b> <?= htmlspecialchars($user["balance"]); ?> TL</p>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p class="card-title"><b>Balance to ADD:</b>
                    <span><input type="number" name="addBalance"></span>
                </p>
                <button type="submit" class="btn btn-danger">Add Balance</button>
            </form>
        </div>

        <div id="resetPasswordText" class="card-body d-none">
            <h1 class="card-title text-danger">Reset Password</h1>
            <form id="resetPasswordForm">
                <p class="card-title"><b>New Password : </b>
                    <span><input type="password" name="newPassword" id="newPassword"></span>
                </p>
                <p class="card-title"><b>Password Repeat :</b>
                    <span><input type="password" name="repeatPassword" id="repeatPassword"></span>
                </p>
                <button type="submit" class="btn btn-danger">Confirm Password</button>
                <p id="passwordError" class="text-danger"></p>
            </form>
        </div>
    </div>
    <script>
        function showBalance() {
            document.getElementById('profile').classList.remove('active');
            document.getElementById('balance').classList.add('active');
            document.getElementById('profileText').classList.add('d-none');
            document.getElementById('balanceText').style.display = "block";
            document.getElementById('resetPasswordText').classList.add('d-none');
        }

        function showProfile() {
            document.getElementById('balance').classList.remove('active');
            document.getElementById('profile').classList.add('active');
            document.getElementById('balanceText').style.display = "none";
            document.getElementById('profileText').classList.remove('d-none');
            document.getElementById('resetPasswordText').classList.add('d-none');
        }

        function showResetPassword() {
            document.getElementById('profile').classList.remove('active');
            document.getElementById('balance').classList.remove('active');
            document.getElementById('profileText').classList.add('d-none');
            document.getElementById('balanceText').style.display = "none";
            document.getElementById('resetPasswordText').classList.remove('d-none');
        }

        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab === 'balance') {
                showBalance();
            } else if (tab === 'resetPassword') {
                showResetPassword();
            } else {
                showProfile();
            }
        }

        document.getElementById('resetPasswordForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const newPassword = document.getElementById('newPassword').value;
            const repeatPassword = document.getElementById('repeatPassword').value;
            const passwordError = document.getElementById('passwordError');

            if (newPassword.length < 8) {
                passwordError.textContent = "Password must be at least 8 characters";
            } else if (!/[a-z]/i.test(newPassword)) {
                passwordError.textContent = "Password must contain at least one letter";
            } else if (!/[0-9]/.test(newPassword)) {
                passwordError.textContent = "Password must contain at least one number";
            } else if (newPassword !== repeatPassword) {
                passwordError.textContent = "Passwords must match";
            } else {
                passwordError.textContent = "";

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'reset_password.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Password changed successfully');
                            showResetPassword();
                        } else {
                            passwordError.textContent = response.error;
                        }
                    } else {
                        passwordError.textContent = 'An error occurred';
                    }
                };
                xhr.send(`newPassword=${encodeURIComponent(newPassword)}&repeatPassword=${encodeURIComponent(repeatPassword)}`);
            }
        });
    </script>
</body>

</html>