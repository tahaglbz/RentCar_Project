<?php
// edit_car.php

include_once "../login-signup/database.php";
session_start();

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
        echo "Error updating car: " .$mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
} else if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];
    $stmt = $mysqli->prepare("SELECT modal, gearshift, oil, mileage, producitonage, price FROM cars WHERE carId = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $stmt->bind_result($modal, $gearshift, $oil, $mileage, $producitonage, $price);
    $stmt->fetch();
    $stmt->close();
} else {
    header('Location: manage_cars.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashnav.css">
</head>
<body>
    <ul class="dashnav">
        <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
        <li><a href="../index.php" class="<?php echo $current_page == '../index.php' ? 'active' : ''; ?>">Main Page</a></li>
        <li><a href="manage_cars.php" class="<?php echo $current_page == 'manage_cars.php' ? 'active' : ''; ?>">Manage Cars</a></li>
    </ul>
    <div class="container">
        <h1>Edit Car</h1>
        <div class="card">
            <form action="edit_car.php" method="post">
                <input type="hidden" name="carId" value="<?php echo $carId; ?>">

                <label for="modal">Model:</label>
                <input type="text" id="modal" name="modal" value="<?php echo $modal; ?>">

                <label for="gearshift">Gear Shift:</label>
                <input type="text" id="gearshift" name="gearshift" value="<?php echo $gearshift; ?>">

                <label for="oil">Oil:</label>
                <input type="text" id="oil" name="oil" value="<?php echo $oil; ?>">

                <label for="mileage">Mileage:</label>
                <input type="number" id="mileage" name="mileage" value="<?php echo $mileage; ?>">

                <label for="producitonage">Production Age:</label>
                <input type="number" id="producitonage" name="producitonage" value="<?php echo $producitonage; ?>">

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $price; ?>">

                <button type="submit">Update Car</button>
            </form>
        </div>
    </div>
</body>
</html>