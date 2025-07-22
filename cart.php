<?php
session_start();
require 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove'])) {
        $id = $_POST['remove'];
        unset($_SESSION['cart'][$id]);
    }

    if (isset($_POST['update'])) {
        foreach ($_POST['quantity'] as $id => $qty) {
            if ($qty <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id] = $qty;
            }
        }
    }

    header("Location: cart.php");
    exit();
}

$cart_items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($ids)");
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cart_items as $item) {
        $quantity = $_SESSION['cart'][$item['id']];
        $total += $item['price'] * $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Your Shopping Cart</h2>
    <a href="products.php" class="btn btn-secondary mb-3">Continue Shopping</a>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo $item['price']; ?></td>
                            <td>
                                <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $_SESSION['cart'][$item['id']]; ?>" min="1" class="form-control">
                            </td>
                            <td>$<?php echo number_format($item['price'] * $_SESSION['cart'][$item['id']], 2); ?></td>
                            <td>
                                <button name="remove" value="<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="fw-bold">Total: $<?php echo number_format($total, 2); ?></p>

            <button name="update" value="1" class="btn btn-primary">Update Cart</button>
            <a href="checkout.php" class="btn btn-success">Checkout</a>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
