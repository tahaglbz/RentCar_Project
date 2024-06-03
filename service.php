<?php require "source/serviceDb.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="service.css">
</head>

<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <form method="post">
        Kupon Kodu: <input type="text" name="couponCode" placeholder="Lütfen kupon kodunu girin" id="popupcoupon">
        <button id="submition" type="submit">Gönder</button>
    </form>

    <?php
    $discount = 0;
    if(!empty($_GET['couponCode']) ){
        $couponCode =$_GET['couponCode'];
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
     
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['couponCode'])) {
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

  

    try {
        $stmt = $pdo->prepare("SELECT * FROM cars WHERE onSale = 1");
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $originalPrice = $row['price'];
            $discountedPrice = $originalPrice - ($originalPrice * $discount);

            echo "<div style='border: 1px solid black; margin-bottom: 10px; margin-left : 10px; padding: 10px; padding-left: 35px; position: relative; width: 100%; height: 220px;'>";

            if (!empty($row['image'])) {
                $imageData = base64_encode($row['image']);
                echo "<img src='data:image/jpeg;base64,{$imageData}' alt='Araba Resmi' style='float: left; width: 200px; height: 200px; display: flex;  align-items: center; justify-content: center;'>";
            } else {
                echo "<div style='float: left; width: 200px; height: 200px; background-color: #ccc; display: flex; align-items: center; justify-content: center;'>";
                echo "Resim Yok";
                echo "</div>";
            }

            echo "<div style='margin-left: 220px;'>";
            echo "<div><strong>İsim Model:</strong> " . htmlspecialchars($row['modal']) . "</div>";
            echo "<div><strong>Vites:</strong> " . htmlspecialchars($row['gearshift']) . "</div>";
            echo "<div><strong>Yakıt:</strong> " . htmlspecialchars($row['oil']) . "</div>";
            echo "<div><strong>Kilometre:</strong> " . htmlspecialchars($row['mileage']) . "</div>";
            echo "<div><strong>Üretim Yılı:</strong> " . htmlspecialchars($row['producitonage']) . "</div>";
            echo "</div>";

            echo "<button style='position: absolute; bottom: 10px; right: 10px;'>";
            if ($discount > 0) {
                echo "<del>{$originalPrice} TL</del> {$discountedPrice} TL";
            } else {
                echo "{$originalPrice} TL";
            }
            echo "</button>";

            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "Verileri çekme başarısız: " . $e->getMessage();
    }
    ?>
</body>
</html>
