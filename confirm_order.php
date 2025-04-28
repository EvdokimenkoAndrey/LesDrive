<?php
require_once "db.php";
require_once "db_korzina.php";
session_start();

try {
    // Получаем данные из формы
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $transportData = $_POST['transport']; // Данные о выбранном транспорте

    // Разделяем название транспорта и его цену
    list($transportName, $transportPrice) = explode('|', $transportData);
    $transportPrice = (float)$transportPrice; // Преобразуем цену в число

    // Для примера используем user_id = 1
    $userId = $_SESSION['user_id'];

    // Получаем все товары из корзины
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Вычисляем общую стоимость товаров
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['product_price'] * $item['quantity'];
    }

    // Добавляем стоимость транспорта к общей стоимости
    $totalPrice += $transportPrice;

    // Сохраняем заказ в таблицу orders
    $orderStmt = $pdo->prepare("INSERT INTO orders (user_id, name, phone, address, total_price, transport, created_at) VALUES (:user_id, :name, :phone, :address, :total_price, :transport, NOW())");
    $orderStmt->execute([
        'user_id' => $userId,
        'name' => $name,
        'phone' => $phone,
        'address' => $address,
        'total_price' => $totalPrice,
        'transport' => $transportName // Сохраняем название транспорта
    ]);

    // Получаем ID созданного заказа
    $orderId = $pdo->lastInsertId();

    // Переносим товары из корзины в таблицу order_items
    foreach ($cartItems as $item) {
        $orderItemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity, service, transport) VALUES (:order_id, :product_name, :product_price, :quantity, :service, :transport)");
        $orderItemStmt->execute([
            'order_id' => $orderId,
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'quantity' => $item['quantity'],
            'service' => $item['service'],
            'transport' => $transportName // Сохраняем название транспорта
        ]);
    }

    // Очищаем корзину
    $clearCartStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $clearCartStmt->execute(['user_id' => $userId]);

    // Перенаправляем на страницу подтверждения заказа
    header("Location: order_confirmation.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>