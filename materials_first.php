<?php
session_start();
require_once 'db.php';
require_once "db_korzina.php";

try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
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
    <?php foreach ($products as $product): ?>
        <div class="material">
            <img src="<?= htmlspecialchars($product['product_image']) ?>" class="material-image">
            <div class="information_material">
                <div class="material-slider"><?= htmlspecialchars($product['product_name']) ?></div>
                <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>">
                    <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['product_price']) ?>">
                    <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['product_image']) ?>">
                    
                    <div class="price-service-container">
                        <p class="price"><?= htmlspecialchars($product['product_price']) ?> р за шт.</p>
                        <select name="service" id="service" required>
                            <option value="Без услуги">Без услуги</option>
                            <option value="Обработка">Обработка</option>
                            <option value="Распил">Распил</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="corsina-button">В корзину</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        </div>
    </main>
</body>

</html>