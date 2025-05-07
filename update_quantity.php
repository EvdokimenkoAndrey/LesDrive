<?php
require_once "db_korzina.php";

try {
    // Получаем данные из POST-запроса
    $cartItemId = $_POST['cart_item_id'];
    $action = $_POST['action'];

    // Получаем текущее количество товара
    $stmt = $korzina_pdo->prepare("SELECT quantity FROM cart WHERE id = :id");
    $stmt->execute(['id' => $cartItemId]);
    $currentQuantity = $stmt->fetchColumn();

    if ($action === 'increase') {
        // Увеличиваем количество
        $newQuantity = $currentQuantity + 1;
    } elseif ($action === 'decrease' && $currentQuantity > 1) {
        // Уменьшаем количество, но не ниже 1
        $newQuantity = $currentQuantity - 1;
    } else {
        // Если количество уже равно 1 и нажата кнопка "-", ничего не делаем
        $newQuantity = $currentQuantity;
    }

    // Обновляем количество в базе данных
    $updateStmt = $korzina_pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
    $updateStmt->execute(['quantity' => $newQuantity, 'id' => $cartItemId]);

    // Перенаправляем обратно в корзину
    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>