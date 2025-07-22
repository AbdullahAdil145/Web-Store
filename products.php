<?php
session_start();
require 'config.php';

$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
$category = isset($_GET['category']) ? $_GET['category'] : '';

if ($category) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? AND (name LIKE ? OR category LIKE ?) ORDER BY id DESC");
    $stmt->execute([$category, $search, $search]);
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR category LIKE ? ORDER BY id DESC");
    $stmt->execute([$search, $search]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .product-img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">All Products</h2>
    <a href="index.php" class="btn btn-secondary mb-3 me-2">Home</a>
    <a href="cart.php" class="btn btn-success mb-3">View Cart</a>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Laptops" <?php if($category=='Laptops') echo 'selected'; ?>>Laptops</option>
                    <option value="Monitors" <?php if($category=='Monitors') echo 'selected'; ?>>Monitors</option>
                    <option value="Accessories" <?php if($category=='Accessories') echo 'selected'; ?>>Accessories</option>
                    <option value="Storage" <?php if($category=='Storage') echo 'selected'; ?>>Storage</option>
                    <option value="Components" <?php if($category=='Components') echo 'selected'; ?>>Components</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100">Search / Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top product-img" alt="Product Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="card-text fw-bold">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-success w-100">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
