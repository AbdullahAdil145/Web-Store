<?php
session_start();
require 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

$orders = [];

if ($isLoggedIn) {
    if ($isAdmin) {
        $stmt = $conn->prepare("
            SELECT orders.*, users.name AS user_name
            FROM orders
            JOIN users ON orders.user_id = users.id
            ORDER BY orders.id DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Computer Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">

    <?php if ($isLoggedIn): ?>

        <div class="card p-5 text-center shadow-sm mb-5">
            <h1 class="fw-bold mb-3">Welcome to <span class="text-primary">Online Computer Store</span></h1>
            <p class="display-6 fw-bold mb-4"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>

            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="products.php" class="btn btn-primary btn-lg px-4">Browse Products</a>

                <?php if (!$isAdmin): ?>
                    <a href="cart.php" class="btn btn-success btn-lg px-4">View Cart</a>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                    <a href="online_computer_store/admin/dashboard.php" class="btn btn-warning btn-lg px-4">Admin Dashboard</a>
                    <a href="online_computer_store/admin/admin_users.php" class="btn btn-info btn-lg px-4">View All Users</a>
                <?php endif; ?>

                <a href="logout.php" class="btn btn-danger btn-lg px-4">Logout</a>
            </div>
        </div>

        <?php if (!empty($orders)): ?>
            <h3 class="fw-bold mb-3"><?php echo $isAdmin ? 'All Orders' : 'Your Order History'; ?></h3>
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <?php if ($isAdmin): ?>
                            <th>User</th>
                        <?php endif; ?>
                        <th>Total Price</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <?php if ($isAdmin): ?>
                                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <?php endif; ?>
                            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mt-5">
                <?php echo $isAdmin ? 'No orders placed yet.' : 'You have no previous orders.'; ?>
            </p>
        <?php endif; ?>

    <?php else: ?>

        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5" style="min-height: 70vh;">
            <h1 class="mb-4 fw-bold">Welcome to Online Computer Store</h1>
            <p class="mb-5 text-muted fs-5">Login or register to start shopping top computer products.</p>

            <div>
                <a href="login.php" class="btn btn-dark btn-lg px-5 py-3 mb-3 me-3">Login</a>
                <a href="register.php" class="btn btn-success btn-lg px-5 py-3 mb-3">Register</a>
            </div>
        </div>

    <?php endif; ?>

</div>

</body>
</html>
