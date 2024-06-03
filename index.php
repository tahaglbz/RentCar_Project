<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="index.css">
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
                <button><a href="service.php?couponCode=POPUPDİSCOUNT" class="promo-link">Beni kampanyaya
                        götür</a></button>

                <button id="closeButton">İlgilenmiyorum</button>
            </div>
        </div>
    </div>



    <script src="index.js"></script>
</body>

</html>