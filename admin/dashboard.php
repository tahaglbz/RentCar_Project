<?php
include_once "../login-signup/database.php";

$current_page = basename(__FILE__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashnav.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="card">
            <h2>Welcome, Admin</h2>
            <p>Use the navigation below to manage users and cars.</p>
            <nav>
                <ul class="dashnav">
                    <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
                    <li><a href="../index.php" class="<?php echo $current_page == '../index.php' ? 'active' : ''; ?>">Main Page</a></li>
                    <li><a href="manage_cars.php" class="<?php echo $current_page == 'manage_cars.php' ? 'active' : ''; ?>">Manage Cars</a></li>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
