<?php

include_once "../login-signup/database.php";
session_start();

if (isset($_GET['cuponId'])) {
    $cuponId = $_GET['cuponId'];

    $stmt = $mysqli->prepare("DELETE FROM cupons WHERE cuponId = ?");
    $stmt->bind_param("i", $cuponId);

    if ($stmt->execute()) {
        echo "Cupon deleted successfully!";
    } else {
        echo "Error deleting cupon: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();

    header('Location: manage_cupons.php');
    exit;
} else {
    header('Location: manage_cupons.php');
    exit;
}
?>
