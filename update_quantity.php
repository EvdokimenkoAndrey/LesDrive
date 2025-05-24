<?php
require_once "db_korzina.php";

try {
    $cartItemId = $_POST['cart_item_id'];
    $action = $_POST['action'];

    $stmt = $korzina_pdo->prepare("SELECT quantity FROM cart WHERE id = :id");
    $stmt->execute(['id' => $cartItemId]);
    $currentQuantity = $stmt->fetchColumn();

    if ($action === 'increase') {
        $newQuantity = $currentQuantity + 1;
    } elseif ($action === 'decrease' && $currentQuantity > 1) {
        $newQuantity = $currentQuantity - 1;
    } else {
        $newQuantity = $currentQuantity;
    }

    $updateStmt = $korzina_pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
    $updateStmt->execute(['quantity' => $newQuantity, 'id' => $cartItemId]);

    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>