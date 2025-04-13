<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <!-- <link rel="stylesheet" href="login_register.css"> -->
  <title>Форма регистрации</title>
  <style>
        main {
      gap: 70px;
      flex-grow: 0;
      padding: 0;
    }

    header {
      position: relative;
    }
    .write_comment {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
      padding: 20px;
      background-color: white;
    }
    .texts {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .zagolovok_input {
    border-radius: 10px;
    border: none;
    font-size: 16px;
    padding: 15px;
    font-family: "Open Sans";
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
            <?php
            if (isset($_SESSION['user_id'])) : ?>
              <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" class="korzina profile-image" style="height: 4vw;"></a>
            <?php else: ?>
            <img src="images/LogIn.png" class="korzina"></a>
            <?php endif; ?>
            <a href="corsina.php">
            <img src="images/corsina.png" class="korzina"></a>
          </div>
        </div>
      </header>
      <div class="write_comment">
        <h2>Напишите свой отзыв</h2>
        <div class="texts">
            <input type="text" placeholder="Заголовок" class="zagolovok_input">
            <textarea placeholder="Текст" class="zagolovok_input"></textarea>
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