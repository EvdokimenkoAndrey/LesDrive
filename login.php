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
$stmt = $pdo->prepare("SELECT id, login, email, first_name, last_name, middle_name, phone, address FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Обработка POST-запроса для обновления данных
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
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
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':middle_name' => $middle_name,
        ':phone' => $phone,
        ':address' => $address,
        ':id' => $_SESSION['user_id']
    ]);

    // Обновление данных в сессии
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['middle_name'] = $middle_name;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;

    // Перенаправление обратно в личный кабинет
    header("Location: login.php");
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
    <style>
        .welcome {
            font-size: 30px;
        }
        .dashboard {
            display: flex;
            flex-direction: row;
            gap: 20px;
            margin-top: 80px;
            align-items: center;
            padding: 0 60px;
        }

        .hello {
            display: flex;
            flex-direction: column;
        }

        .information-user {
            padding: 0 60px;
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        .inputs_info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 20px;
        }

        .form-group-first {
            display: flex;
            flex-direction: row;
            gap: 50px;
            /* Расстояние между инпутами внутри одного блока */
        }

        .form-group {
            flex: 1;
            /* Растягивает инпуты на всю доступную ширину */
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input_info {
            box-sizing: border-box;
            width: 100%;
            /* Инпуты занимают всю ширину */
            padding: 28px 18px;
            outline: none;
            border: none;
            border-radius: 10px;
            background-color: #fff;
            font-size: 18px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .sign_inputs {
            font-size: 23px;
        }

        button {
            align-self: flex-start;
            /* Кнопка выравнивается слева */
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin: 0 auto;
            display: flex;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
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
            <div class="dashboard">
                <?php if (!empty($_SESSION['profile_image'])): ?>
                    <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile Image" class="profile-image">
                <?php endif; ?>
                <div class="hello">
                    <h1 class="welcome">Добро пожаловать, <?= htmlspecialchars($_SESSION['user_login']) ?>!</h1>
                    <a href="logout.php">Выйти</a>
                </div>
            </div>
            <form method="POST" action="" class="information-user">
                <div class="inputs_info">
                    <div class="form-group-first">
                        <div class="form-group">
                            <label for="first_name" class="sign_inputs">Имя:</label>
                            <input type="text" id="first_name" class="input_info" name="first_name" value="<?= htmlspecialchars($user['login'] ?? '') ?>">
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
                            <input type="text" id="address" class="input_info" name="address"><?= htmlspecialchars($user['address'] ?? '') ?></input>
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
</body>

</html>