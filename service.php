<?php require"/source/serviceDb.php";?>
  
<?php
$sorgu = $pdo -> query("SELECT * cars");

print_r($sorgu);


?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="service.css">
</head>

<body>
<header>
<?php
    include_once "source/navbar.php"; 

?>
</header>






</body>
</html>


