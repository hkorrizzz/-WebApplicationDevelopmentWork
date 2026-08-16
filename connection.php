<?php
$host = "localhost";
$port = "5432";
$dbname = "catalogdb";
$user = "postgres"; 
$password = "zzzirrokh44K";  

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
    die();
}
?>