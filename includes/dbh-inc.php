<?php

$host = 'localhost:3307';
$db = 'lasalledb';
$charset = 'utf8mb4';
$dsn =  "mysql:host=$host;dbname=$db;charset=$charset";

//"mysql:host=localhost:3307;dbname=lasalledb";
$dbusername = 'root';
$dbpassword = '';

$pdo = new PDO($dsn, $dbusername, $dbpassword);

/*try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "La conexión falló: " . $e->getMessage();
}*/

