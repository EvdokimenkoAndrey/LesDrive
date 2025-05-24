<?php
session_start();
require_once 'db.php';
require_once 'db_korzina.php';

unset($_SESSION['successMessage']);
unset($_SESSION['errorMessage']);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = trim($_POST['product_name']);
    $productPrice = trim($_POST['product_price']);
    $productCategory = trim($_POST['product_category']);

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/materials/'; 
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']); 

        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            $_SESSION['errorMessage'][] = "Ошибка: Разрешены только файлы JPG, JPEG, PNG и GIF.";
            header("Location: admin.php");
            exit;
        }

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            $productImage = $uploadFile;

            try {
                $stmt = $korzina_pdo->prepare("INSERT INTO products (product_name, product_price, 
                product_image, category) VALUES (:product_name, :product_price, 
                :product_image, :category)");
                $stmt->execute([
                    'product_name' => $productName,
                    'product_price' => $productPrice,
                    'product_image' => $productImage,
                    'category' => $productCategory
                ]);
                $_SESSION['successMessage'] = "Товар успешно добавлен!";
                header("Location: admin.php");
                exit;
            } catch (PDOException $e) {
                $_SESSION['errorMessage'][] = "Ошибка: " . $e->getMessage();
                header("Location: admin.php");
                exit;
            }
        } else {
            $_SESSION['errorMessage'][] = "Ошибка: Не удалось загрузить изображение.";
            header("Location: admin.php");
            exit;
        }
    } else {
        $_SESSION['errorMessage'][] = "Ошибка: Загрузите изображение.";
        header("Location: admin.php");
        exit;
    }
}
?>