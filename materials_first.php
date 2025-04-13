<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="materials.css">
    <link rel="icon" href="images/logo.png">
    <title>Пиломатериалы</title>
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
        <div class="pilomaterials">
            <h1 class="zagolovok-offers">Пиломатериалы</h1>
            <div class="all-materials">
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из дуба 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">123 р за шт.</p>
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из дуба 150х150х6000">
                                <input type="hidden" name="product_price" value="123">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <!-- Форма для добавления товара -->
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <!-- Форма для добавления товара -->
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <!-- Форма для добавления товара -->
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <!-- Форма для добавления товара -->
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="material">
                    <img src="images/materials/material1.png" class="material-image">
                    <div class="information_material">
                        <div class="material-slider">Брус обрезной из сосны 150х150х6000</div>
                        <div class="price_corsina">
                            <p class="price">780 р за шт.</p>
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_name" value="Брус обрезной из сосны 150х150х6000">
                                <input type="hidden" name="product_price" value="780">
                                <input type="hidden" name="product_image" value="images/materials/material1.png">
                                <button type="submit" class="corsina-button">
                                    <img src="images/corsina.png" class="corsina">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>