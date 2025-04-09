<?php
// Подключение к базе данных
require_once 'db.php';

// Переменная для хранения сообщения об ошибке
$errorMessage = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $login = trim($_POST['login']);
    $pass = $_POST['pass'];

    // Проверка на пустые поля
    if (empty($login) || empty($pass)) {
        $errorMessage = "Все поля должны быть заполнены.";
    } else {
        // Поиск пользователя в базе данных
        $stmt = $pdo->prepare("SELECT id, login, email, pass, profile_image, image_type FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Проверка пароля
            if (password_verify($pass, $user['pass'])) {
                // Авторизация успешна
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_login'] = $user['login'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['profile_image'] = $user['profile_image']; // Добавляем изображение
                $_SESSION['image_type'] = $user['image_type']; // Добавляем тип изображения

                // Перенаправление на главную страницу после успешной авторизации
                header("Location: login.php");
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
              <img src="images/LogIn.png" class="korzina"></a>
            <a href="corsina.php">
              <img src="images/corsina.png" class="korzina"></a>
          </div>
        </div>
      </header>
    <form action="login-form.php" method="post">
        <div class="form_login">
            <h1 class="zag_login">Войдите в свой аккаунт</h1>
            <div class="inputs">
                <input type="text" class="login" placeholder="Введите логин" name="login" required>
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
              <p class="address">lesdrive@mail.ru</p>
            </div>
            <div class="email">
              <img src="images/phone.png" class="info_img">
              <p class="address">89123456789</p>
            </div>
          </div>
          <div class="email_num">
            <div class="email karts">
              <img src="images/karts.png" class="info_img kart">
              <p class="address">г. Москва, пер. Протопоповский, д. 19 стр. 12, эт/ком 3/13</p>
            </div>
          </div>
        </div>
        <p class="ooo">2024 ООО "Пиломаркет"<br>Информация на сайте не является публичной офертой</p>
      </footer>
  </main>
</body>

</html>