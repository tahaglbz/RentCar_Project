<?php
// eğer portu değiştirdisen xamp kurlumunda bu şekilde kodu değiştir  ->  "mysql:host=localhost;port=3307;dbname=user_rentcar"
$dsn = "mysql:host=localhost;dbname=user_rentcar";

$dbusername = "root";

$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch (PDOException $e) {
    echo "Bağlantı başarısız: " . $e->getMessage();
}
