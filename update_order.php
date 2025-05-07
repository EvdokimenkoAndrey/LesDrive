<?php
session_start();
require_once "db_korzina.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit;
}

// Проверяем, был ли выбран транспорт
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transport_id'])) {
    $transportId = $_POST['transport_id'];
    $userId = $_SESSION['user_id'];

    try {
        // Получаем информацию о выбранном транспорте
        $stmt = $korzina_pdo->prepare("SELECT * FROM transports WHERE id = :id");
        $stmt->execute(['id' => $transportId]);
        $transport = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$transport) {
            echo "Ошибка: Транспорт не найден.";
            exit;
        }

        // Обновляем заказ пользователя
        $updateStmt = $korzina_pdo->prepare("
            UPDATE order_items 
            SET transport_id = :transport_id 
            WHERE user_id = :user_id
        ");
        $updateStmt->execute([
            'transport_id' => $transportId,
            'user_id' => $userId
        ]);

        // Перенаправляем обратно на страницу оформления заказа
        header("Location: checkout.php");
        exit;
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "Ошибка: Не выбран транспорт.";
}
?>