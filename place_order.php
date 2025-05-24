<?php
session_start();
require_once 'db.php';
require_once "db_korzina.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login-form.php");
  exit;
}

try {
  $userId = $_SESSION['user_id'];

  $stmt = $korzina_pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
  $stmt->execute(['user_id' => $userId]);
  $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $totalQuantity = 0;
  $totalPrice = 0;

  foreach ($cartItems as $item) {
    $totalQuantity += $item['quantity'];
    $totalPrice += $item['product_price'] * $item['quantity'];
  }
  $selectedTransport = $_POST['transport'] ?? null;
  $transportPrice = 0;
  $transportName = '';

  if ($selectedTransport) {
    list($transportName, $transportPrice) = explode('|', $selectedTransport);
    $transportPrice = (float)$transportPrice;
  }

  $finalTotalPrice = $totalPrice + $transportPrice;
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
  <link rel="icon" href="images/logo.png">
  <title>Оформление заказа</title>
</head>

<body>
  <header class="header-admin">
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
  <main class="main-admin">
    <div class="order-page-container">
      <h1>Оформление заказа</h1>
      <form action="confirm_order" method="POST" class="order-form">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?= 
        htmlspecialchars($_SESSION['first_name'] ?? '') ?>">

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" value="<?= 
        htmlspecialchars($_SESSION['phone']) ?>">

        <label for="address">Адрес доставки:</label>
        <textarea id="address" name="address" rows="4" required><?= 
        htmlspecialchars($_SESSION['address']) ?></textarea>

        <label for="address">Доставка:</label>
        <div class="delivery-order">
          <div class="three-transports">
            <div class="transport">
              <input type="radio" name="transport" id="truck" class="transport-radio" 
              value="Грузовой автомобиль|500">
              <p class="transports">Грузовой автомобиль (500 руб.)</p>
            </div>
            <div class="transport">
              <input type="radio" name="transport" id="gazel" class="transport-radio" 
              value="Газель|300">
              <p class="transports">Газель (300 руб.)</p>
            </div>
            <div class="transport">
              <input type="radio" name="transport" id="forest-truck" class="transport-radio" 
              value="Лесовоз|700">
              <p class="transports">Лесовоз (700 руб.)</p>
            </div>
          </div>
          <div class="three-transports">
            <div class="transport">
              <input type="radio" name="transport" id="manipulator" class="transport-radio" 
              value="Манипуляторы|600">
              <p class="transports">Манипуляторы (600 руб.)</p>
            </div>
            <div class="transport">
              <input type="radio" name="transport" id="furgon" class="transport-radio" 
              value="Автомобиль с кузовом-фургоном|400">
              <p class="transports">Автомобиль с кузовом-фургоном (400 руб.)</p>
            </div>
            <div class="transport">
              <input type="radio" name="transport" id="refrigerator" class="transport-radio" 
              value="Рефрижераторы|800">
              <p class="transports">Рефрижераторы (800 руб.)</p>
            </div>
          </div>
          <div class="transport">
            <input type="radio" name="transport" id="pickup" class="transport-radio" 
            value="Самовывоз|0">
            <p class="transports">Самовывоз (бесплатно)</p>
          </div>
        </div>

        <div class="pickup-map" style="display: none;">
          <div class="email karts">
            <img src="images/karts.png" class="kart">
            <a href="https://yandex.ru/maps/213/moscow/house/protopopovskiy_pereulok_19s12/Z04YcARpTUcPQFtvfXt5cHtqZw==/?indoorLevel=1&ll=37.639428%2C55.781793&z=16.64" 
            class="address">
              г. Москва, пер. Протопоповский, д. 19 стр. 12, эт/ком 3/13
            </a>
          </div>
        </div>
        <div class="order-summary">
          <p>Количество товаров: <span id="total-quantity"><?= $totalQuantity ?></span></p>
          <p>Стоимость товаров: <span id="product-price"><?= number_format($totalPrice, 2) ?> руб.</span></p>
          <p>Стоимость доставки: <span id="delivery-price">0 руб.</span></p>
          <p>Общая стоимость: <span id="total-price"><?= number_format($totalPrice, 2) ?> руб.</span></p>
        </div>

        <button type="submit" class="place-order-button">Подтвердить заказ</button>
      </form>
    </div>
  </main>
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
  <script src="place_order.js"></script>
</body>

</html>