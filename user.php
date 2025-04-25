<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit;
}

// Подключение к базе данных
require_once 'db.php';

// Получение данных пользователя из базы данных
$stmt = $pdo->prepare("
    SELECT id, email, first_name, last_name, middle_name, phone, address, profile_image, image_type 
    FROM users 
    WHERE id = :id
");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Обработка POST-запроса для обновления данных
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обновление аватара
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        // Проверка размера файла (не более 1 МБ)
        if ($_FILES['new_image']['size'] > 1 * 1024 * 1024) {
            die("Размер изображения слишком большой. Максимальный размер: 1 МБ.");
        }

        // Чтение данных изображения
        $imageData = file_get_contents($_FILES['new_image']['tmp_name']);
        $imageType = $_FILES['new_image']['type'];

        // Обновление изображения в базе данных
        $update_stmt = $pdo->prepare("
            UPDATE users 
            SET profile_image = :profile_image, 
                image_type = :image_type 
            WHERE id = :id
        ");
        $update_stmt->execute([
            ':profile_image' => $imageData,
            ':image_type' => $imageType,
            ':id' => $_SESSION['user_id']
        ]);

        // Обновление данных в сессии
        $_SESSION['profile_image'] = $imageData;
        $_SESSION['image_type'] = $imageType;
    }

    // Обработка остальных полей (имя, фамилия и т.д.)
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $middle_name = trim($_POST['middle_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $update_stmt = $pdo->prepare("
        UPDATE users 
        SET first_name = :first_name, 
            last_name = :last_name, 
            middle_name = :middle_name, 
            phone = :phone, 
            address = :address 
        WHERE id = :id
    ");
    $update_stmt->execute([
        ':first_name' => $first_name ?: null,
        ':last_name' => $last_name ?: null,
        ':middle_name' => $middle_name ?: null,
        ':phone' => $phone ?: null,
        ':address' => $address ?: null,
        ':id' => $_SESSION['user_id']
    ]);

    // Обновление данных в сессии
    $_SESSION['first_name'] = $first_name ?: null;
    $_SESSION['last_name'] = $last_name ?: null;
    $_SESSION['middle_name'] = $middle_name ?: null;
    $_SESSION['phone'] = $phone ?: null;
    $_SESSION['address'] = $address ?: null;

    // Перенаправление обратно в личный кабинет
    header("Location: user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login_register.css">
    <title>Личный кабинет</title>
</head>

<body>
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
        <main>

            <form method="POST" action="" class="information-user" enctype="multipart/form-data">
                <div class="dashboard">
                    <div class="profile-image-container" id="profile-image-container">
                        <?php if (!empty($_SESSION['profile_image'])): ?>
                            <label for="new_image" class="profile-image-label">
                                <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile Image" class="profile-image clickable" id="current-profile-image">
                            </label>
                        <?php else: ?>
                            <label for="new_image" class="profile-image-label">
                                <p>Добавить аватар</p>
                            </label>
                        <?php endif; ?>
                        <input type="file" id="new_image" name="new_image" accept="image/jpeg, image/png, image/gif" style="display: none;">
                    </div>
                    <div class="hello">
                        <h1 class="welcome">Добро пожаловать, <?= htmlspecialchars($user['first_name']) ?>!</h1>
                        <a href="logout.php" class="logout">Выйти из аккаунта</a>
                    </div>
                </div>
                <div class="inputs_info">
                    <div class="form-group-first">
                        <div class="form-group">
                            <label for="first_name" class="sign_inputs">Имя:</label>
                            <input type="text" id="first_name" class="input_info" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="sign_inputs">Фамилия:</label>
                            <input type="text" id="last_name" class="input_info" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group-first">
                        <div class="form-group">
                            <label for="middle_name" class="sign_inputs">Отчество:</label>
                            <input type="text" id="middle_name" class="input_info" name="middle_name" value="<?= htmlspecialchars($user['middle_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sign_inputs">Почта:</label>
                            <input type="text" id="email" class="input_info" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group-first">
                        <div class="form-group">
                            <label for="phone" class="sign_inputs">Телефон:</label>
                            <input type="text" id="phone" class="input_info" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="address" class="sign_inputs">Адрес:</label>
                            <input type="text" id="address" class="input_info" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <button type="submit">Сохранить изменения</button>
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
        <script src="upload-image.js"></script>
</body>

</html>