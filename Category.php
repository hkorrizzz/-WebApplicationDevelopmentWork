<?php
require_once 'connection.php';

$categoryType = isset($_GET['type']) ? $_GET['type'] : 'ЮБКИ';

$availableTypes = ['ЮБКИ', 'ФУТБОЛКИ', 'БРЮКИ', 'ТОПЫ', 'АКСЕССУАРЫ'];
if (!in_array($categoryType, $availableTypes)) {
    $categoryType = 'ЮБКИ';
}

$stmt = $pdo->prepare("SELECT _id, name, price, image, type, article, description FROM products WHERE type = :type ORDER BY name");
$stmt->execute(['type' => $categoryType]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasProducts = !empty($products);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ZZZEST - Каталог женской одежды</title>
    <link rel="stylesheet" href="styles/CatalogPage.css">
    <link rel="stylesheet" href="styles/HeaderMenuStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="search">
        <input type="text" placeholder="Найти на сайте" />
    </div>
    <div class="brand">
        <a href="ZZZEST.php">ZZZEST</a>
    </div>
    <div class="header-icons">
        <button title="Избранные товары" aria-label="Избранные товары" onclick="window.location.href='Favorites.php'"><img src="pictures/heart-Photoroom.png" class="header-icon"></button>
        <button title="Вход в аккаунт" aria-label="Вход в аккаунт"><img src="pictures/profil-Photoroom.png" class="header-icon"></button>
        <button id="menuButton" title="Меню" aria-label="Меню"><img src="pictures/menu-icon.jpg" class="header-icon"></button>
    </div>
    
    <div id="dropdownMenu" class="dropdown-menu">
        <div class="menu-section">
            <div class="section-title">Навигация</div>
            <a href="ZZZEST.php">Главная</a>
            <a href="AboutUsPage.html">О нас</a>
            <a href="StoresPage.html">Магазины</a>
            <a href="BlogPage.html">Блог</a>
        </div>
        <div class="menu-section">
            <div class="section-title">Каталог</div>
            <a href="Category.php?type=ЮБКИ">Юбки</a>
            <a href="Category.php?type=ФУТБОЛКИ">Футболки</a>
            <a href="Category.php?type=БРЮКИ">Брюки</a> 
            <a href="Category.php?type=ТОПЫ">Топы</a>
            <a href="Category.php?type=АКСЕССУАРЫ">Аксессуары</a>
        </div>
    </div>
</header>

    <div class="catalog-container">
        <div class="category-title-container">
            <h1 class="category-title-main"><?php echo htmlspecialchars($categoryType); ?></h1>
        </div>

        <div class="products-grid">
            <?php if ($hasProducts): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                        $id = htmlspecialchars($product['_id']);
                        $name = htmlspecialchars($product['name'] ?? 'Без названия');
                        $price = htmlspecialchars($product['price'] ?? '0');
                        $image = htmlspecialchars($product['image'] ?? 'pictures/no-image.jpg');
                        $article = htmlspecialchars($product['article'] ?? '');
                        
                        if (strpos($image, 'productsPictures/') === 0) {
                            $image = 'pictures/' . substr($image, strlen('productsPictures/'));
                        }
                    ?>
                    <div class="product-card">
                        <a href="Product.php?id=<?= $id ?>">
                            <img src="<?= $image ?>" alt="<?= $name ?>" class="product-image" onerror="this.src='pictures/no-image.jpg'">
                        </a>
                        <div class="product-info">
                            <div class="more-info">
                                <div class="product-name"><?= strtoupper($name) ?></div>
                                <div class="product-price"><?= $price ?> BYN</div>
                                <div class="product-article"><?= $article ?></div>
                            </div>
                            <button type="button" class="add-to-cart add-to-favorites" data-product-id="<?= $id ?>" onclick="addToFavorites(this)">В ИЗБРАННОЕ</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; color: #666; padding: 40px; text-align: center;">
                    <p>В категории '<?= htmlspecialchars($categoryType) ?>' пока нет товаров</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="footer-left">
            <p>© 2025 ZZZEST. Все права защищены.</p>
        </div>
        <div class="footer-center">
            <a href="https://instagram.com" target="_blank" title="Instagram" aria-label="Instagram">
                <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram">
            </a>
            <a href="https://telegram.org" target="_blank" title="Telegram" aria-label="Telegram">
                <img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" alt="Telegram">
            </a>
        </div>
        <div class="footer-right">
            <p>+375 (25) 456-20-67<br>zzzest.brand@gmail.com</p>
        </div>
    </footer>

    <script src="JSCode/HeaderMenuScript.js"></script>
</body>
</html>