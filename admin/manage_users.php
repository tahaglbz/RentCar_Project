<?php
// manage_users.php

include_once "../login-signup/database.php";
$current_page = basename(__FILE__);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashnav.css">
</head>
<body>
<nav>
        <ul class="dashnav">
                    <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
                    <li><a href="../index.php" class="<?php echo $current_page == '../index.php' ? 'active' : ''; ?>">Main Page</a></li>
                    <li><a href="manage_cars.php" class="<?php echo $current_page == 'manage_cars.php' ? 'active' : ''; ?>">Manage Cars</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Manage Users</h1>
        <div class="card">
            <h2>User List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = $mysqli->query("SELECT id, username, email, balance FROM users");
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['balance']}</td>
                            <td>
                                <a href='edit_user.php?id={$row['id']}'>Edit</a>
                                <a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
