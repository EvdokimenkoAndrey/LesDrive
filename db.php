<?php
$dsb = "mysql:host=localhost;dbname=lesdrive_users";
$name = "root";
$pass = "";

try {
    $pdo = new PDO($dsb, $name, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка " . $e->getMessage();
}
?>