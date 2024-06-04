<?php
// edit_user.php

include_once "../login-signup/database.php";
session_start();

$carId = $modal = $gearshift = $oil = $mileage = $producitonage = $price = $onSale = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $carId = $_POST['carId'];
    $modal = $_POST['modal'];
    $gearshift = $_POST['gearshift'];
    $oil = $_POST['oil'];
    $mileage = $_POST['mileage'];
    $producitonage = $_POST['producitonage'];
    $price = $_POST['price'];
    $onSale = $_POST['onSale'];

    // Prepare the insert statement
    $stmt = $mysqli->prepare("INSERT INTO cars (carId, modal, gearshift, oil, mileage, producitonage, price, onSale) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiiii", $carId, $modal, $gearshift, $oil, $mileage, $producitonage, $price, $onSale);

    if ($stmt->execute()) {
        echo "Car added successfully!";
    } else {
        echo "Error adding car: " . $mysqli->error;
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashnav.css">
</head>
<body>
    <ul class="dashnav">
        <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
        <li><a href="../index.php" class="<?php echo $current_page == '../index.php' ? 'active' : ''; ?>">Main Page</a></li>
        <li><a href="manage_cars.php" class="<?php echo $current_page == 'manage_cars.php' ? 'active' : ''; ?>">Manage Cars</a></li>
        <li><a href="manage_cupons.php" class="<?php echo $current_page == 'manage_cupons.php' ? 'active' : ''; ?>">Manage Coupons</a></li>
    </ul>
    <h2>Add Car</h2>
    <form action="add_car.php" method="post">
        <label for="carId">Car ID:</label>
        <input type="number" name="carId" value="<?php echo htmlspecialchars($carId); ?>">
        
        <label for="modal">Model:</label>
        <input type="text" id="modal" name="modal" value="<?php echo htmlspecialchars($modal); ?>">
        
        <label for="gearshift">Gear Shift:</label>
        <input type="text" id="gearshift" name="gearshift" value="<?php echo htmlspecialchars($gearshift); ?>">
        
        <label for="oil">Oil:</label>
        <input type="text" id="oil" name="oil" value="<?php echo htmlspecialchars($oil); ?>">
        
        <label for="mileage">Mileage:</label>
        <input type="number" id="mileage" name="mileage" value="<?php echo htmlspecialchars($mileage); ?>">
        
        <label for="producitonage">Production Age:</label>
        <input type="number" id="producitonage" name="producitonage" value="<?php echo htmlspecialchars($producitonage); ?>">
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">

        <label for="onSale">Visibility:</label>
        <input type="number" id="onSale" name="onSale" value="<?php echo htmlspecialchars($onSale); ?>">
        
        <button type="submit">Add Car</button>
    </form>
</body>
</html>