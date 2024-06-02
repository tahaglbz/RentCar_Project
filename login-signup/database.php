<?php
$host = "localhost";
$dbname = "users_rentcar";
$username = "root";
$password = "123456";

$mysqli = new mysqli(
    hostname: $host,
    username: $username,
    password: $password,
    database: $dbname
);
if ($mysqli->connect_errno) {
    die("connection error: " . $mysqli->connect_error);
}

return $mysqli;
?>