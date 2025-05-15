<?php
session_start();
require_once 'db.php';

unset($_SESSION['successMessage']);
unset($_SESSION['errorMessage']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $againpass = $_POST['againpass'];

    $errors = [];

    // Проверка совпадения паролей
    if ($pass !== $againpass) {
        $errors[] = "Пароли не совпадают.";
    }

    // Проверка заполненности полей
    if (empty($first_name) || empty($email) || empty($pass)) {
        $errors[] = "Все поля должны быть заполнены.";
    }

    // Проверка загрузки изображения
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['size'] > 1 * 1024 * 1024) {
            $errors[] = "Размер изображения слишком большой. Максимальный размер: 1 МБ.";
        }
    }

    // Проверка уникальности имени и email
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE first_name = :first_name OR email = :email");
        $stmt->execute([':first_name' => $first_name, ':email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $errors[] = "Имя или email уже используются.";
        }
    }

    // Если ошибок нет, регистрируем пользователя
    if (empty($errors)) {
        try {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            $profileImage = null;
            $imageType = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                $profileImage = $imageData;
                $imageType = $_FILES['image']['type'];
            }

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

            // Получаем ID нового пользователя
            $user_id = $pdo->lastInsertId();

            // Сохраняем данные пользователя в сессии
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;
            $_SESSION['profile_image'] = $profileImage;
            $_SESSION['image_type'] = $imageType;

            // Перенаправляем пользователя на страницу личного кабинета
            header("Location: user.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Ошибка при регистрации: " . $e->getMessage();
        }
    }

    // Если есть ошибки, сохраняем их в сессию и перенаправляем обратно на форму регистрации
    if (!empty($errors)) {
        $_SESSION['errorMessage'] = $errors; 
        header("Location: registration-form.php");
        exit();
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
            }, 4000);
        </script>
    <?php endif; ?>
</body>
</html>