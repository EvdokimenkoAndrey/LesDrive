<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit;
}

require_once 'db.php';

$successMessage = '';
$errorMessage = '';

// Получение данных пользователя
$stmt = $pdo->prepare("
    SELECT first_name, profile_image, image_type 
    FROM users 
    WHERE id = :user_id
");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);

    if (empty($comment)) {
        $errorMessage = "Пожалуйста, напишите отзыв.";
    } else {
        try {
// Добавление отзыва в базу данных
            $insert_stmt = $pdo->prepare("
                INSERT INTO reviews (user_id, username, comment)
                VALUES (:user_id, :username, :comment)
            ");
            $insert_stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':username' => $user['first_name'],
                ':comment' => $comment
            ]);

            // Установка сообщения в сессии
            $_SESSION['successMessage'] = "Ваш отзыв отправлен на модерацию и будет опубликован после проверки.";

            // Перенаправление на ту же страницу (Post/Redirect/Get)
            header("Location: write_comment.php");
            exit;
        } catch (PDOException $e) {
            $errorMessage = "Ошибка при добавлении отзыва: " . $e->getMessage();
        }
    }
}

// Получение сообщений из сессии
$successMessage = $_SESSION['successMessage'] ?? '';
unset($_SESSION['successMessage']); // Очистка сообщения после отображения
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="login_register.css">
  <link rel="icon" href="images/logo.png">
  <title>Написать отзыв</title>
</head>

<body>
  <main>
    <div>
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
    <?php if (!empty($successMessage)): ?>
        <div class="message-container success-message">
          <?= htmlspecialchars($successMessage) ?>
        </div>
      <?php elseif (!empty($errorMessage)): ?>
        <div class="message-container error-message">
          <?= htmlspecialchars($errorMessage) ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="container-comment">
      <h1 class="zagolovok-offers">Написать отзыв</h1>

      <form method="POST" action="" class="comment-form">
        <textarea name="comment" placeholder="Напишите ваш отзыв..." rows="5" required maxlength="300"></textarea>
        <div class="char-counter">Осталось символов: <span id="counter">300</span></div>
        <button type="submit" class="bttn-login">Отправить отзыв</button>
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
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.querySelector('.comment-form textarea');
    const counterElement = document.getElementById('counter');
    const maxLength = parseInt(textarea.getAttribute('maxlength'));

    // Обновление счетчика при вводе текста
    textarea.addEventListener('input', function () {
        const remaining = maxLength - textarea.value.length;
        counterElement.textContent = remaining;

        // Изменение цвета счетчика, если осталось мало символов
        if (remaining <= 10) {
            counterElement.style.color = 'red';
        } else {
            counterElement.style.color = '#333';
        }
    });

    // Инициализация счетчика при загрузке страницы
    counterElement.textContent = maxLength;
});
</script>
</body>

</html>
