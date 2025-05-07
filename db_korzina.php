<?php
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';

$korzina_pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$korzina_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>