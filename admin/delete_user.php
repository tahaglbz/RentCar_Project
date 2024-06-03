<?php
// delete_user.php

include_once "../login-signup/database.php";
session_start();



if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $$mysqli->error;
    }

    $stmt->close();
    $mysqli->close();

    header('Location: manage_users.php');
    exit;
} else {
    header('Location: manage_users.php');
    exit;
}
?>
