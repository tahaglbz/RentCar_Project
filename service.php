<?php require"source/serviceDb.php";?>
  


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

<?php

try {
   
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE onSale = 1");
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  
    foreach ($results as $row) {
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

       
        echo "<button style='position: absolute; bottom: 10px; right: 10px;' onclick='showPrice(" . htmlspecialchars($row['price']) . ")'>";
        echo htmlspecialchars($row['price']) . " TL";
        echo "</button>";

        echo "</div>";
    }

} catch (PDOException $e) {
    echo "Verileri çekme başarısız: " . $e->getMessage();
}

?>
<script>
function showPrice(price) {
    alert("Fiyat: " + price + " TL");
}
</script>

<div>
<div>


</div>
<div>


</div>



</div>






</body>
</html>


