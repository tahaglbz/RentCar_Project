<?php
// edit_user.php

include_once "../login-signup/database.php";
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $balance = $_POST['balance'];

    $stmt = $mysqli->prepare("UPDATE users SET username = ?, email = ?, balance = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $username, $email,$balance, $id);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user: " .$mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $mysqli->prepare("SELECT username, email, balance FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $balance );
    $stmt->fetch();
    $stmt->close();
} else {
    header('Location: manage_users.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashnav.css">
</head>
<body>
    <ul class="dashnav">
                    <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
                    <li><a href="../index.php" class="<?php echo $current_page == '../index.php' ? 'active' : ''; ?>">Main Page</a></li>
                    <li><a href="manage_cars.php" class="<?php echo $current_page == 'manage_cars.php' ? 'active' : ''; ?>">Manage Cars</a></li>
                    <li><a href="manage_cupons.php" class="<?php echo $current_page == 'manage_cupons.php' ? 'active' : ''; ?>">Manage Cupons</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Edit User</h1>
        <div class="card">
            <form action="edit_user.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">

                <label for="balance">Balance:</label>
                <input type="number" id="balance" name="balance" step="0.1" value="<?php echo $balance; ?>" required>

                <button type="submit">Update User</button>
            </form>
        </div>
    </div>
</body>
</html>
