<?php
session_start();
include "db.php";
$img = $_POST['image'];
$login = $_POST['login'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$againpass = $_POST['againpass'];

if (empty($img) || empty($login) || empty($email) || empty($pass) || empty($againpass)) {
    echo "Заполните все поля!";
} else {
    if ($pass != $againpass) {
        echo "Пароли не совпадают!";
    } else {
        $sql = "INSERT INTO `users` (image, login, email, pass, againpass) VALUE ('$img', '$login', '$email', '$pass', '$againpass')";
        if ($conn -> query($sql) == TRUE) {
            echo "Вы успешно зарегестрировались";
        } else {
            echo "Ошибка" . $conn -> connect_error;
        }
    }
}
?>