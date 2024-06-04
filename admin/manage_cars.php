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
                    <th>Gear Shift</th>
                    <th>Oil</th>
                    <th>Mileage</th>
                    <th>Production Age</th>
                    <th>Price</th>
                    <th>Settings</th>
                </tr>
                <?php
                // Query to select car details
                $sql = "SELECT carId, modal, gearshift, oil, mileage, producitonage, price FROM cars";
                $result = $mysqli->query($sql);

                // Check if query execution was successful
                if ($result) {
                    // Check if there are rows returned
                    if ($result->num_rows > 0) {
                        // Fetch and display each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['carId']}</td>
                                    <td>{$row['modal']}</td>
                                    <td>{$row['gearshift']}</td>
                                    <td>{$row['oil']}</td>
                                    <td>{$row['mileage']}</td>
                                    <td>{$row['producitonage']}</td>
                                    <td>{$row['price']}</td>
                                    <td>
                                        <a href='edit_car.php?carId={$row['carId']}'>Edit</a>
                                        <a href='delete_car.php?carId={$row['carId']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        // Display message if no cars found
                        echo "<tr><td colspan='8'>No cars found</td></tr>";
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
