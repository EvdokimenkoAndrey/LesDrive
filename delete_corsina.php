<?php
require_once "db_korzina.php";

try {
    // Получаем ID товара из POST-запроса
    $cartItemId = $_POST['cart_item_id'];

    // Удаляем товар из корзины
    $stmt = $korzina_pdo->prepare("DELETE FROM cart WHERE id = :id");
    $stmt->execute(['id' => $cartItemId]);

    // Перенаправляем обратно в корзину
    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>