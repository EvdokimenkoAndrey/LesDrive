<?php
session_start();

require_once 'db.php';

// Получение только одобренных отзывов из базы данных с аватарами пользователей
$stmt = $pdo->prepare("
    SELECT r.id, r.username, r.comment, r.created_at, u.profile_image, u.image_type
    FROM reviews r
    LEFT JOIN users u ON r.user_id = u.id
    WHERE r.is_approved = 1
    ORDER BY r.created_at DESC
");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Разделение отзывов на группы по 3 отзыва
$reviews_chunks = array_chunk($reviews, 3);
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="login_register.css">
  <link rel="icon" href="images/logo.png">
  <title>Главная страница</title>
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
                <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" class="korzina profile-image" style="height: 4vw;"></a>
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
    <div class="comments">
      <h1 class="zagolovok-offers">Отзывы наших клиентов</h1>
      <?php if (empty($reviews)): ?>
        <p style="text-align: center; color: #777;">Пока нет одобренных отзывов.</p>
      <?php else: ?>
        <!-- Отображение отзывов в контейнерах по 3 отзыва -->
        <?php foreach ($reviews_chunks as $chunk): ?>
          <div class="three_comments">
            <?php foreach ($chunk as $review): ?>
              <div class="first-comment">
                <div class="class1-comments">
                  <!-- Отображение аватара пользователя -->
                  <?php if (!empty($review['profile_image']) && !empty($review['image_type'])): ?>
                    <img src="data:<?php echo htmlspecialchars($review['image_type']); ?>;base64,<?php echo base64_encode($review['profile_image']); ?>"
                      alt="Avatar" class="image-comment1">
                  <?php else: ?>
                    <img src="images/default_avatar.png" alt="Default Avatar" class="image-comment1">
                  <?php endif; ?>
                  <h2><?= htmlspecialchars($review['username']) ?></h2>
                </div>
                <p class="text-comment1"><?= htmlspecialchars($review['comment']) ?></p>
                <small>
                  Опубликовано: <?= htmlspecialchars(date('d.m.Y H:i', strtotime($review['created_at']))) ?>
                </small>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
      <a href="write_comment.php" class="punkts watch">
      <button class="choose_reviews">
        Написать рецензию
      </button></a>
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
  <style>

  </style>
</body>

</html>