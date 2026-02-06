<?php

function getProductsFromMongoDB($type = null) {
    try {
        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        
        $filter = [];
        if ($type) {
            $filter = ['type' => $type];
        }
        
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
            'limit' => 5 
        ];
        
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
        
        $products = [];
        foreach ($cursor as $document) {
            $products[] = $document;
        }
        
        return $products;
        
    } catch (Exception $e) {
        error_log("MongoDB Error: " . $e->getMessage());
        return [];
    }
}

function displayProducts($products) {
    if (empty($products)) {
        echo "<p style='color: #999; padding: 20px; text-align: center;'>В этой категории пока нет товаров</p>";
        return;
    }
    
    foreach ($products as $product) {
        $id = (string)$product->_id;
        $name = htmlspecialchars($product->name ?? 'Без названия');
        $price = htmlspecialchars($product->price ?? '0');
        $image = htmlspecialchars($product->image ?? 'pictures/no-image.jpg');
        $article = htmlspecialchars($product->article ?? '');
        
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
        echo "       <form method='POST' action='add_to_cart.php' style='display: inline;'>";
        echo "           <input type='hidden' name='product_id' value='{$id}'>";
        echo "           <button type='button' class='add-to-cart' data-product-id='{$id}' onclick='addToFavorites(this)'>В ИЗБРАННОЕ</button>";
        echo "       </form>";
        echo "   </div>";
        echo "</div>";
    }
}

// параметр type из URL
$currentType = isset($_GET['type']) ? $_GET['type'] : null;

if ($currentType) {
    //конкретный тип, показываем только его
    $products = getProductsFromMongoDB($currentType);
    
    echo "<div class='category-section'>";
    echo "    <div class='category-header'>";
    echo "        <h2 class='category-title'>$currentType</h2>";
    echo "        <div class='header-divider'></div>";
    echo "        <a href='CatalogPage.php?type=" . urlencode($currentType) . "' class='view-all-btn'>СМОТРЕТЬ ВСЕ</a>"; 
    echo "    </div>";
    echo "    <div class='products-scroll'>";
    
    displayProducts($products);
    
    echo "    </div>";
    echo "</div>";
    
} else {
    // тип не указан, показываем все категории
    $categories = [
        'ПЛАТЬЯ',
        'БЛУЗКИ', 
        'ЮБКИ',
        'ЖАКЕТЫ',
        'ВЕРХНЯЯ ОДЕЖДА',
        'ФУТБОЛКИ',
        'БРЮКИ',
        'ШОРТЫ',
        'ЖИЛЕТЫ',
        'ТОПЫ',
        'АКСЕССУАРЫ'
    ];
    
    foreach ($categories as $category) {
        $products = getProductsFromMongoDB($category);
        
        if (!empty($products)) {
            echo "<div class='category-section'>";
            echo "    <div class='category-header'>";
            echo "        <h2 class='category-title'>$category</h2>";
            echo "        <div class='header-divider'></div>";
            echo "        <a href='CatalogPage.php?type=" . urlencode($category) . "' class='view-all-btn'>СМОТРЕТЬ ВСЕ</a>"; // ИЗМЕНИЛИ ЗДЕСЬ
            echo "    </div>";
            echo "    <div class='products-scroll'>";
            
            displayProducts($products);
            
            echo "    </div>";
            echo "</div>";
        }
    }
}
?>