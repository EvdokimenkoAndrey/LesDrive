<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Для примера используем user_id = 1
  $userId = 1;

  // Получаем все товары из корзины
  $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
  $stmt->execute(['user_id' => $userId]);
  $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Ошибка: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Корзина</title>
  <style>
    main {
      gap: 70px;
      flex-grow: 0;
      padding: 0;
    }

    header {
      position: relative;
    }

    .cart-item {
      display: flex;
      align-items: center;
      background-color: #FFF0CA;
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 10px;
      width: 65%;
    }

    .cart-item img {
      width: 110px;
      height: 80px;
      object-fit: cover;
      margin-right: 20px;
      border-radius: 8px;
    }

    .cart-item-details {
      flex: 1;
    }

    .cart-item-name {
      font-size: 14px;
      font-weight: bold;
      color: #333;
      width: 30%;
    }

    .cart-item-price {
      font-size: 12px;
      color: #555;
    }

    .cart-item-quantity {
      font-size: 12px;
      color: #555;
    }

    .cart-item-total {
      font-size: 14px;
      font-weight: bold;
      color: #e74c3c;
    }

    .corzina {
      padding: 0 60px;
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 40px;
    }

    .empty-cart {
      text-align: center;
      font-size: 18px;
      color: #777;
    }

    .cart-item-details {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
    }

    .delete-form {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .delete-button {
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
      margin-left: 20px;
    }

    .delete-icon {
      width: 20px;
      height: 20px;
      object-fit: cover;
      filter: brightness(0) saturate(100%) invert(29%) sepia(76%) saturate(2457%) hue-rotate(358deg) brightness(97%) contrast(93%);
      transition: transform 0.3s ease;
      width: 20px;
      height: auto;
    }

    .delete-icon:hover {
      transform: scale(1.2);
    }

    /* Стиль для управления количеством */
    .quantity-control {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }

    .quantity-button {
      background-color: #f4f4f4;
      border: 1px solid #ccc;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background-color 0.3s ease;
    }

    .quantity-button:hover {
      background-color: #e0e0e0;
    }

    .quantity-value {
      font-size: 16px;
      font-weight: bold;
      color: #333;
    }
    .quantity-form {
      display: flex;
      gap: 10px;
      align-items: center;
    }
  </style>
</head>

<body>
  <main>
    <div class="create-line">
      <header style="box-shadow:0px 4px 6px rgba(0, 0, 0, 0.1)">
        <div class="menu">
          <div class="Logo">
            <a href="index.php" class="link_logo">
              <img src="images/logo.png" class="logo">
              <h1 class="zagolovok">ЛесДрайв</h1>
            </a>
          </div>
          <ul>
            <li><a href="catalog.php" class="punkts">Каталог</a></li>
            <li><a href="aboutus.php" class="punkts">О нас</a></li>
            <li><a href="services.php" class="punkts">Услуги</a></li>
            <li><a href="comments.php" class="punkts">Отзывы</a></li>
          </ul>
          <div class="icons">
            <a href="login-form.php">
              <img src="images/LogIn.png" class="korzina"></a>
            <a href="corsina.php">
              <img src="images/corsina.png" class="korzina"></a>
          </div>
        </div>
      </header>
      <div class="corzina">
        <h1 class="zagolovok-offers">Корзина</h1>
        <div class="products_corzina">
          <?php if (empty($cartItems)): ?>
            <p class="empty-cart">Ваша корзина пуста.</p>
          <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
              <div class="cart-item">
                <img src="<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                <div class="cart-item-details">
                  <div class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></div>
                  <div class="cart-item-price">Цена за шт.: <br><?= number_format($item['product_price'], 2) ?> руб.</div>
                  <div class="cart-item-total">Общая цена: <?= number_format($item['product_price'] * $item['quantity'], 2) ?> руб.</div>
                  <div class="quantity-control">
                    <form action="update_quantity.php" method="POST" class="quantity-form">
                      <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                      <button type="submit" name="action" value="decrease" class="quantity-button minus">-</button>
                      <span class="quantity-value"><?= $item['quantity'] ?></span>
                      <button type="submit" name="action" value="increase" class="quantity-button plus">+</button>
                    </form>
                  </div>
                </div>
                <form action="delete_from_cart.php" method="POST" class="delete-form">
                  <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                  <button type="submit" class="delete-button">
                    <img src="images/delete-icon.png" alt="Удалить" class="delete-icon">
                  </button>
                </form>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
  </main>
</body>

</html>