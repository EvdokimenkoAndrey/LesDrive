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

    if ($pass !== $againpass) {
        $errors[] = "Пароли не совпадают.";
    }

    if (empty($first_name) || empty($email) || empty($pass)) {
        $errors[] = "Все поля должны быть заполнены.";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['size'] > 1 * 1024 * 1024) {
            $errors[] = "Размер изображения слишком большой. Максимальный размер: 1 МБ.";
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE 
        first_name = :first_name OR email = :email");
        $stmt->execute([':first_name' => $first_name, ':email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $errors[] = "Имя или email уже используются.";
        }
    }

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

            $user_id = $pdo->lastInsertId();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;
            $_SESSION['profile_image'] = $profileImage;
            $_SESSION['image_type'] = $imageType;

            header("Location: user.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Ошибка при регистрации: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errorMessage'] = $errors; 
        header("Location: registration-form.php");
        exit();
    }
}
?>
