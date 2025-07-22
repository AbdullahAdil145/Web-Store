<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['id'];

// Fetch order to confirm ownership (or allow admin)
$stmt = $conn->prepare("
    SELECT orders.*, users.name AS user_name
    FROM orders
    JOIN users ON orders.user_id = users.id
    WHERE orders.id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit();
}

$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
if (!$isAdmin && $order['user_id'] != $_SESSION['user_id']) {
    echo "Access denied.";
    exit();
}

// Fetch order items
$stmt = $conn->prepare("
    SELECT order_items.*, products.name
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2>Order Details - Order #<?php echo $order['id']; ?></h2>
    <p><strong>Placed by:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>

    <table class="table table-bordered bg-white mt-4">
        <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>

</body>
</html>
