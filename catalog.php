<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="images/logo.png">
  <title>Страница "Каталог"</title>
</head>

<body>
  <main>
    <div class="create-line">
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
      <div class="class-header-img">
        <img src="images/header1.png" class="header-img">
      </div>
    </div>
    <div class="catalogi">
      <div class="two_catalogs">
        <div class="catalog1">
          <a href="materials_first.php">
            <p class="pilom">Пиломатериалы</p>
            <img src="images/pilo.png" class="catalogs">
          </a>
        </div>
        <div class="catalog1">
          <a href="materials_scnd.php">
            <p class="pilom">Материалы для отделки</p>
            <img src="images/mat.png" class="catalogs">
          </a>
        </div>
      </div>
      <div class="two_catalogs">
        <div class="catalog1">
          <a href="materials_third.php">
            <p class="pilom">Строительные материалы</p>
            <img src="images/stroi.png" class="catalogs">
          </a>
        </div>
        <div class="catalog1">
          <a href="materials_forth.php">
            <p class="pilom">Инструменты и крепеж</p>
            <img src="images/instr.png" class="catalogs">
          </a>
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