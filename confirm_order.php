<?php
require_once "db.php";
session_start();
// Подключение к базе данных
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из формы
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    // Для примера используем user_id = 1
    $userId = $_SESSION['user_id'];

    // Получаем все товары из корзины
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Сохраняем заказ в таблицу orders
    $orderStmt = $pdo->prepare("INSERT INTO orders (user_id, name, phone, address, total_price, created_at) VALUES (:user_id, :name, :phone, :address, :total_price, NOW())");
    $totalPrice = 0;

    foreach ($cartItems as $item) {
        $totalPrice += $item['product_price'] * $item['quantity'];
    }

    $orderStmt->execute([
        'user_id' => $userId,
        'name' => $name,
        'phone' => $phone,
        'address' => $address,
        'total_price' => $totalPrice
    ]);

    // Получаем ID созданного заказа
    $orderId = $pdo->lastInsertId();

    // Переносим товары из корзины в таблицу order_items
    foreach ($cartItems as $item) {
        $orderItemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity) VALUES (:order_id, :product_name, :product_price, :quantity)");
        $orderItemStmt->execute([
            'order_id' => $orderId,
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'quantity' => $item['quantity']
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