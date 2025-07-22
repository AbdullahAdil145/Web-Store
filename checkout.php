<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = 0;
$cart_items = [];

$ids = implode(',', array_keys($_SESSION['cart']));
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($ids)");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product) {
    $quantity = $_SESSION['cart'][$product['id']];
    $subtotal = $product['price'] * $quantity;
    $total_price += $subtotal;
    $cart_items[] = [
        'product_id' => $product['id'],
        'quantity' => $quantity,
        'price' => $product['price']
    ];
}

$conn->beginTransaction();

$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->execute([$user_id, $total_price]);
$order_id = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($cart_items as $item) {
    $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);

    $updateStock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $updateStock->execute([$item['quantity'], $item['product_id']]);
}

$conn->commit();

$_SESSION['cart'] = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Placed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Thank You!</h2>
    <p>Your order has been placed successfully.</p>
    <a href="products.php" class="btn btn-primary">Continue Shopping</a>
    <a href="order_history.php" class="btn btn-success">View Order History</a>
</div>

</body>
</html>
