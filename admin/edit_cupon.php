<?php
// edit_car.php

include_once "../login-signup/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cuponId'])) {
    $cuponId = $_POST['cuponId'];
    $cuponCode = $_POST['cuponCode'];
    $discountRate = $_POST['discountRate'];

    $stmt = $mysqli->prepare("UPDATE cupons SET cuponCode = ?, discountRate = ? WHERE cuponId = ?");
    $stmt->bind_param("ssi", $cuponCode, $discountRate, $cuponId);

    if ($stmt->execute()) {
        echo "Cupon updated successfully!";
    } else {
        echo "Error updating car: " .$mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
} else if (isset($_GET['cuponId'])) {
    $cuponId = $_GET['cuponId'];
    $stmt = $mysqli->prepare("SELECT cuponCode, discountRate FROM cupons WHERE cuponId = ?");
    $stmt->bind_param("i", $cuponId);
    $stmt->execute();
    $stmt->bind_result($cuponCode, $discountRate);
    $stmt->fetch();
    $stmt->close();
} else {
    header('Location: manage_cupons.php');
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
        <li><a href="manage_cupons.php" class="<?php echo $current_page == 'manage_cupons.php' ? 'active' : ''; ?>">Manage Cupons</a></li>
    </ul>
    <div class="container">
        <h1>Edit Cupons</h1>
        <div class="card">
            <form action="edit_cupon.php" method="post">
                <input type="hidden" name="cuponId" value="<?php echo $cuponId; ?>">


                <label for="cuponCode">Cupon:</label>
                <input type="text" id="cuponCode" name="cuponCode" value="<?php echo $cuponCode; ?>">


                <label for="discountRate">Discount Rate:</label>
                <input type="number" id="discountRate" name="discountRate" value="<?php echo $discountRate; ?>">


                <button type="submit">Update Cupon</button>
            </form>
        </div>
    </div>
</body>
</html>