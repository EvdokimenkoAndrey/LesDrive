<?php
require_once "db.php";
require_once "db_korzina.php";
session_start();

try {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $transportData = $_POST['transport']; 

    list($transportName, $transportPrice) = explode('|', $transportData);
    $transportPrice = (float)$transportPrice; 

    $userId = $_SESSION['user_id'];

    $stmt = $korzina_pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['product_price'] * $item['quantity'];
    }

    $totalPrice += $transportPrice;

    $orderStmt = $korzina_pdo->prepare("INSERT INTO orders (user_id, name, phone, address, 
    total_price, transport, created_at) VALUES (:user_id, :name, :phone, :address, 
    :total_price, :transport, NOW())");
    $orderStmt->execute([
        'user_id' => $userId,
        'name' => $name,
        'phone' => $phone,
        'address' => $address,
        'total_price' => $totalPrice,
        'transport' => $transportName
    ]);

    $orderId = $korzina_pdo->lastInsertId();

    foreach ($cartItems as $item) {
        $orderItemStmt = $korzina_pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity, service, transport) VALUES (:order_id, :product_name, 
        :product_price, :quantity, :service, :transport)");
        $orderItemStmt->execute([
            'order_id' => $orderId,
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'quantity' => $item['quantity'],
            'service' => $item['service'],
            'transport' => $transportName 
        ]);
    }

    $clearCartStmt = $korzina_pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $clearCartStmt->execute(['user_id' => $userId]);

    header("Location: order_confirmation.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>