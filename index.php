<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>

    <div class="promotion" id="promotion">
        <div class="promotion-inner">
            <h2>KAPTIN FIRSATLARI</h2>
            <p>İlk kiralamada %40 indirimli. SAKIN KAÇIRMA!!!</p>
            <div>
                <button class="promo-button"><a href="service.php?couponCode=POPUPDİSCOUNT" class="promo-link">Beni kampanyaya götür</a></button>
                <button id="closeButton" class="promo-button">İlgilenmiyorum</button>
            </div>
        </div>
    </div>

<script src="js/index.js"></script>
  <div class="about-us">
        <h2>İstediğin Arabayı Kirala!</h2>
    
        <p>Araba kiralama hizmetimize hoş geldiniz! Şehir içi sürüş için kompakt bir araba veya aile tatili için bir SUV arıyorsanız, ihtiyaçlarınızı karşılayacak geniş bir araç yelpazesi sunuyoruz. Kolay rezervasyon sürecimiz ve esnek kiralama seçeneklerimizle yola çıkmayı basit hale getiriyoruz. Bir sonraki yolculuğunuzda bize güvenin!</p>
        <button ><a href="service.php" > Kiralama </a></button>
    </div>
    
  
   
</body>

</html>
