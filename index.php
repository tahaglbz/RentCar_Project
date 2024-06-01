<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>
        <?php
        include_once "source/navbar.php";
        ?>
    </header>


    <div class="promotion" id="promotion">

        <div class="promotion-inner">
            <h2> KAPTIN FIRSATLARI </h2>

            <p>ilk kiralamadan sonra ikinci kiralama %40 indirimli . SAKIN KAÇIRMA !!! </p>
            <div> <button> beni kampanyaya götür </button>
                <button id="closeButton"> ilgilenmiyorum</button>
            </div>


        </div>


    </div>

    </main>
    <script src="index.js"></script>
</body>

</html>