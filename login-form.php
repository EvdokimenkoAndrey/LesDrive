<?php
session_start();
// Подключение к базе данных
require_once 'db.php';
if (isset($_SESSION["user_id"])) {
  if ($_SESSION['role'] === 'admin') {
    header("Location: admin.php");
  } else {
    header("Location: user.php");
  }
}
// Переменная для хранения сообщения об ошибке
$errorMessage = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $first_name = trim($_POST['first_name']);
    $pass = $_POST['pass'];

    // Проверка на пустые поля
    if (empty($first_name) || empty($pass)) {
        $errorMessage = "Все поля должны быть заполнены.";
    } else {
        // Поиск пользователя в базе данных
        $stmt = $pdo->prepare("SELECT id, pass, first_name, last_name, middle_name, phone, address, profile_image, image_type, role FROM users WHERE first_name = :first_name");
        $stmt->execute([':first_name' => $first_name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Проверка пароля
            if (password_verify($pass, $user['pass'])) {
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['first_name'] = $user['first_name'];
              $_SESSION['last_name'] = $user['last_name'];
              $_SESSION['middle_name'] = $user['middle_name'];
              $_SESSION['phone'] = $user['phone'];
              $_SESSION['address'] = $user['address'];
              $_SESSION['profile_image'] = $user['profile_image'];
              $_SESSION['image_type'] = $user['image_type'];
              $_SESSION['role'] = $user['role'];

                if ($_SESSION['role'] === 'admin') {
                  header("Location: admin.php");
                } else {
                  header("Location: user.php");
                }
                exit;
            } else {
                $errorMessage = "Неверный пароль.";
            }
        } else {
            $errorMessage = "Пользователь с таким логином не найден.";
        }
    }
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
  <title>Форма входа</title>
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
      <?php if (!empty($errorMessage)): ?>
        <div class="error-message">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>
    <form action="login-form" method="post">
        <div class="form_login">
            <h1 class="zag_login">Войдите в свой аккаунт</h1>
            <div class="inputs">
                <input type="text" class="login" placeholder="Введите логин" name="first_name" required>
                <input type="password" class="login" placeholder="Введите пароль" name="pass" required>
            </div>
            <button class="bttn-login" type="submit">Войти</button>
            <a href="registration-form.php" class="register_page">Нет аккаунта?</a>
        </div>
    </form>
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