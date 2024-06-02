<?php

$dsn ="mysql:host=localhost:dbname=user_rentcar";
$dbusername="root";
$dbpassword ="123456";

try {
    $pdo= new  PDO($dsn,$dbusername,$dbusername);
    $pdo ->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTİON);
    
} catch (PDOexception $e) {

    echo "connection failed" .$e->getMessage();

}