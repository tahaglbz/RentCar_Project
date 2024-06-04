<?php
include_once "../login-signup/database.php";
session_start();

$current_page = basename(__FILE__);

// Handle car update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['carId'])) {
    $carId = $_POST['carId'];
    $modal = $_POST['modal'];
    $gearshift = $_POST['gearshift'];
    $oil = $_POST['oil'];
    $mileage = $_POST['mileage'];
    $producitonage = $_POST['producitonage'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("UPDATE cars SET modal = ?, gearshift = ?, oil = ?, mileage = ?, producitonage = ?, price = ? WHERE carId = ?");
    $stmt->bind_param("sssiiii", $modal, $gearshift, $oil, $mileage, $producitonage, $price, $carId);

    if ($stmt->execute()) {
        echo "Car updated successfully!";
    } else {
        echo "Error updating car: " . $mysqli->error;
    }

    $stmt->close();
}

// Handle car delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['carId'])) {
    $carId = $_GET['carId'];

    $stmt = $mysqli->prepare("DELETE FROM cars WHERE carId = ?");
    $stmt->bind_param("i", $carId);

    if ($stmt->execute()) {
        echo "Car deleted successfully!";
    } else {
        echo "Error deleting car: " . $mysqli->error;
    }

    $stmt->close();

    header('Location: manage_cars.php');
    exit;
}

// Handle car edit form
$edit_car = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['carId'])) {
    $carId = $_GET['carId'];
    $stmt = $mysqli->prepare("SELECT modal, gearshift, oil, mileage, producitonage, price FROM cars WHERE carId = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $stmt->bind_result($modal, $gearshift, $oil, $mileage, $producitonage, $price);
    $stmt->fetch();
    $edit_car = [
        'carId' => $carId,
        'modal' => $modal,
        'gearshift' => $gearshift,
        'oil' => $oil,
        'mileage' => $mileage,
        'producitonage' => $producitonage,
        'price' => $price
    ];
    $stmt->close();
}

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
        <h1>Manage Cars</h1>
        <div class="card">
        <div><a href="add_car.php"><img src="../image/add.png" alt="add Icon" width="50" height="50"style="float:right" ></a></div>
            <?php if ($edit_car) : ?>
                <h2>Edit Car</h2>
                <form action="manage_cars.php" method="post">
                    <input type="hidden" name="carId" value="<?php echo $edit_car['carId']; ?>">
                    
                    <label for="modal">Model:</label>
                    <input type="text" id="modal" name="modal" value="<?php echo $edit_car['modal']; ?>">
                    
                    <label for="gearshift">Gear Shift:</label>
                    <input type="text" id="gearshift" name="gearshift" value="<?php echo $edit_car['gearshift']; ?>">
                    
                    <label for="oil">Oil:</label>
                    <input type="text" id="oil" name="oil" value="<?php echo $edit_car['oil']; ?>">
                    
                    <label for="mileage">Mileage:</label>
                    <input type="number" id="mileage" name="mileage" value="<?php echo $edit_car['mileage']; ?>">
                    
                    <label for="producitonage">Production Age:</label>
                    <input type="number" id="producitonage" name="producitonage" value="<?php echo $edit_car['producitonage']; ?>">
                    
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo $edit_car['price']; ?>">
                    
                    <button type="submit">Update Car</button>
                </form>
            <?php else : ?>
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
                    $sql = "SELECT carId, modal, gearshift, oil, mileage, producitonage, price FROM cars";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['carId']}</td>
                                    <td>{$row['modal']}</td>
                                    <td>{$row['gearshift']}</td>
                                    <td>{$row['oil']}</td>
                                    <td>{$row['mileage']}</td>
                                    <td>{$row['producitonage']}</td>
                                    <td>{$row['price']}</td>
                                    <td>
                                        <a href='manage_cars.php?action=edit&carId={$row['carId']}'>Edit</a>
                                        <a href='manage_cars.php?action=delete&carId={$row['carId']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No cars found</td></tr>";
                    }
                    ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
