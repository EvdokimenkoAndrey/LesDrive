<?php
require_once "db_korzina.php";

try {
    $cartItemId = $_POST['cart_item_id'];

    $stmt = $korzina_pdo->prepare("DELETE FROM cart WHERE id = :id");
    $stmt->execute(['id' => $cartItemId]);

    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>