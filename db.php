<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "lesdrive_users";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn -> connect_error) {
    die("Ошибка подключения" . mysqli_connect_error());
}