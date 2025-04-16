<?php
session_start();
// Подключение к базе данных
require_once 'db.php';

// Переменная для хранения сообщения об успешной регистрации
$successMessage = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $first_name = trim($_POST['first_name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $againpass = $_POST['againpass'];

    if ($pass !== $againpass) {
        die("Пароли не совпадают.");
    }

    if (empty($first_name) || empty($email) || empty($pass)) {
        die("Все поля должны быть заполнены.");
    }

    // Хеширование пароля
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    $profileImage = null;
    $imageType = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['size'] > 1 * 1024 * 1024) {
            die("Размер изображения слишком большой. Максимальный размер: 1 МБ.");
        }
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $profileImage = $imageData;
        $imageType = $_FILES['image']['type'];
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE first_name = :first_name OR email = :email");
    $stmt->execute([':first_name' => $first_name, ':email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        die("Имя или email уже используются.");
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, email, pass, profile_image, image_type)
            VALUES (:first_name, :email, :pass, :profile_image, :image_type)
        ");
        $stmt->execute([
            ':first_name' => $first_name,
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
            setTimeout(function() {
                window.location.href = 'index.php'; 
            }, 5000);
        </script>
    <?php endif; ?>
</body>
</html>