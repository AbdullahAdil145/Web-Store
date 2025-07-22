<?php
session_start();
require '../config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

$stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>All Orders (Admin)</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>
                        <a href="../order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
