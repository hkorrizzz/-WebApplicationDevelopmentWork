<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ZZZEST - Каталог женской одежды</title>
    <link rel="stylesheet" href="styles/StyleWelcomPage.css">
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
        <button id="registerButton" title="Регистрация" aria-label="Регистрация"><img src="pictures/profil-Photoroom.png" class="header-icon"></button>
        <button id="menuButton" title="Меню" aria-label="Меню"><img src="pictures/menu-icon.jpg" class="header-icon"></button>
    </div>

    <div id="enterAccount">
        <div id="registerModal" class="register-modal">
            <div class="register-container">
                <div class="register-header">
                    <button id="closeRegister" class="close-register">&times;</button>
                </div>  
                
                <div class="register-content">
                    <div class="register-subtitle">ВХОД</div>
                    
                    <form id="registerForm">
                        <div class="input-group">
                            <label class="input-label">Логин</label>    
                            <input type="text" class="text-input" placeholder="" required>
                        </div>
                        
                        <div class="input-group">
                            <label class="input-label">Пароль</label>
                            <input type="password" class="text-input" placeholder="" required>
                            <a href="#" class="sms-link">ВОЙТИ ПО СМС</a>
                            <a href="#" class="forgot-link">ЗАБЫЛИ ПАРОЛЬ?</a>
                        </div>
                        
                        <button type="submit" class="register-button">ВОЙТИ</button>
                        
                        <a href="#" class="login-link">ЗАРЕГИСТРИРОВАТЬСЯ</a>
                    </form>
                </div>
            </div>
        </div>
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

    <div class="simple-hero">
        <img src="pictures/BackgroundChinaGirlPickture.jpg" alt="Новая коллекция" class="hero-image">
        <a href="#catalog-section" class="hero-button">КОЛЛЕКЦИЯ</a>
    </div>

    <div class="catalog" id="catalog-section">
        <div class="category-section">
            <?php 
                // 
                    $type = 'ПЛАТЬЯ';
                    include 'phpCode/products.php'; 
                ?>
        </div>

    </div>

    <div class="about">
        <h2>О бренде ZZZEST</h2>
        <p>ZZZEST - это современный бренд женской одежды, создающий стильные и качественные вещи для уверенных в себе женщин. Мы следим за последними тенденциями моды и предлагаем нашим клиенткам только лучшее.</p>
        <p>Наша миссия - помочь каждой женщине раскрыть свою индивидуальность через стиль и комфорт.</p>
    </div>

    <div class="newsletter">
        <h2>Подпишитесь на нашу рассылку</h2>
        <p>Узнавайте первыми о новых коллекциях и специальных предложениях</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Ваш email" required>
            <button type="submit">Подписаться</button>
        </form>
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

    <style>
        html {
            scroll-behavior: smooth;
        }
        
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }
    </style>
</body>
</html>