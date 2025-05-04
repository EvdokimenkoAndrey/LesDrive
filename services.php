<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="services.css">
    <link rel="icon" href="images/logo.png">
    <title>Услуги</title>
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
        <div class="offers">
            <h1 class="zagolovok-offers">Доставка осуществляется на</h1>
            <div class="slider-container">
                <div class="slider">
                    <div class="slides">
                        <img src="images/services/delivery1.png" class="slide-image">
                        <div class="text-slider delivery">Грузовые автомобили</div>
                        <ul class="des">
                            <li>Грузоподъемность: до 20 тонн и более.</li>
                            <li>Возможность перевозки груза длиной до 12–15 метров.</li>
                            <li>Часто оснащены ремнями для крепления груза.</li>
                        </ul>
                    </div>
                    <div class="slides">
                        <img src="images/services/delivery2.png" class="slide-image">
                        <div class="text-slider delivery">Газель</div>
                        <ul class="des">
                            <li>Грузоподъемность: до 1,5–3 тонн.</li>
                            <li>Компактность позволяет доставлять груз в труднодоступные места.</li>
                            <li>Возможность закрытой или открытой платформы.</li>
                        </ul>
                    </div>
                    <div class="slides">
                        <img src="images/services/delivery3.png" class="slide-image">
                        <div class="text-slider delivery">Лесовозы</div>
                        <ul class="des">
                            <li>Грузоподъемность: от 10 до 40 тонн.</li>
                            <li>Специальные стойки для крепления длинных материалов.</li>
                            <li>Приспособлены для перевозки круглых брёвен.</li>
                        </ul>
                    </div>
                    <div class="slides">
                        <img src="images/services/delivery4.png" class="slide-image">
                        <div class="text-slider delivery">Манипуляторы</div>
                        <ul class="des">
                            <li>Грузоподъемность: до 10 тонн.</li>
                            <li>Оснащены краном для погрузки/разгрузки.</li>
                            <li>Используются для перевозки балок, плит и других тяжелых материалов.</li>
                        </ul>
                    </div>
                    <div class="slides">
                        <img src="images/services/delivery5.png" class="slide-image">
                        <div class="text-slider delivery">Автомобили с кузовом-фургоном</div>
                        <ul class="des">
                            <li>Грузоподъемность: до 5 тонн.</li>
                            <li>Для доставки материалов, требующих защиты от погодных условий.</li>
                            <li>Защищает от влаги, пыли и грязи и подходит для хрупких материалов.</li>
                        </ul>
                    </div>
                    <div class="slides">
                        <img src="images/services/delivery6.png" class="slide-image">
                        <div class="text-slider delivery">Рефрижераторы</div>
                        <ul class="des">
                            <li>Грузоподъемность: до 10–25 тонн (в зависимости от модели).</li>
                            <li>Температурный режим: от -30°C до +12°C.</li>
                            <li>Обеспечивают стабильную температуру на протяжении всего маршрута.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bttn-slider">
                <img src="images/bttn-slider1.png" class="img-bttn" id="prevBtn">
                <img src="images/bttn-slider2.png" class="img-bttn" id="nextBtn">
            </div>
        </div>
        <div class="auto-slider">
            <div class="slider-wrapper">
                <div class="slide">
                    <div class="raspil">
                        <div class="rectangle">
                            <div class="text-recta">
                                <h1>Услуги по распилу</h1>
                                <ul class="list_uslugi">
                                    <li>Подготовим материалы по индивидуальным размерам и формам.</li>
                                    <li>Делаем скосы, вырезы и сложные формы для отделочных и строительных целей.</li>
                                    <li>Доски, бруски, балки и другие материалы будут обработаны с максимальной точностью.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="triangle"></div>
                        <img src="images/services/raspil.png" class="raspil-image">
                    </div>
                </div>

                <div class="slide">
                    <div class="raspil">
                        <div class="rectangle">
                            <div class="text-recta">
                                <h1>Услуги по обработке</h1>
                                <ul class="list_uslugi">
                                    <li>Достигаем гладкости поверхности для покраски/лакировки.</li>
                                    <li>Выполняем сверление и нарезку для упрощения сборки.</li>
                                    <li>Создаем ровные края для удобного монтажа.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="triangle"></div>
                        <img src="images/services/obrabotka.png" class="raspil-image">
                    </div>
                </div>
            </div>
        </div>
        <div class="advantages">
            <h1 class="zagolovok-offers">Преимущества нашей обработки</h1>
            <div class="classes_advantages">
                <div class="first_advantages">
                    <div class="advantage">
                        <img src="images/services/advantage1.png" class="advantage_img">
                        <p class="name_advantage">Современное оборудование</p>
                        <p class="desc_advan">Высокоточная техника позволяет работать с материалами любой сложности.</p>
                    </div>
                    <div class="advantage">
                        <img src="images/services/advantage2.png" class="advantage_img">
                        <p class="name_advantage">Экономия времени</p>
                        <p class="desc_advan">Быстрая обработка и подготовка материалов.</p>
                    </div>
                    <div class="advantage">
                        <img src="images/services/advantage3.png" class="advantage_img">
                        <p class="name_advantage">Индивидуальный подход</p>
                        <p class="desc_advan">Мы учитываем все ваши пожелания и требования.</p>
                    </div>
                </div>
                <div class="first_advantages">
                    <div class="advantage">
                        <img src="images/services/advantage4.png" class="advantage_img">
                        <p class="name_advantage">Минимизация отходов</p>
                        <p class="desc_advan">Рациональный подход к распилу снижает количество ненужных остатков.</p>
                    </div>
                    <div class="advantage">
                        <img src="images/services/advantage5.png" class="advantage_img">
                        <p class="name_advantage">Гарантия качества</p>
                        <p class="desc_advan">Каждый этап контролируется для идеального результата.</p>
                    </div>
                    <div class="advantage">
                        <img src="images/services/advantage6.png" class="advantage_img">
                        <p class="name_advantage">Широкий спектр услуг</p>
                        <p class="desc_advan">Предлагаем стандартный и сложный распил, фигурную обработку под монтаж.</p>
                    </div>
                </div>
            </div>
        </div>
        <footer style="margin-top: 50px;">
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
    <script src="index.js"></script>

</html>