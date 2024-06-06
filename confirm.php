<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation</title>
    <link rel="stylesheet" href="service.css">
    <script>
        function redirectToHomePage() {
            setTimeout(function () {
                window.location.href = 'service.php'; // Change to your home page URL
            }, 3000); // 3 seconds
        }
    </script>
</head>

<body onload="redirectToHomePage()">
    <header>
        <?php include_once "source/navbar.php"; ?>
    </header>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Satın Alım Onaylandı!</h1>
        <p>Satın alımınız başarıyla gerçekleşti.</p>
        <p>Anasayfaya yönlendiriliyorsunuz...</p>
    </div>
</body>

</html>
