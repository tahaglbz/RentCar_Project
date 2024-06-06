<?php
session_start();
require "source/serviceDb.php";

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to proceed.";
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carId = $_POST['carId'];
    $finalPrice = $_POST['finalPrice'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Retrieve the current balance of the user
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['balance'] >= $finalPrice) {
            // Deduct the final price from the user's balance
            $newBalance = $user['balance'] - $finalPrice;
            $stmt = $pdo->prepare("UPDATE users SET balance = :newBalance WHERE id = :userId");
            $stmt->bindParam(':newBalance', $newBalance);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            // Commit transaction
            $pdo->commit();
            
            // Set a message to be displayed
            $title = "Confirmation";
            $message = "Purchase successful! Your new balance is {$newBalance} TL.";
            $redirect = true;
        } else {
            $title = "Error";
            $message = "Insufficient balance.";
            $redirect = false;
        }
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        $title = "Error";
        $message = "Purchase failed: " . $e->getMessage();
        $redirect = false;
    }
} else {
    $title = "Error";
    $message = "Invalid request.";
    $redirect = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="css/confirm.css">
    <?php if ($redirect): ?>
    <meta http-equiv="refresh" content="3;url=index.php">
    <?php else: ?>
    <meta http-equiv="refresh" content="3;url=index.php">
    <?php endif; ?>
</head>
<body>
    <div class="confirmation-box">
        <?php if ($redirect): ?>
        <h1><?= $title ?></h1>
        <?php endif; ?>
        <p><?= htmlspecialchars($message) ?></p>
        <p>You will be redirected to the homepage in 3 seconds...</p>
    </div>
</body>
</html>
