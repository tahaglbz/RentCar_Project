<?php
include_once "../login-signup/database.php";

$current_page = basename(__FILE__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
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
        <h1>Manage Cars</h1>
        <div class="card">
            <h2>Car List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php
                $sql = "SELECT carId, modal, price FROM cars";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['carId']}</td>
                                <td>{$row['modal']}</td>
                                <td>{$row['price']}</td>
                                <td>
                                    <a href='edit_car.php?id={$row['carId']}'>Edit</a>
                                    <a href='delete_car.php?id={$row['carId']}'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No cars found</td></tr>";
                }
                ?>
            </tabl
