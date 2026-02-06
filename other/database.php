<?php
require_once 'vendor/autoload.php';

class MongoDBConnection {
    private $client;
    private $database;
    
    public function __construct() {
        try {
            // Подключение к MongoDB
            $this->client = new MongoDB\Client("mongodb://localhost:27017");
            $this->database = $this->client->clothingStoreCatalog;
        } catch (Exception $e) {
            die("Ошибка подключения к MongoDB: " . $e->getMessage());
        }
    }
    
    public function getProductsByCategory($category = null, $limit = 5) {
        try {
            $collection = $this->database->products;
            
            $filter = [];
            if ($category) {
                $filter['type'] = $category;
            }
            
            $options = [
                'limit' => $limit,
                'sort' => ['price' => 1]
            ];
            
            $cursor = $collection->find($filter, $options);
            return iterator_to_array($cursor);
            
        } catch (Exception $e) {
            error_log("Ошибка получения товаров: " . $e->getMessage());
            return [];
        }
    }
    
    public function getCategories() {
        try {
            $collection = $this->database->products;
            
            // Получаем уникальные категории
            $categories = $collection->distinct('type');
            return array_filter($categories); // Убираем пустые значения
            
        } catch (Exception $e) {
            error_log("Ошибка получения категорий: " . $e->getMessage());
            return [];
        }
    }
}
?>