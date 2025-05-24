<?php
session_start();
require_once 'db.php';
require_once 'db_korzina.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit;
}
try {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];
    $service = $_POST['service'] ?? null;

    $userId = $_SESSION['user_id'];

    $stmt = $korzina_pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id 
    AND product_name = :product_name");
    $stmt->execute(['user_id' => $userId, 'product_name' => $productName]);
    $existingItem = $stmt->fetch();

    if ($existingItem) {
        $newQuantity = $existingItem['quantity'] + 1;
        $updateStmt = $korzina_pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
        $updateStmt->execute(['quantity' => $newQuantity, 'id' => $existingItem['id']]);
    } else {
        $insertStmt = $korzina_pdo->prepare("INSERT INTO cart (user_id, product_name, 
        product_price, product_image, service, quantity) VALUES (:user_id, :product_name, 
        :product_price, :product_image, :service, 1)");
        $insertStmt->execute([
            'user_id' => $userId,
            'product_name' => $productName,
            'product_price' => $productPrice,
            'product_image' => $productImage,
            'service' => $service
        ]);
    }

    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>