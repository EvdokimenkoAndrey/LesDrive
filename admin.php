<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit;
}
// Подключение к базе данных
require_once 'db.php';
require_once 'db_korzina.php';
$successMessage = $_SESSION['successMessage'] ?? '';
$errorMessage = $_SESSION['errorMessage'] ?? [];
// Очистка сообщений после отображения
unset($_SESSION['successMessage']);
unset($_SESSION['errorMessage']);
// Получение данных пользователя из базы данных
$stmt = $pdo->prepare("
SELECT id, email, first_name, last_name, middle_name, phone, address, profile_image, image_type 
FROM users 
WHERE id = :id
");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// Получение отзывов
$stmt = $pdo->prepare("
SELECT r.id, r.username, r.comment, r.created_at, r.is_approved, u.profile_image, u.image_type
FROM reviews r
LEFT JOIN users u ON r.user_id = u.id
ORDER BY r.created_at DESC
");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
$reviews_chunks = array_chunk($reviews, 3);

// Получение заказов
$stmt = $korzina_pdo->prepare("
    SELECT o.id AS order_id, o.name, o.phone, o.address, o.transport, o.total_price, o.created_at, o.is_approved
    FROM orders o
    ORDER BY o.created_at DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Разделение заказов на группы по 3
$order_chunks = array_chunk($orders, 3);

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка аватара
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        // Проверка размера файла (не более 1 МБ)
        if ($_FILES['new_image']['size'] > 1 * 1024 * 1024) {
            $errorMessage[] = "Размер изображения слишком большой. Максимальный размер: 1 МБ.";
        } else {
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
            $successMessage = "Изображение успешно обновлено!";
        }
    }
    // Обработка одобрения/удаления отзывов
    if (isset($_POST['approve'])) {
        $review_id = $_POST['review_id'];
        $update_stmt = $pdo->prepare("
            UPDATE reviews 
            SET is_approved = 1 
            WHERE id = :id
        ");
        $update_stmt->execute([':id' => $review_id]);
        $_SESSION['successMessage'] = "Отзыв успешно одобрен!";
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['delete'])) {
        $review_id = $_POST['review_id'];
        $delete_stmt = $pdo->prepare("
            DELETE FROM reviews 
            WHERE id = :id
        ");
        $delete_stmt->execute([':id' => $review_id]);
        $_SESSION['successMessage'] = "Отзыв успешно удален!";
        header("Location: admin.php");
        exit;
    }
    // Обработка заказов
    if (isset($_POST['approve_order'])) {
        $order_id = $_POST['order_id'];
        $update_stmt = $korzina_pdo->prepare("
            UPDATE orders 
            SET is_approved = 1 
            WHERE id = :id
        ");
        $update_stmt->execute([':id' => $order_id]);
        $_SESSION['successMessage'] = "Заказ успешно одобрен!";
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['reject_order'])) {
        $order_id = $_POST['order_id'];
        $update_stmt = $korzina_pdo->prepare("
            UPDATE orders 
            SET is_approved = -1 
            WHERE id = :id
        ");
        $update_stmt->execute([':id' => $order_id]);
        $_SESSION['successMessage'] = "Заказ успешно отклонен!";
        header("Location: admin.php");
        exit;
    }

    // Обновление данных пользователя
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $middle_name = trim($_POST['middle_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    if (empty($first_name)) {
        $errorMessage[] = "Поле 'Имя' обязательно для заполнения.";
    }
    if (empty($last_name)) {
        $errorMessage[] = "Поле 'Фамилия' обязательно для заполнения.";
    }
    if (!empty($phone) && !preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errorMessage[] = "Некорректный формат телефона.";
    }
    if (empty($errorMessage)) {
        // Обновление данных пользователя в базе данных
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
        $_SESSION['successMessage'] = "Данные успешно обновлены!";
        header("Location: admin.php");
        exit;
    } else {
        $_SESSION['errorMessage'] = $errorMessage;
        header("Location: admin.php");
        exit;
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
    <title>Личный кабинет</title>
</head>

<body>
    <div class="create-line">
        <header style="box-shadow:0px 4px 6px rgba(0, 0, 0, 0.1)" class="header-admin">
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
        <form method="POST" action="" class="information-user" enctype="multipart/form-data">
            <?php if (!empty($successMessage)): ?>
                <div class="message-container success-message">
                    <?= htmlspecialchars($successMessage) ?>
                </div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="message-container error-message">
                    <ul class="error-list">
                        <?php foreach ($errorMessage as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <main class="main-admin">
                <div class="dashboard">
                    <div class="profile-image-container" id="profile-image-container">
                        <?php if (!empty($_SESSION['profile_image'])): ?>
                            <label for="new_image" class="profile-image-label">
                                <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile Image" class="profile-image clickable" id="current-profile-image">
                            </label>
                        <?php endif; ?>
                        <input type="file" id="new_image" name="new_image" accept="image/jpeg, image/png, image/gif" style="display: none;">
                    </div>
                    <div class="hello">
                        <h1 class="welcome">Добро пожаловать, админ <?= htmlspecialchars($user['first_name']) ?>!</h1>
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
                <button type="submit" class="add-product bttn-save">Сохранить изменения</button>
        </form>
        <div class="form-product">
            <form action="admin_add_product" method="POST" class="inputs_product" enctype="multipart/form-data">
                <h1 class="zagolovok-add">Добавление нового товара</h1>
                <label for="image-upload" class="custom-upload">
                    <i>+</i>
                </label>
                <input type="file" id="image-upload" accept="image/*" name="product_image">
                <div class="info-product">
                    <label for="product_name" class="sign_product">Название товара:</label>
                    <input type="text" id="product_name" name="product_name" class="register login" required>
                    <label for="product_price" class="sign_product">Цена товара (в рублях):</label>
                    <input type="number" step="0.01" id="product_price" name="product_price" class="register login" required>
                    <label for="product_category" class="sign_product">Категория (страница):</label>
                    <select id="product_category" name="product_category" required>
                        <option value="page1">Страница 1 (Пиломатериалы)</option>
                        <option value="page2">Страница 2 (Материалы для отделки)</option>
                        <option value="page3">Страница 3 (Строительные материалы)</option>
                        <option value="page4">Страница 4 (Инструменты и крепеж)</option>
                    </select>
                    <button type="submit" class="add-product">Добавить товар</button>
                </div>
            </form>
        </div>
        <div class="comments" style="padding: 0;">
            <h1 class="zagolovok-offers">Модерация отзывов</h1>
            <?php if (empty($reviews)): ?>
                <p style="text-align: center; color: #777;">Нет отзывов для модерации.</p>
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
                                <small style="color: #777; font-size: 12px;">
                                    Отправлено: <?= htmlspecialchars(date('d.m.Y H:i', strtotime($review['created_at']))) ?>
                                </small>
                                <div class="moderation-actions">
                                    <?php if ($review['is_approved'] == 0): ?>
                                        <form method="POST" action="" class="inline-form">
                                            <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']) ?>">
                                            <button type="submit" name="approve" class="bttn-kind">Принять</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="approved-badge">Принят</span>
                                    <?php endif; ?>
                                    <form method="POST" action="" class="inline-form">
                                        <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']) ?>">
                                        <button type="submit" name="delete" class="bttn-delete">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Новый блок: Управление заказами -->
        <div class="admin-orders">
            <h1 class="zagolovok-offers">Управление заказами</h1>
                <?php if (empty($orders)): ?>
                    <p style="text-align: center; color: #777;">Нет заказов для обработки.</p>
                <?php else: ?>
                    <?php foreach ($order_chunks as $chunk): ?>
                        <div class="three_orders">
                            <?php foreach ($chunk as $order): ?>
                                <?php
                                // Загрузка товаров для текущего заказа
                                $itemsStmt = $korzina_pdo->prepare("
                            SELECT product_name, product_price, quantity, service 
                            FROM order_items 
                            WHERE order_id = :order_id
                        ");
                                $itemsStmt->execute([':order_id' => $order['order_id']]);
                                $order['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <div class="order-card order-card-admin">
                                    <div class="order-header order-header-admin">
                                        <span>Заказ №<?= htmlspecialchars($order['order_id']) ?></span>
                                        <span><?= htmlspecialchars(date('d.m.Y H:i', strtotime($order['created_at']))) ?></span>
                                    </div>
                                    <div class="order-details">
                                        <div class="info_orders">
                                            <p class="order_items"><strong>Пользователь:</strong> <?= htmlspecialchars($order['name']) ?></p>
                                            <p class="order_items"><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                                        </div>
                                        <div class="info_orders">
                                            <p class="order_items"><strong>Адрес доставки:</strong> <?= htmlspecialchars($order['address']) ?></p>
                                            <p class="order_items"><strong>Транспорт:</strong> <?= htmlspecialchars($order['transport']) ?></p>
                                        </div>
                                        <div class="info_orders">
                                            <p class="order_items"><strong>Общая стоимость:</strong> <?= htmlspecialchars(number_format($order['total_price'], 2)) ?> руб.</p>
                                            <p class="order_items"><strong>Статус:</strong>
                                                <?php if ($order['is_approved'] == 0): ?>
                                                    В обработке
                                                <?php elseif ($order['is_approved'] == 1): ?>
                                                    Одобрен
                                                <?php else: ?>
                                                    Отклонен
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="order-items order-items-admin">
                                        <h3 class="order_items">Товары в заказе:</h3>
                                        <ul class="order-items-admin">
                                            <?php foreach ($order['items'] as $item): ?>
                                                <li>
                                                    <?= htmlspecialchars($item['product_name']) ?> -
                                                    <?= htmlspecialchars($item['quantity']) ?> шт. по
                                                    <?= htmlspecialchars(number_format($item['product_price'], 2)) ?> руб.
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="moderation-actions">
                                        <?php if ($order['is_approved'] == 0): ?>
                                            <form method="POST" action="" class="inline-form">
                                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                                                <button type="submit" name="approve_order" class="bttn-kind">Одобрить</button>
                                            </form>
                                            <form method="POST" action="" class="inline-form">
                                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                                                <button type="submit" name="reject_order" class="bttn-delete">Отказаться</button>
                                            </form>
                                        <?php elseif ($order['is_approved'] == 1): ?>
                                            <span class="approved-badge approved-badge-orders">Одобрен</span>
                                        <?php else: ?>
                                            <span class="rejected-badge approved-badge">Отклонен</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
        <footer style="margin-top: 100px;">
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
                        <a href="https://yandex.ru/maps/213/moscow/house/protopopovskiy_pereulok_19s12/Z04YcARpTUcPQFtvfXt5cHtqZw==/?indoorLevel=1&ll=37.639428%2C55.781793&z=16.64 " class="address">г. Москва, пер. Протопоповский, д. 19 стр. 12, эт/ком 3/13</a>
                    </div>
                </div>
            </div>
            <p class="ooo">2024 ООО "Пиломаркет"<br>Информация на сайте не является публичной офертой</p>
        </footer>
        <script src="upload-image.js"></script>
        <script src="custom-upload.js"></script>
</body>

</html>