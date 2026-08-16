<?php
require_once 'connection.php';

$stmt = $pdo->query("SELECT _id, name, price, image, type, article, description FROM products ORDER BY name");
$allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ZZZEST - Избранные товары</title>
    <link rel="stylesheet" href="styles/CatalogPage.css">
    <link rel="stylesheet" href="styles/HeaderMenuStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="search"><input type="text" placeholder="Найти на сайте" /></div>
    <div class="brand"><a href="ZZZEST.php">ZZZEST</a></div>
    <div class="header-icons">
        <button title="Избранные товары" onclick="window.location.href='FavoritesPage.php'"><img src="pictures/heart-Photoroom.png" class="header-icon"></button>
        <button title="Вход в аккаунт"><img src="pictures/profil-Photoroom.png" class="header-icon"></button>
        <button id="menuButton" title="Меню"><img src="pictures/menu-icon.jpg" class="header-icon"></button>
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
        <h1 class="category-title-main">ИЗБРАННЫЕ ТОВАРЫ</h1>
    </div>

    <div class="products-grid" id="favorites-container">
        <?php foreach ($allProducts as $product): ?>
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
            <div class="product-card favorite-product" data-product-id="<?= $id ?>">
                <a href="Product.php?id=<?= $id ?>">
                    <img src="<?= $image ?>" alt="<?= $name ?>" class="product-image" onerror="this.src='pictures/no-image.jpg'">
                </a>
                <div class="product-info">
                    <div class="more-info">
                        <div class="product-name"><?= strtoupper($name) ?></div>
                        <div class="product-price"><?= $price ?> BYN</div>
                        <div class="product-article"><?= $article ?></div>
                    </div>
                    <button class="remove-from-favorites" data-product-id="<?= $id ?>" onclick="removeFromFavorites(this)">УДАЛИТЬ ИЗ ИЗБРАННОГО</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div id="no-favorites-message" style="display: none; text-align: center; padding: 60px 20px; font-size: 18px; color: #666;">
        <p>У вас пока нет избранных товаров</p>
    </div>
</div>

<footer>
    <div class="footer-left"><p>© 2025 ZZZEST. Все права защищены.</p></div>
    <div class="footer-center">
        <a href="https://instagram.com" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram"></a>
        <a href="https://telegram.org" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" alt="Telegram"></a>
    </div>
    <div class="footer-right"><p>+375 (25) 456-20-67<br>zzzest.brand@gmail.com</p></div>
</footer>

<style>
    .remove-from-favorites {
        background-color: #ff4444;
        color: white;
        border: 1px solid #cc0000;
        padding: 10px 16px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        margin-top: 15px;
        width: 100%;
        border-radius: 4px;
        text-transform: uppercase;
    }
    .remove-from-favorites:hover {
        background-color: #cc0000;
    }
</style>

<script src="JSCode/HeaderMenuScript.js"></script>
<script>
    function removeFromFavorites(button) {
        const productId = button.getAttribute('data-product-id');
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites = favorites.filter(id => id !== productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        button.closest('.product-card').style.display = 'none';
        checkFavorites();
        updateFavoritesCount(); 
    }
    
    function filterFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const cards = document.querySelectorAll('.favorite-product');
        let hasVisible = false;
        
        cards.forEach(card => {
            const id = card.getAttribute('data-product-id');
            if (favorites.includes(id)) {
                card.style.display = 'block';
                hasVisible = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        document.getElementById('no-favorites-message').style.display = hasVisible ? 'none' : 'block';
    }
    
    function checkFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        document.getElementById('no-favorites-message').style.display = favorites.length === 0 ? 'block' : 'none';
    }
    
    document.addEventListener('DOMContentLoaded', filterFavorites);
</script>
</body>
</html>