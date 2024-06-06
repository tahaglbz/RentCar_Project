<?php
// edit_user.php

include_once "../login-signup/database.php";
session_start();

$cuponId = $cuponCode = $discountRate = $validity = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cuponId = $_POST['cuponId'];
    $cuponCode = $_POST['cuponCode'];
    $discountRate = $_POST['discountRate'];
    $validity = $_POST['validity'];


    // Prepare the insert statement
    $stmt = $mysqli->prepare("INSERT INTO cupons (cuponId, cuponCode, discountRate, validity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $cuponId, $cuponCode, $discountRate, $validity);

    if ($stmt->execute()) {
        echo "Cupon added successfully!";
    } else {
        echo "Error adding cupon: " . $mysqli->error;
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
    <h2>Add Coupon</h2>
    <form action="add_cupon.php" method="post">
        <label for="carId">Coupon ID:</label>
        <input type="number" name="cuponId" value="<?php echo htmlspecialchars($cuponId); ?>">
        
        <label for="cuponCode">Cupon Code:</label>
        <input type="text" id="cuponCode" name="cuponCode" value="<?php echo htmlspecialchars($cuponCode); ?>">
        
        <label for="discountRate">Discount Rate:</label>
        <input type="number" id="discountRate" name="discountRate" value="<?php echo htmlspecialchars($discountRate); ?>">
        
        <label for="validity">Validity:</label>
        <input type="number" id="validity" name="validity" value="<?php echo htmlspecialchars($validity); ?>">
        
        <button type="submit">Add Coupon</button>
    </form>
</body>
</html>