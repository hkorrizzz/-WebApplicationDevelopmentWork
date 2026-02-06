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
<?php

$categoryType = isset($_GET['type']) ? $_GET['type'] : 'ПЛАТЬЯ';

?>
<header>
    <div class="search">
        <input type="text" placeholder="Найти на сайте" />
    </div>
    <div class="brand">
        <a href="WelcomePage.php">ZZZEST</a>
    </div>
    <div class="header-icons">
        <button title="Избранные товары" aria-label="Избранные товары" onclick="window.location.href='FavoritePage.php'"><img src="pictures/heart-Photoroom.png" class="header-icon"></button>
        <button title="Вход в аккаунт" aria-label="Вход в аккаунт"><img src="pictures/profil-Photoroom.png" class="header-icon"></button>
        <button id="menuButton" title="Меню" aria-label="Меню"><img src="pictures/menu-icon.jpg" class="header-icon"></button>
    </div>
    
    <div id="dropdownMenu" class="dropdown-menu">
        <div class="menu-section">
            <div class="section-title">Навигация</div>
            <a href="WelcomePage.php">Главная</a>
            <a href="AboutUsPage.html">О нас</a>
            <a href="StoresPage.html">Магазины</a>
            <a href="BlogPage.html">Блог</a>
        </div>
        <div class="menu-section">
            <div class="section-title">Каталог</div>
            <a href="CatalogPage.php?type=ПЛАТЬЯ">Платья</a>
            <a href="CatalogPage.php?type=ЮБКИ">Юбки</a>
            <a href="CatalogPage.php?type=ЖАКЕТЫ">Жакеты</a>
            <a href="CatalogPage.php?type=БЛУЗКИ">Блузки</a>
            <a href="CatalogPage.php?type=ВЕРХНЯЯ ОДЕЖДА">Верхняя одежда</a>
            <a href="CatalogPage.php?type=ФУТБОЛКИ">Футболки</a>
            <a href="CatalogPage.php?type=БРЮКИ">Брюки</a>
            <a href="CatalogPage.php?type=ШОРТЫ">Шорты</a>
            <a href="CatalogPage.php?type=ЖИЛЕТЫ">Жилеты</a>
            <a href="CatalogPage.php?type=ТОПЫ">Топы</a>
            <a href="CatalogPage.php?type=АКСЕССУАРЫ">Аксессуары</a>
        </div>
    </div>
</header>

    <div class="catalog-container">
        <div class="category-title-container">
            <h1 class="category-title-main"><?php echo htmlspecialchars($categoryType); ?></h1>
        </div>

        <div class="products-grid">
            <?php
            try {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                
                $filter = ['type' => $categoryType];

                $options = [
                    'projection' => [
                        '_id' => 1,
                        'name' => 1,
                        'price' => 1,
                        'image' => 1,
                        'type' => 1,
                        'article' => 1,
                        'description' => 1
                    ],
                    'limit' => 15 
                ];
                
                $query = new MongoDB\Driver\Query($filter, $options);
                $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
                
                $hasProducts = false;
                
                foreach ($cursor as $product) {
                    $id = (string)$product->_id;
                    $name = htmlspecialchars($product->name ?? 'Без названия');
                    $price = htmlspecialchars($product->price ?? '0');
                    $image = htmlspecialchars($product->image ?? 'pictures/no-image.jpg');
                    $article = htmlspecialchars($product->article ?? '');
                    
                    if (strpos($image, 'productsPictures/') === 0) {
                        $image = 'pictures/' . substr($image, strlen('productsPictures/'));
                    } elseif (strpos($image, 'pictures/') !== 0) {
                        $image = 'pictures/' . $image;
                    }
                    
                    echo "<div class='product-card'>";
                    echo "   <a href='ProductPage.php?id={$id}'>";
                    echo "       <img src='{$image}' alt='{$name}' class='product-image' onerror=\"this.src='pictures/no-image.jpg'\">";
                    echo "   </a>";
                    echo "   <div class='product-info'>";
                    echo "   <div class='more-info'>";
                    echo "       <div class='product-name'>" . strtoupper($name) . "</div>";
                    echo "       <div class='product-price'>{$price} BYN</div>";
                    echo "       <div class='product-article'>{$article}</div>";
                    echo "   </div>";
                    echo "       <form method='POST' action='add_to_cart.php'>";
                    echo "           <input type='hidden' name='product_id' value='{$id}'>";
                    echo "           <button type='submit' class='add-to-cart'>В ИЗБРАННОЕ</button>";
                    echo "       </form>";
                    echo "   </div>";
                    echo "</div>";
                }
                
                if (!$hasProducts) {
                    echo "<div style='grid-column: 1 / -1; color: #666; padding: 40px; text-align: center;'>";
                    echo "<p>В категории '$categoryType' пока нет товаров</p>";
                    echo "</div>";
                }
                
            } catch (Exception $e) {
                echo "<div style='grid-column: 1 / -1; color: red; padding: 20px; text-align: center;'>";
                echo "<p>Ошибка при загрузке товаров: " . $e->getMessage() . "</p>";
                echo "</div>";
            }
            ?>
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