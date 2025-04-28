<?php
session_start();
require_once 'db.php';
require_once 'db_korzina.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = trim($_POST['product_name']);
    $productPrice = trim($_POST['product_price']);

    // Проверяем, был ли загружен файл
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/materials/'; // Папка для хранения изображений
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']); // Полный путь к файлу

        // Проверяем, является ли файл изображением
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "<p style='color: red;'>Ошибка: Разрешены только файлы JPG, JPEG, PNG и GIF.</p>";
            exit;
        }

        // Перемещаем файл в папку
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            // Файл успешно загружен
            $productImage = $uploadFile;

            // Добавляем товар в базу данных
            try {
                $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, product_image) VALUES (:product_name, :product_price, :product_image)");
                $stmt->execute([
                    'product_name' => $productName,
                    'product_price' => $productPrice,
                    'product_image' => $productImage
                ]);
                echo "<p style='color: green;'>Товар успешно добавлен!</p>";
            } catch (PDOException $e) {
                echo "<p style='color: red;'>Ошибка: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Ошибка: Не удалось загрузить изображение.</p>";
        }
    } else {
        echo "<p style='color: red;'>Ошибка: Загрузите изображение.</p>";
    }
}
?>