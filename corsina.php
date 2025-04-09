<?php
$host = 'localhost';
$dbname = 'korzina_lesdrive';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = 1;

    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalQuantity = 0;
    $totalPrice = 0;

    foreach ($cartItems as $item) {
        $totalQuantity += $item['quantity'];
        $totalPrice += $item['product_price'] * $item['quantity'];
    }
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
  <link rel="stylesheet" href="login_register.css">
  <title>Корзина</title>
  <style>
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
      width: 85%;
      height: 37%;
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
      gap: 60px;
      margin: 80px auto;
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

    .products_corzina {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    .checkout-form-container {
      display: flex;
      flex-direction: column;
      gap: 35px;
      padding: 40px;
      background-color: #FFF0CA;
      border-radius: 10px;
      width: 30%;
    }

    .checkout-form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .product_corzina {
      display: flex;
      flex-direction: column;
    }

    .zagolovok_order {
      text-align: center;
    }

    .place-order-button {
      padding: 20px;
      border-radius: 10px;
      border: none;
      background-color: #ebd294;
      font-size: 16px;
      cursor: pointer;
    }
    .order-summary {
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 16px;
    color: #555;
}

.order-summary p {
    margin: 0;
}

.order-summary span {
    font-weight: bold;
    color: #333;
}

.place-order-button {
    padding: 20px;
    border-radius: 10px;
    border: none;
    background-color: #ebd294;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.place-order-button:hover {
    background-color: #dabf7a;
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
          <div class="product_corzina">
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
                  <form action="delete_corsina.php" method="POST" class="delete-form">
                    <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                    <button type="submit" class="delete-button">
                      <img src="images/delete-icon.png" alt="Удалить" class="delete-icon">
                    </button>
                  </form>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <div class="checkout-form-container">
            <h2 class="zagolovok_order">Оформление заказа</h2>
            <form action="place_order.php" method="POST" class="checkout-form">
              <div class="order-summary">
                <p>Количество товаров: <span class="total-quantity"><?= $totalQuantity ?></span></p>
                <p>Общая стоимость: <span class="total-price"><?= number_format($totalPrice, 2) ?> руб.</span></p>
              </div>
              <button type="submit" class="place-order-button">Перейти к оформлению</button>
            </form>
          </div>
        </div>
      </div>
      <footer>
        <div class="pages">
          <p class="zagolovok-footer">ЛесДрайв</p>
          <div class="categories">
            <div class="first_categories">
              <a href="catalog.php" class="punkts-footer">Каталог</a>
              <a href="services.php" class="punkts-footer">Услуги</a>
              <a href="aboutus.php" class="punkts-footer">О нас</a>
              <a href="comments.php" class="punkts-footer">Отзывы</a>
              <a href="login.php" class="punkts-footer">Войти</a>
            </div>
            <hr>
            <div class="first_categories">
              <a href="pilomaterials.php" class="punkts-footer">Пиломатериалы</a>
              <a href="materials_first.php" class="punkts-footer">Материалы для отделки</a>
              <a href="materials_scnd.php" class="punkts-footer">Строительные материалы</a>
              <a href="tools.php" class="punkts-footer">Инструменты и крепеж</a>
            </div>
          </div>
        </div>
        <div class="information">
          <div class="email_num">
            <div class="email">
              <img src="images/mail.png" class="info_img">
              <a href="mailto:lesdrive@mail.ru" class="address">lesdrive@mail.ru</a>
            </div>
            <div class="email">
              <img src="images/phone.png" class="info_img">
              <a href="tel:+79123456789" class="address">+7 (912) 345-67-89</a>
            </div>
          </div>
          <div class="email_num">
            <div class="email karts">
              <img src="images/karts.png" class="info_img kart">
              <a href="https://yandex.ru/maps/213/moscow/house/protopopovskiy_pereulok_19s12/Z04YcARpTUcPQFtvfXt5cHtqZw==/?indoorLevel=1&ll=37.639428%2C55.781793&z=16.64" class="address">г. Москва, пер. Протопоповский, д. 19 стр. 12, эт/ком 3/13</a>
            </div>
          </div>
        </div>
        <p class="ooo">2024 ООО "Пиломаркет"<br>Информация на сайте не является публичной офертой</p>
      </footer>
  </main>
</body>

</html>