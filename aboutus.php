<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="aboutus.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="services.css">
  <link rel="icon" href="images/logo.png">
  <title>О нас</title>
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
    <div class="aboutus">
      <div class="value_mission">
        <div class="value">
          <h1 class="zag_value">Цель</h1>
          <p class="text_value">Поставлять качественные 
            лесоматериалы для реализации проектов клиентов.</p>
        </div>
        <div class="value">
          <h1 class="zag_value">Миссия</h1>
          <p class="text_value">Продвигать экологичность и 
            надежность в строительстве через натуральные материалы.</p>
        </div>
      </div>
      <div class="image">
        <img src="images/services/aboutus.png" class="img_aboutus">
      </div>
    </div>
    <div class="advantages">
      <h1 class="zagolovok-offers">Наши партнеры</h1>
      <div class="classes_advantages">
        <div class="first_advantages">
          <div class="partner">
            <img src="images/services/partner1.png" class="partner_img">
            <p class="name_advantage">Покровъ</p>
          </div>
          <div class="partner">
            <img src="images/services/partner2.png" class="partner_img">
            <p class="name_advantage">Беттерстрой</p>
          </div>
          <div class="partner">
            <img src="images/services/partner3.png" class="partner_img">
            <p class="name_advantage">Стройклимат</p>
          </div>
        </div>
        <div class="first_advantages">
          <div class="partner">
            <img src="images/services/partner4.png" class="partner_img">
            <p class="name_advantage">Kaskad Недвижимость</p>
          </div>
          <div class="partner">
            <img src="images/services/partner5.png" class="partner_img">
            <p class="name_advantage">Конкорд групп</p>
          </div>
          <div class="partner">
            <img src="images/services/partner6.png" class="partner_img">
            <p class="name_advantage">Страна Девелопмент</p>
          </div>
        </div>
      </div>
    </div>
    <div class="directors">
      <h1 class="zagolovok-offers">Директора нашей компании</h1>
      <div class="directors_people">
        <div class="image_directors">
          <img src="images/services/director1.jpg" class="img_aboutus">
          <div class="overlay-text">
            <div class="director-question-item">
              <div class="director-question">
                Директор компании — Стюнякова Лариса Николаевна
                <span class="togle-icon">+</span>
              </div>
              <div class="answe">
                Лариса Николаевна — опытный руководитель с более чем 
                15-летним стажем в деревообработке. Она направляет компанию 
                к развитию, уделяя особое внимание качеству продукции и 
                экологичности. </div>
            </div>
          </div>
        </div>
        <div class="image_directors">
          <img src="images/services/director2.jpg" class="img_aboutus">
          <div class="overlay-text">
            <div class="director-question-item">
              <div class="director-question">
                Коммерческий директор — Иванов Виктор Сергеевич
                <span class="togle-icon">+</span>
              </div>
              <div class="answe">
                Виктор Сергеевич отвечает за продажи и работу с клиентами. 
                Его опыт и деловой подход помогают компании стабильно 
                расти и укреплять партнерские связи. </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="info">
      <div class="infos">
        <div class="one_info">
          <h3 class="zag_info">Адрес</h3>
          <p class="informations">г. Москва, пер. Протопоповский, д. 19</p>
        </div>
        <div class="one_info">
          <h3 class="zag_info">График работы</h3>
          <p class="informations">пн-пт 8-18.00, сб 9 -15, вс -выходной</p>
        </div>
        <div class="one_info">
          <h3 class="zag_info">Почта</h3>
          <p class="informations">lesdrive163@mail.ru</p>
        </div>
        <div class="one_info">
          <h3 class="zag_info">Телефон</h3>
          <p class="informations">8(912) 345-67-89</p>
        </div>
      </div>
      <div class="carts">
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ab2cdec616796c54bea895862e8cc3fc04d27838464baaa4b279ba9188dfcc4f4&amp;source=constructor" 
          width="100%" height="400" frameborder="0"></iframe>
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
  <script src="aboutus.js"></script>
</body>

</html>