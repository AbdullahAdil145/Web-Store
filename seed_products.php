<?php
require 'config.php';

$url = 'https://dummyjson.com/products/category/laptops?limit=21';
$data = json_decode(file_get_contents($url), true);

$stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category, stock) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($data['products'] as $product) {
    $name = $product['title'];
    $description = $product['description'];
    $price = $product['price'];
    $image_url = $product['thumbnail'];
    $category = 'computers';
    $stock = rand(5, 30);

    $stmt->execute([$name, $description, $price, $image_url, $category, $stock]);
}

echo "Inserted 21 computer products with actual images from DummyJSON.";
?>
