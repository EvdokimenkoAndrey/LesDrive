<?php
session_start();

require_once 'db.php';

$stmt = $pdo->prepare("
    SELECT r.id, r.username, r.comment, r.created_at, u.profile_image, u.image_type
    FROM reviews r
    LEFT JOIN users u ON r.user_id = u.id
    WHERE r.is_approved = 1
    ORDER BY r.created_at DESC
    LIMIT 3
");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reviews_chunks = array_chunk($reviews, 3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="images/logo.png">
  <title>Главная страница</title>
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
        <?php
            if (isset($_SESSION['user_id'])) : ?>
              <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']);
              ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" 
              class="korzina profile-image"></a>
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
    <div class="offers">
      <h1 class="zagolovok-offers">Наши предложения</h1>
      <div class="slider-container">
        <div class="slider">
          <div class="slides">
            <img src="images/header-image 1.png" class="slide-image">
            <div class="text-slider">Весеняя распродажа! Скидки до 25% на 
              пиломатериалы для строительства.</div>
          </div>
          <div class="slides">
            <img src="images/header-image 2.png" class="slide-image">
            <div class="text-slider">Доставим материалы за 24 часа! Удобный 
              расчет стоимости онлайн.</div>
          </div>
          <div class="slides">
            <img src="images/header-image 3.png" class="slide-image">
            <div class="text-slider">Идеальные размеры для вашего проекта! 
              Бесплатный распил при заказе от 50 м³.</div>
          </div>
          <div class="slides">
            <img src="images/header-image 4.png" class="slide-image">
            <div class="text-slider">100% качество — проверено временем! 
              Достойная гарантия на все товары.</div>
          </div>
          <div class="slides">
            <img src="images/header-image 5.png" class="slide-image">
            <div class="text-slider">В продаже: эксклюзивные породы 
              древесины для дизайнерских проектов!</div>
          </div>
        </div>
      </div>
      <div class="bttn-slider">
        <img src="images/bttn-slider1.png" class="img-bttn" id="prevBtn">
        <img src="images/bttn-slider2.png" class="img-bttn" id="nextBtn">
      </div>
    </div>
    <div class="div-forest">
      <img src="images/forest.png" class="forest">
      <div class="animated-text" id="textContainer">ЛесДрайв — ваш проводник 
        в мире качественных лесоматериалов. Мы предоставляем всё необходимое 
        для строительства, отделки и уникальных проектов. Наша миссия — 
        помогать вам реализовывать идеи, предлагая материалы, которым 
        можно доверять. С нами легко строить, создавая прочное будущее!
      </div>
    </div>
    <div class="products">
      <div class="images_products">
        <div>
          <img src="images/products-first_image.png" class='first-image'>
        </div>
        <div class="mini-images">
          <img src="images/products-scnd_image.png" class="scnd_product-image">
          <img src="images/products-third_image.png" class="scnd_product-image">
        </div>
      </div>
      <div class="mini-products">
        <div class="product">
          <img src="images/product-one.png" class="brusok">
          <div class="brusok-class">
            <div>
              <h1>Брусок</h1>
              <p class="des-brusok">Идеальный брусок для каркасного 
                строительства</p>
            </div>
            <a class="link-materials" href="materials_first.php">
              <button class="buy">Купить</button></a>
          </div>
        </div>
        <div class="product">
          <img src="images/product-two.png" class="brusok" id="brusok">
          <div class="brusok-class parket" id="brusok-class"">
            <div>
              <h1>Плинтус</h1>
              <p class=" des-brusok">Качественный деревянный плинтус 
                для пола</p>
          </div>
          <a class="link-materials" href="materials_third.php">
            <button class="buy">Купить</button></a>
        </div>
      </div>
      <div class="product">
        <img src="images/product-three.png" class="brusok" id="brusok">
        <div class="brusok-class" id="brusok-class">
          <div>
            <h1>Рубанок</h1>
            <p class="des-brusok">Надежный электрический рубанок 
              мощностью 750 Вт</p>
          </div>
          <a class="link-materials" href="materials_first.php">
            <button class="buy">Купить</button></a>
        </div>
      </div>
    </div>
    </div>
    <div class="lesorub">
      <div class="tekst">
        <p class="zitata_lesorub">«Хороший лесоруб — нередко бывший хороший правдоруб»</p>
        <p class="zitata_lesorub author">Федор Радецкий</p>
      </div>
      <img src="images/lesorub.png" class="lesorub-img">
    </div>
    <div class="comments">
      <h1 class="zagolovok-offers">Отзывы наших клиентов</h1>
      <?php if (empty($reviews)): ?>
        <p style="text-align: center; color: #777;">Пока нет одобренных отзывов.</p>
      <?php else: ?>
        <?php foreach ($reviews_chunks as $chunk): ?>
          <div class="three_comments">
            <?php foreach ($chunk as $review): ?>
              <div class="first-comment">
                <div class="class1-comments">
                  <?php if (!empty($review['profile_image']) && 
                  !empty($review['image_type'])): ?>
                    <img src="data:<?php echo 
                    htmlspecialchars($review['image_type']); ?>;base64,
                    <?php echo base64_encode($review['profile_image']); ?>"
                      alt="Avatar" class="image-comment1">
                  <?php else: ?>
                    <img src="images/default_avatar.png" alt="Default Avatar" 
                    class="image-comment1">
                  <?php endif; ?>
                  <h2><?= htmlspecialchars($review['username']) ?></h2>
                </div>
                <p class="text-comment1"><?= 
                htmlspecialchars($review['comment']) ?></p>
                <small>
                  Опубликовано: <?= htmlspecialchars(date('d.m.Y H:i', 
                  strtotime($review['created_at']))) ?>
                </small>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
      <a href="comments.php" class="punkts watch">
        <button class="choose_reviews">
          Посмотреть отзывы
        </button></a>
    </div>
    <div class="questions">
      <h1 class="zagolovok-offers">Часто задаваемые вопросы</h1>
      <div class="questions-container">
        <div class="question-item">
          <div class="question">
            Доставляете ли вы заказы в отдаленные регионы?
            <span class="toggle-icon">+</span>
          </div>
          <div class="answer">
            Да, мы осуществляем доставку по всему региону и в соседние области. 
            Для удаленных районов сроки и стоимость доставки уточняются 
            индивидуально. </div>
        </div>
        <div class="question-item">
          <div class="question">
            Предоставляете ли вы документы на материалы?
            <span class="toggle-icon">+</span>
          </div>
          <div class="answer">
            Да, мы предоставляем все необходимые документы: сертификаты качества, 
            счета и накладные.
          </div>
        </div>
        <div class="question-item">
          <div class="question">
            Есть ли у вас услуги распила и обработки древесины?
            <span class="toggle-icon">+</span>
          </div>
          <div class="answer">
            Да, мы можем выполнить распил древесины по вашим размерам, а также 
            обработать материалы для увеличения их долговечности. </div>
        </div>
        <div class="question-item">
          <div class="question">
            Как быстро можно получить заказ?
            <span class="toggle-icon">+</span>
          </div>
          <div class="answer">
            Сроки доставки зависят от объема и вашего местоположения. 
            Мы стараемся доставить заказы в течение 1–3 рабочих дней. 
          </div>
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
  <script src="script.js"></script>
</body>
</html>