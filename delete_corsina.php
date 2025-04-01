<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем ID товара из POST-запроса
    $cartItemId = $_POST['cart_item_id'];

    // Удаляем товар из корзины
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :id");
    $stmt->execute(['id' => $cartItemId]);

    // Перенаправляем обратно в корзину
    header("Location: corsina.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>