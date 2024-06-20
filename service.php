<?php require "source/serviceDb.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="css/service.css">
</head>

<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <form method="post">
        Kupon Kodu: <input type="text" name="couponCode" placeholder="Lütfen kupon kodunu girin" id="popupcoupon">
        <button id="submition" type="submit">Gönder</button>
    </form>

    <div id="coupon-message">
        <?php
        $discount = 0;
        if (!empty($_POST['couponCode'])) {
            $couponCode = $_POST['couponCode'];
            try {
                $distmt = $pdo->prepare("SELECT discountRate FROM cupons WHERE cuponCode = :couponCode");
                $distmt->bindParam(':couponCode', $couponCode);
                $distmt->execute();

                if ($distmt->rowCount() > 0) {
                    $coupon = $distmt->fetch(PDO::FETCH_ASSOC);
                    $discount = $coupon['discountRate'] / 100;
                    echo "Kupon kodu geçerli! İndirim oranı: " . ($discount * 100) . "%<br>";
                } else {
                    echo "Geçersiz kupon kodu!<br>";
                }
            } catch (PDOException $e) {
                echo "Kupon kodu kontrol edilirken hata oluştu: " . $e->getMessage();
            }
        }
        ?>
    </div>

    <?php
    try {
        $stmt = $pdo->prepare("SELECT carId, modal, gearshift, oil, mileage, producitonage, price, image FROM cars WHERE onSale = 1");
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $originalPrice = $row['price'];
            $discountedPrice = $originalPrice - ($originalPrice * $discount);

            echo "<div class='car-listing'>";

            if (!empty($row['image'])) {
                $imageData = base64_encode($row['image']);
                echo "<img src='data:image/jpeg;base64,{$imageData}' alt='Araba Resmi'>";
            } else {
                echo "<div class='no-image'>Resim Yok</div>";
            }

            echo "<div class='car-details'>";
            echo "<div><strong>İsim Model:</strong> " . htmlspecialchars($row['modal']) . "</div>";
            echo "<div><strong>Vites:</strong> " . htmlspecialchars($row['gearshift']) . "</div>";
            echo "<div><strong>Yakıt:</strong> " . htmlspecialchars($row['oil']) . "</div>";
            echo "<div><strong>Kilometre:</strong> " . htmlspecialchars($row['mileage']) . "</div>";
            echo "<div><strong>Üretim Yılı:</strong> " . htmlspecialchars($row['producitonage']) . "</div>";
            echo "</div>";

            echo "<a href='buy.php?carId={$row['carId']}&discount={$discount}'>";
            echo "<button>";
            if ($discount > 0) {
                echo "<del>{$originalPrice} TL</del> {$discountedPrice} TL";
            } else {
                echo "{$originalPrice} TL";
            }
            echo "</button>";
            echo "</a>";

            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "Verileri çekme başarısız: " . $e->getMessage();
    }
    ?>
</body>

</html>
