<?php
session_start();
require "source/serviceDb.php";

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to proceed.";
    exit;
}

$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Car</title>
    <link rel="stylesheet" href="css/buy.css">
</head>
<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <div class="container">
        <?php
        if (!empty($_GET['carId'])) {
            $carId = $_GET['carId'];
            $discount = !empty($_GET['discount']) ? floatval($_GET['discount']) : 0;

            // Define additional prices based on the oil type
            $oilPrices = [
                'benzin' => 100,
                'kurşunsuz' => 80,
                'redstone' => 120
            ];

            try {
                $stmt = $pdo->prepare("SELECT * FROM cars WHERE carId = :carId");
                $stmt->bindParam(':carId', $carId);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $car = $stmt->fetch(PDO::FETCH_ASSOC);
                    $originalPrice = $car['price'];
                    $oilType = $car['oil'];

                    // Normalize oil type to ensure correct matching
                    $oilType = strtolower(trim($oilType));
                    $oilPrice = isset($oilPrices[$oilType]) ? $oilPrices[$oilType] : 0;

                    echo "<h1>Buying Car: " . htmlspecialchars($car['modal']) . "</h1>";
                    echo "<p><strong>Vites:</strong> " . htmlspecialchars($car['gearshift']) . "</p>";
                    echo "<p><strong>Yakıt:</strong> " . htmlspecialchars($car['oil']) . "</p>";
                    echo "<p><strong>Kilometre:</strong> " . htmlspecialchars($car['mileage']) . "</p>";
                    echo "<p><strong>Üretim Yılı:</strong> " . htmlspecialchars($car['producitonage']) . "</p>";

                    // Display original price and discounted price
                    if ($discount > 0) {
                        $discountedPrice = $originalPrice - ($originalPrice * $discount);
                        echo "<p><strong>Fiyat:</strong> <del>{$originalPrice} TL</del> {$discountedPrice} TL</p>";
                    } else {
                        $discountedPrice = $originalPrice;
                        echo "<p><strong>Fiyat:</strong> {$originalPrice} TL</p>";
                    }

                    // Form for selecting rental days and calculating price
                    echo "<form method='post' action='buy.php?carId={$carId}&discount={$discount}'>";
                    echo "<label for='rentalDays'>Kaç gün kiralayacaksınız?</label>";
                    echo "<input type='number' name='rentalDays' id='rentalDays' min='1' required>";
                    echo "<button type='submit' name='calculate'>Fiyatı Hesapla</button>";
                    echo "</form>";

                    if (isset($_POST['calculate']) && !empty($_POST['rentalDays'])) {
                        $rentalDays = intval($_POST['rentalDays']);
                        $totalDailyPrice = $oilPrice * $rentalDays;
                        $finalDiscountedPrice = $discountedPrice ?? $originalPrice;
                        $finalPrice = $finalDiscountedPrice + $totalDailyPrice;

                        echo "<p><strong>Taban Fiyat:</strong> {$finalDiscountedPrice} TL</p>";
                        echo "<p><strong>Yağ Tipi Fiyatı:</strong> {$oilPrice} TL</p>";
                        echo "<p><strong>Toplam Günlük Fiyat:</strong> {$totalDailyPrice} TL ({$rentalDays} gün için)</p>";
                        echo "<p><strong>Son Fiyat:</strong> {$finalPrice} TL</p>";

                        // Form for confirming purchase
                        echo "<form method='post' action='confirm.php'>";
                        echo "<input type='hidden' name='carId' value='{$carId}'>";
                        echo "<input type='hidden' name='discount' value='{$discount}'>";
                        echo "<input type='hidden' name='finalPrice' value='{$finalPrice}'>";
                        echo "<button type='submit' name='confirm'>Satın Al</button>";
                        echo "</form>";
                    }
                } else {
                    echo "Araba bulunamadı!";
                }
            } catch (PDOException $e) {
                echo "Veri çekme başarısız: " . $e->getMessage();
            }
        } else {
            echo "Geçersiz istek!";
        }
        ?>
    </div>
</body>
</html>
