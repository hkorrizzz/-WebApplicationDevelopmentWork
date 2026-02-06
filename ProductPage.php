<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Одежда ZZZEST</title>
    <link rel="stylesheet" href="styles/ClothPage.css">
    <link rel="stylesheet" href="styles/HeaderMenuStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div style='color: red; text-align: center; padding: 20px;'>❌ Ошибка: ID товара не указан.</div>");
}

$productId = $_GET['id'];

try {
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    $filter = ['_id' => new MongoDB\BSON\ObjectId($productId)];
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
        'limit' => 1
    ];
    
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
    
    $product = null;
   
    $product = $document;
   
    
    if (!$product) {
        die("<div style='color: red; text-align: center; padding: 20px;'>❌ Товар не найден.</div>");
    }
    
    $id = (string)$product->_id;
    $name = htmlspecialchars($product->name ?? 'Без названия');
    $price = htmlspecialchars($product->price ?? '0');
    $image = htmlspecialchars($product->image ?? 'pictures/no-image.jpg');
    $article = htmlspecialchars($product->article ?? '');
    $description = htmlspecialchars($product->description ?? 'Нет описания');
    $type = htmlspecialchars($product->type ?? 'Не указан');
    
    if (strpos($image, 'productsPictures/') === 0) {
        $image = 'pictures/' . substr($image, strlen('productsPictures/'));
    } elseif (strpos($image, 'pictures/') !== 0) {
        $image = 'pictures/' . $image;
    }
    
} 
 catch (Exception $e) {
    die("<div style='color: red; text-align: center; padding: 20px;'>❌ Ошибка: " . $e->getMessage() . "</div>");
}
?>

<header>
    <div class="search">
        <input type="text" placeholder="Найти на сайте" />
    </div>
    <div class="brand">
        <a href="WelcomePage.php">ZZZEST</a>
    </div>
    <div class="header-icons">
        <button title="Избранные товары" aria-label="Избранные товары" onclick="window.location.href='FavoritesPage.php'"><img src="pictures/heart-Photoroom.png" class="header-icon"></button>
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
    
<div class="main-container">
    <div class="product-content">
        <a href="WelcomePage.php" class="come-back">В МАГАЗИН</a>
        
        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="product-image" onerror="this.src='pictures/no-image.jpg'">
        
        <div class="product-info">
            <div class="name"><?php echo strtoupper($name); ?></div>
            <div class="product-code"><?php echo $article; ?></div>

            <button title="Избранные товары" class="addToFavoriteBackSlyle" id="favoriteBtn">
                <img src="pictures/heart-Photoroom.png" class="addToFavoriteSlyle" id="heartIcon">
            </button>
            
            <div class="price"><?php echo $price; ?> BYN</div>

            <details>
                <summary class="typeCloth">ТИП ИЗДЕЛИЯ</summary>
                <p class="typeClothName"><?php echo $type; ?></p>
            </details>
            
            <details>
                <summary class="typeCloth">РАЗМЕРНАЯ СЕТКА</summary>
                <p class="typeClothName">42-46</p>
            </details>
            
            <details>
                <summary class="typeCloth">ОПИСАНИЕ</summary>
                <p class="typeClothName"><?php echo $description; ?></p>
            </details>
            
            <details open>
                <summary class="typeCloth">НАЛИЧИЕ В МАГАЗИНАХ</summary>
                <div class="store-availability">
                    <div class="store-item">
                        <div class="storeAdress">Минск, ТЦ "Dana Mall"</div>
                        <div class="availability">В наличии: 40, 48</div>
                    </div>
                    
                    <div class="store-item">
                        <div class="storeAdress">Минск, ТРЦ "Галерея Минск"</div>
                        <div class="availability">Нет в наличии</div>
                    </div>
                    
                    <div class="store-item">
                        <div class="storeAdress">Брест, ул. 17-го сентября 12</div>
                        <div class="availability">В наличии: 40, 42, 46, 48</div>
                    </div>
                    
                    <div class="store-item">
                        <div class="storeAdress">Гродно, ул. Советская 10</div>
                        <div class="availability">В наличии: 40, 42, 46</div>
                    </div>
                </div>
            </details>
            
        </div>
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
<script src="JSCode/ClothPageJS.js"></script>
</body>
</html>