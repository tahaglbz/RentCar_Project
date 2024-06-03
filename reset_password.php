<?php
session_start();
require __DIR__ . "/login-signup/database.php";

$response = ["success" => false, "error" => ""];

if (isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["newPassword"];
    $repeatPassword = $_POST["repeatPassword"];

    if (strlen($newPassword) < 8) {
        $response["error"] = "Password must be at least 8 characters";
    } elseif (!preg_match("/[a-z]/i", $newPassword)) {
        $response["error"] = "Password must contain at least one letter";
    } elseif (!preg_match("/[0-9]/", $newPassword)) {
        $response["error"] = "Password must contain at least one number";
    } elseif ($newPassword !== $repeatPassword) {
        $response["error"] = "Passwords must match";
    } else {
        $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userId = $_SESSION["user_id"];

        $sql = "UPDATE users SET password_hash = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $password_hash, $userId);
            if ($stmt->execute()) {
                $response["success"] = true;
            } else {
                $response["error"] = "Database error: Unable to update password.";
            }
            $stmt->close();
        } else {
            $response["error"] = "Database error: Unable to prepare statement.";
        }
    }
} else {
    $response["error"] = "Unauthorized access.";
}

echo json_encode($response);

