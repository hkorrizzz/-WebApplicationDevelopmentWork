<?php
// catalog.php - отображает товары только для страницы каталога

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Проверяем наличие расширения MongoDB
if (!extension_loaded('mongodb')) {
    echo "<div style='color: red; text-align: center; padding: 20px;'>";
    echo "❌ Ошибка: Расширение MongoDB не установлено.";
    echo "</div>";
    exit;
}

// Получаем тип из внешней переменной или параметра
$type = isset($type) ? $type : (isset($_GET['type']) ? $_GET['type'] : 'ПЛАТЬЯ');

try {
    // Подключаемся к MongoDB
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    // Создаем фильтр по типу
    $filter = ['type' => $type];
    
    // Запрашиваем нужные поля
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
        'limit' => 15 // Больше товаров для каталога
    ];
    
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
    
    // Проверяем, есть ли товары
    $products = [];
    foreach ($cursor as $document) {
        $products[] = $document;
    }
    
    if (empty($products)) {
        echo "<div style='color: #666; padding: 40px; text-align: center;'>";
        echo "<p>В категории '$type' пока нет товаров</p>";
        echo "</div>";
        exit;
    }
    
    // Отображаем товары
    foreach ($products as $product) {
        $id = (string)$product->_id;
        $name = htmlspecialchars($product->name ?? 'Без названия');
        $price = htmlspecialchars($product->price ?? '0');
        $image = htmlspecialchars($product->image ?? 'pictures/no-image.jpg');
        $article = htmlspecialchars($product->article ?? '');
        
        // Обрабатываем путь к картинке
        if (strpos($image, 'productsPictures/') === 0) {
            $image = '../pictures/' . substr($image, strlen('productsPictures/'));
        } elseif (strpos($image, 'pictures/') !== 0) {
            $image = '../pictures/' . $image;
        }
        
        echo "<div class='product-card'>";
        echo "   <a href='ProductPage.php?id={$id}'>";
        echo "       <img src='{$image}' alt='{$name}' class='product-image' onerror=\"this.src='../pictures/no-image.jpg'\">";
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
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 20px; text-align: center;'>";
    echo "<p>Ошибка при загрузке товаров: " . $e->getMessage() . "</p>";
    echo "</div>";
}
?>