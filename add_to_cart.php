<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из формы
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];

    // Для примера используем user_id = 1
    $userId = 1;

    // Проверяем, есть ли уже такой товар в корзине
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_name = :product_name");
    $stmt->execute(['user_id' => $userId, 'product_name' => $productName]);
    $existingItem = $stmt->fetch();

    if ($existingItem) {
        // Если товар уже есть, увеличиваем количество
        $newQuantity = $existingItem['quantity'] + 1;
        $updateStmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
        $updateStmt->execute(['quantity' => $newQuantity, 'id' => $existingItem['id']]);
    } else {
        // Если товара нет, добавляем его
        $insertStmt = $pdo->prepare("INSERT INTO cart (user_id, product_name, product_price, product_image, quantity) VALUES (:user_id, :product_name, :product_price, :product_image, 1)");
        $insertStmt->execute([
            'user_id' => $userId,
            'product_name' => $productName,
            'product_price' => $productPrice,
            'product_image' => $productImage
        ]);
    }

    // Перенаправляем обратно на страницу каталога
    header("Location: catalog.php");
    exit();
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>