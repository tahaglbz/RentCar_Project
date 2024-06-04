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
            <li><a href="manage_cupons.php" class="<?php echo $current_page == 'manage_cupons.php' ? 'active' : ''; ?>">Manage Cupons</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Manage Cupons</h1>
        <div class="card">
            <div><a href="add_cupon.php"><img src="../image/add.png" alt="add Icon" width="50" height="50"style="float:right" ></a></div>
            <h2>Cupons List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Cupon Code</th>
                    <th>Discount Rate</th>
                    <th>Settings</th>
                </tr>
                <?php

                $sql = "SELECT cuponId, cuponCode, discountRate FROM cupons";
                $result = $mysqli->query($sql);


                if ($result) {
                    // Check if there are rows returned
                    if ($result->num_rows > 0) {
                        // Fetch and display each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['cuponId']}</td>
                                    <td>{$row['cuponCode']}</td>
                                    <td>{$row['discountRate']}</td>
                                    <td>
                                        <a href='edit_cupon.php?cuponId={$row['cuponId']}'>Edit</a>
                                        <a href='delete_cupon.php?cuponId={$row['cuponId']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No cupons found</td></tr>";
                    }
                } else {
                    // Display error message if query fails
                    echo "<tr><td colspan='8'>Error executing query: " . $mysqli->error . "</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
