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
            <h1 class="category-title-main">ИЗБРАННЫЕ ТОВАРЫ</h1>
        </div>

        <div class="products-grid" id="favorites-container">
            <?php
            try {

                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                
                $options = [
                    'projection' => [
                        '_id' => 1,
                        'name' => 1,
                        'price' => 1,
                        'image' => 1,
                        'type' => 1,
                        'article' => 1,
                        'description' => 1
                    ]
                ];
                
                $query = new MongoDB\Driver\Query([], $options);
                $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
                
                // Проверяем, есть ли товары
                $hasProducts = false;
                
                foreach ($cursor as $product) {
                    $hasProducts = true;
                    $id = (string)$product->_id;
                    $name = htmlspecialchars($product->name ?? 'Без названия');
                    $price = htmlspecialchars($product->price ?? '0');
                    $image = htmlspecialchars($product->image ?? 'pictures/no-image.jpg');
                    $article = htmlspecialchars($product->article ?? '');
                    
                    // Обрабатываем путь к картинке
                    if (strpos($image, 'productsPictures/') === 0) {
                        $image = 'pictures/' . substr($image, strlen('productsPictures/'));
                    } elseif (strpos($image, 'pictures/') !== 0) {
                        $image = 'pictures/' . $image;
                    }
                    
                    echo "<div class='product-card favorite-product' data-product-id='{$id}'>";
                    echo "   <a href='ProductPage.php?id={$id}'>";
                    echo "       <img src='{$image}' alt='{$name}' class='product-image' onerror=\"this.src='pictures/no-image.jpg'\">";
                    echo "   </a>";
                    echo "   <div class='product-info'>";
                    echo "   <div class='more-info'>";
                    echo "       <div class='product-name'>" . strtoupper($name) . "</div>";
                    echo "       <div class='product-price'>{$price} BYN</div>";
                    echo "       <div class='product-article'>{$article}</div>";
                    echo "   </div>";
                    echo "       <button class='remove-from-favorites' data-product-id='{$id}' onclick='removeFromFavorites(this)'>УДАЛИТЬ ИЗ ИЗБРАННОГО</button>";
                    echo "   </div>";
                    echo "</div>";
                }
                
                if (!$hasProducts) {
                    echo "<div style='grid-column: 1 / -1; color: #666; padding: 40px; text-align: center;'>";
                    echo "<p>В базе данных пока нет товаров</p>";
                    echo "</div>";
                }
                
            } catch (Exception $e) {
                echo "<div style='grid-column: 1 / -1; color: red; padding: 20px; text-align: center;'>";
                echo "<p>Ошибка при загрузке товаров: " . $e->getMessage() . "</p>";
                echo "</div>";
            }
            ?>
        </div>
        
        <div id="no-favorites-message" style="display: none; grid-column: 1 / -1; color: #666; padding: 40px; text-align: center;">
            <p>У вас пока нет избранных товаров</p>
            <p><a href="CatalogPage.php?type=ПЛАТЬЯ" style="color: #333; text-decoration: underline;">Перейти в каталог</a></p>
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

<style>
    /* Стили для кнопки удаления из избранного */
    .remove-from-favorites {
        background-color: #ff4444;
        color: white;
        border: 1px solid #cc0000;
        padding: 10px 16px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 15px;
        width: 100%;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .remove-from-favorites:hover {
        background-color: #cc0000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(204, 0, 0, 0.2);
    }

    .remove-from-favorites:active {
        transform: translateY(0);
    }
    
    /* Стили для карточек товаров на странице избранного */
    .favorite-product {
        position: relative;
    }
    
    /* Стиль для сообщения об отсутствии избранных товаров */
    #no-favorites-message {
        font-size: 18px;
        color: #666;
        padding: 60px 20px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    #no-favorites-message a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 2px solid #333;
        padding-bottom: 2px;
    }
    
    #no-favorites-message a:hover {
        color: #ff4444;
        border-color: #ff4444;
    }
</style>


    <script src="JSCode/HeaderMenuScript.js"></script>
    <script>
    // Функция для удаления из избранного
    function removeFromFavorites(button) {
        const productId = button.getAttribute('data-product-id');
        
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        
        // Удаляем товар из избранного
        favorites = favorites.filter(id => id !== productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        
        // Скрываем удаленный товар
        const productCard = button.closest('.product-card');
        productCard.style.display = 'none';
        
        // Проверяем, остались ли избранные товары
        checkFavorites();
        
        // Обновляем счетчик в хедере (если есть)
        updateFavoritesCount();
    }
    
    // Функция для фильтрации избранных товаров
    function filterFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const productCards = document.querySelectorAll('.favorite-product');
        let hasVisibleProducts = false;
        
        productCards.forEach(card => {
            const productId = card.getAttribute('data-product-id');
            if (favorites.includes(productId)) {
                card.style.display = 'block';
                hasVisibleProducts = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Показываем/скрываем сообщение об отсутствии избранных
        const noFavoritesMessage = document.getElementById('no-favorites-message');
        if (hasVisibleProducts) {
            noFavoritesMessage.style.display = 'none';
        } else {
            noFavoritesMessage.style.display = 'block';
        }
    }
    
    // Функция для проверки избранных товаров
    function checkFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const noFavoritesMessage = document.getElementById('no-favorites-message');
        
        if (favorites.length === 0) {
            noFavoritesMessage.style.display = 'block';
        } else {
            noFavoritesMessage.style.display = 'none';
        }
    }
    
    // Функция для обновления счетчика избранных (если есть в хедере)
    function updateFavoritesCount() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const favoritesCount = favorites.length;
        
        // Если у вас есть элемент для отображения количества избранных
        const favoritesButton = document.querySelector('button[title="Избранные товары"]');
        if (favoritesButton) {
            // Можно добавить бейдж с количеством
            let badge = favoritesButton.querySelector('.favorites-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'favorites-badge';
                badge.style.cssText = 'position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 12px; display: flex; align-items: center; justify-content: center;';
                favoritesButton.style.position = 'relative';
                favoritesButton.appendChild(badge);
            }
            
            if (favoritesCount > 0) {
                badge.textContent = favoritesCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    // При загрузке страницы фильтруем товары
    document.addEventListener('DOMContentLoaded', function() {
        filterFavorites();
        updateFavoritesCount();
    });
    </script>
</body>
</html>
