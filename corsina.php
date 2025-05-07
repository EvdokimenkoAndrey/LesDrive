<?php
session_start();
require_once 'db.php';
require_once "db_korzina.php";
try {
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];


    $stmt = $korzina_pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalQuantity = 0;
    $totalPrice = 0;

    foreach ($cartItems as $item) {
      $totalQuantity += $item['quantity'];
      $totalPrice += $item['product_price'] * $item['quantity'];
    }
  }
} catch (PDOException $e) {
  echo '<div class="message-container error-message">
  Ошибка подключения к базе данных: ' . htmlspecialchars($e->getMessage()) . '
</div>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="login_register.css">
  <link rel="stylesheet" href="corsina.css">
  <link rel="icon" href="images/logo.png">
  <title>Корзина</title>
</head>

<body>
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
              <?php
              if (isset($_SESSION['user_id'])) : ?>
                <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" class="korzina profile-image"></a>
          <?php else: ?>
            <img src="images/LogIn.png" class="korzina"></a>
          <?php endif; ?>
          <a href="corsina.php">
            <img src="images/corsina.png" class="korzina"></a>
          </div>
        </div>
      </header>
  <main>
      <div class="corzina">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <div class="error-message error-corsina">
            Для просмотра корзины необходимо&nbsp;
            <a href="login-form.php" style="color: #1987fd;">войти</a>&nbsp;или
            <a href="register-form.php" style="color: #1987fd;">&nbsp;зарегистрироваться</a>.
          </div>
        <?php else: ?>
          <h1 class="zagolovok-offers">Корзина</h1>
          <?php if (empty($cartItems)): ?>
            <div class="empty-cart-container">
              <p class="empty-cart">Ваша корзина пуста.</p>
            </div>
          <?php else: ?>
            <div class="products_corzina">
              <div class="product_corzina">
                <?php foreach ($cartItems as $item): ?>
                  <div class="cart-item">
    <div class="cart-item-top">
        <img src="<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="cart_item_img">
        <div class="cart-item-details">
            <div class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></div>
            <div class="cart-item-price">Цена за шт: <?= number_format($item['product_price'], 2) ?> руб.</div>
            <div class="cart-item-service">
                Услуга: <?= $item['service'] ? htmlspecialchars($item['service']) : 'Без услуги' ?>
            </div>
        </div>
    </div>
    <div class="cart-item-bottom">
        <div class="cart-item-total">Общая цена: <?= number_format($item['product_price'] * $item['quantity'], 2) ?> руб.</div>
        <div class="control">
            <div class="quantity-control">
                <form action="update_quantity" method="POST" class="quantity-form">
                    <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                    <button type="submit" name="action" value="decrease" class="quantity-button minus">-</button>
                    <span class="quantity-value"><?= $item['quantity'] ?></span>
                    <button type="submit" name="action" value="increase" class="quantity-button plus">+</button>
                </form>
            </div>
            <form action="delete_corsina" method="POST" class="delete-form">
                <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                <button type="submit" class="delete-button" style="box-shadow: 0 0 0px;">
                    <img src="images/delete_icon.png" alt="Удалить" class="delete_icon">
                </button>
            </form>
        </div>
    </div>
</div>
                <?php endforeach; ?>
              </div>
              <div class="checkout-form-container">
                <h2 class="zagolovok_order">Оформление заказа</h2>
                <form action="place_order" method="POST" class="checkout-form">
                  <div class="order-summary">
                    <p>Количество товаров: <span class="total-quantity"><?= $totalQuantity ?></span></p>
                    <p>Общая стоимость: <span class="total-price"><?= number_format($totalPrice, 2) ?> руб.</span></p>
                  </div>
                  <button type="submit" class="place-order-button">Перейти к оформлению</button>
                </form>
              </div>
            <?php endif; ?>
          <?php endif; ?>
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
          <a href="login-form.php" class="punkts-footer">Войти</a>
        </div>
        <hr>
        <div class="first_categories">
          <a href="material_first.php" class="punkts-footer">Пиломатериалы</a>
          <a href="materials_scnd.php" class="punkts-footer">Материалы для отделки</a>
          <a href="materials_third.php" class="punkts-footer">Строительные материалы</a>
          <a href="materials_forth.php" class="punkts-footer">Инструменты и крепеж</a>
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