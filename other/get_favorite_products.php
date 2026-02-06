<?php
// get_favorite_products.php

// Включим отладку
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Проверяем наличие расширения MongoDB
if (!extension_loaded('mongodb')) {
    die(json_encode(['error' => 'MongoDB extension not loaded']));
}

// Получаем данные из POST запроса
$input = json_decode(file_get_contents('php://input'), true);
$productIds = $input['productIds'] ?? [];

if (empty($productIds)) {
    echo json_encode([]);
    exit;
}

try {
    // Подключаемся к MongoDB
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    // Создаем фильтр для поиска товаров по ID
    // Преобразуем строковые ID в ObjectId
    $filter = ['_id' => ['$in' => array_map(function($id) {
        return new MongoDB\BSON\ObjectId($id);
    }, $productIds)]];
    
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
        ]
    ];
    
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $manager->executeQuery("clothingStoreCatalog.products", $query);
    
    // Преобразуем результат в массив
    $products = [];
    foreach ($cursor as $document) {
        $products[] = [
            '_id' => (string)$document->_id,
            'name' => $document->name ?? 'Без названия',
            'price' => $document->price ?? '0',
            'image' => $document->image ?? 'pictures/no-image.jpg',
            'article' => $document->article ?? '',
            'description' => $document->description ?? ''
        ];
    }
    
    // Отправляем результат в формате JSON
    header('Content-Type: application/json');
    echo json_encode($products);
    
} catch (Exception $e) {
    error_log("MongoDB Error: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
?>