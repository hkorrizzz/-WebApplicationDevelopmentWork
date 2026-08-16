<?php

if (!isset($pdo)) {
    require_once '../connection.php';
}

$availableTypes = ['ЮБКИ', 'ФУТБОЛКИ', 'БРЮКИ', 'ТОПЫ', 'АКСЕССУАРЫ'];

if (isset($type) && in_array($type, $availableTypes)) {
    $currentType = $type;
    
    $stmt = $pdo->prepare("SELECT _id, name, price, image, type, article, description FROM products WHERE type = :type ORDER BY name LIMIT 5");
    $stmt->execute(['type' => $currentType]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);   
    
    echo "<div class='category-header'>";
    echo "    <h2 class='category-title'>$currentType</h2>";
    echo "    <div class='header-divider'></div>";
    echo "    <a href='Category.php?type=" . urlencode($currentType) . "' class='view-all-btn'>СМОТРЕТЬ ВСЕ</a>";
    echo "</div>";
    echo "<div class='products-scroll'>";
    
    if (empty($products)) {
        echo "<p style='color: #999; padding: 20px; text-align: center;'>В этой категории пока нет товаров</p>";
    } else {
        foreach ($products as $product) {
            $id = htmlspecialchars($product['_id']);
            $name = htmlspecialchars($product['name'] ?? 'Без названия');
            $price = htmlspecialchars($product['price'] ?? '0');
            $image = htmlspecialchars($product['image'] ?? 'pictures/no-image.jpg');
            $article = htmlspecialchars($product['article'] ?? '');
            
            if (strpos($image, 'productsPictures/') === 0) {
                $image = 'pictures/' . substr($image, strlen('productsPictures/'));
            }
            
            echo "<div class='product-card'>";
            echo "   <a href='Product.php?id={$id}'>";
            echo "       <img src='{$image}' alt='{$name}' class='product-image' onerror=\"this.src='pictures/no-image.jpg'\">";
            echo "   </a>";
            echo "   <div class='product-info'>";
            echo "   <div class='more-info'>";
            echo "       <div class='product-name'>" . strtoupper($name) . "</div>";
            echo "       <div class='product-price'>{$price} BYN</div>";
            echo "       <div class='product-article'>{$article}</div>";
            echo "   </div>";
            echo "       <button type='button' class='add-to-cart' data-product-id='{$id}' onclick='addToFavorites(this)'>В ИЗБРАННОЕ</button>";
            echo "   </div>";
            echo "</div>";
        }
    }
    
    echo "</div>";
    
} else {
    foreach ($availableTypes as $category) {
        $stmt = $pdo->prepare("SELECT _id, name, price, image, type, article, description FROM products WHERE type = :type ORDER BY name LIMIT 5");
        $stmt->execute(['type' => $category]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($products)) {
            echo "<div class='category-header'>";
            echo "    <h2 class='category-title'>$category</h2>";
            echo "    <div class='header-divider'></div>";
            echo "    <a href='Category.php?type=" . urlencode($category) . "' class='view-all-btn'>СМОТРЕТЬ ВСЕ</a>";
            echo "</div>";
            echo "<div class='products-scroll'>";
            
            foreach ($products as $product) {
                $id = htmlspecialchars($product['_id']);
                $name = htmlspecialchars($product['name'] ?? 'Без названия');
                $price = htmlspecialchars($product['price'] ?? '0');
                $image = htmlspecialchars($product['image'] ?? 'pictures/no-image.jpg');
                $article = htmlspecialchars($product['article'] ?? '');
                
                if (strpos($image, 'productsPictures/') === 0) {
                    $image = 'pictures/' . substr($image, strlen('productsPictures/'));
                }
                
                echo "<div class='product-card'>";
                echo "   <a href='Product.php?id={$id}'>";
                echo "       <img src='{$image}' alt='{$name}' class='product-image' onerror=\"this.src='pictures/no-image.jpg'\">";
                echo "   </a>";
                echo "   <div class='product-info'>";
                echo "   <div class='more-info'>";
                echo "       <div class='product-name'>" . strtoupper($name) . "</div>";
                echo "       <div class='product-price'>{$price} BYN</div>";
                echo "       <div class='product-article'>{$article}</div>";
                echo "   </div>";
                echo "       <button type='button' class='add-to-cart' data-product-id='{$id}' onclick='addToFavorites(this)'>В ИЗБРАННОЕ</button>";
                echo "   </div>";
                echo "</div>";
            }
            
            echo "</div>";
        }
    }
}
?>