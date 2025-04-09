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

    // Вычисляем общее количество товаров и общую стоимость
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
    <title>Оформление заказа</title>
    <style>
        /* body {
            font-family: "Inter", sans-serif;
            background-color: #FCE3A5;
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        } */

        .order-page-container {
            background-color: #FFF0CA;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .order-page-container h1 {
            font-weight: bold;
            color: #333;
            margin-bottom: 40px;
            text-align: center;
        }

        .order-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .order-form label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .order-form input,
        .order-form textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .order-form textarea {
            resize: none;
        }

        .order-summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-summary p {
            margin: 0;
            font-size: 16px;
            color: #555;
        }

        .order-summary span {
            font-weight: bold;
            color: #333;
        }

        .place-order-button {
            padding: 15px;
            border-radius: 5px;
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
    <header>
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
        <div class="order-page-container">
            <h1>Оформление заказа</h1>
            <form action="confirm_order.php" method="POST" class="order-form">
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Телефон:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="address">Адрес доставки:</label>
                <textarea id="address" name="address" rows="4" required></textarea>

                <!-- Информация о заказе -->
                <div class="order-summary">
                    <p>Количество товаров: <span><?= $totalQuantity ?></span></p>
                    <p>Общая стоимость: <span><?= number_format($totalPrice, 2) ?> руб.</span></p>
                </div>

                <button type="submit" class="place-order-button">Подтвердить заказ</button>
            </form>
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