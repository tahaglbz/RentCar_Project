<?php
// delete_car.php

include_once "../login-signup/database.php";
session_start();

if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];

    $stmt = $mysqli->prepare("DELETE FROM cars WHERE carId = ?");
    $stmt->bind_param("i", $carId);

    if ($stmt->execute()) {
        echo "Car deleted successfully!";
    } else {
        echo "Error deleting car: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();

    header('Location: manage_cars.php');
    exit;
} else {
    header('Location: manage_cars.php');
    exit;
}
?>
