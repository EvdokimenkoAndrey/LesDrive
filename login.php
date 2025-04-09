<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
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
        .dashboard {
            display: flex;
            flex-direction: row;
            padding: 0 60px;
            gap: 20px;
            margin: 80px auto;
            align-items: center;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .hello {
            display: flex;
            flex-direction: column;
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
                            <img src="images/LogIn.png" class="korzina"></a>
                        <a href="corsina.php">
                            <img src="images/corsina.png" class="korzina"></a>
                    </div>
                </div>
            </header>
            <div class="dashboard">
                <?php if (!empty($_SESSION['profile_image'])): ?>
                    <img src="data:<?php echo htmlspecialchars($_SESSION['image_type']); ?>;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile Image" class="profile-image">
                <?php endif; ?>
                <div class="hello">
                <h1>Добро пожаловать, <?= htmlspecialchars($_SESSION['user_login']) ?>!</h1>
                <p>Ваш email: <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                <a href="logout.php">Выйти</a>
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