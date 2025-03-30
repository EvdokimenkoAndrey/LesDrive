<?php
// Файл: index.php

// Подключение к базе данных
require_once 'db.php';

// Переменная для хранения сообщения об успешной регистрации
$successMessage = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $againpass = $_POST['againpass'];

    // Проверка соответствия паролей
    if ($pass !== $againpass) {
        die("Пароли не совпадают.");
    }

    // Проверка на пустые поля
    if (empty($login) || empty($email) || empty($pass)) {
        die("Все поля должны быть заполнены.");
    }

    // Хеширование пароля
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Обработка загруженного изображения
    $profileImage = null;
    $imageType = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $profileImage = $imageData;
        $imageType = $_FILES['image']['type'];
    }

    // Проверка уникальности логина и email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = :login OR email = :email");
    $stmt->execute([':login' => $login, ':email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        die("Логин или email уже используются.");
    }

    // Вставка данных в базу данных
    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (login, email, pass, profile_image, image_type)
            VALUES (:login, :email, :pass, :profile_image, :image_type)
        ");
        $stmt->execute([
            ':login' => $login,
            ':email' => $email,
            ':pass' => $hashedPass,
            ':profile_image' => $profileImage,
            ':image_type' => $imageType
        ]);

        $successMessage = "Регистрация прошла успешно!";
    } catch (PDOException $e) {
        die("Ошибка при регистрации: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Главная страница</title>
    <style>
        .message {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: 600;
            padding-bottom: 20%;
        }
    </style>
</head>
<body>

    <?php if (!empty($successMessage)): ?>
        <div class="message">
            <?= htmlspecialchars($successMessage) ?>
        </div>
        <script>
            // Через 5 секунд перенаправляем пользователя на главную страницу
            setTimeout(function() {
                window.location.href = 'index.php'; // Укажите путь к главной странице
            }, 5000); // 5000 миллисекунд = 5 секунд
        </script>
    <?php endif; ?>
</body>
</html>