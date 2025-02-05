<?php
include 'includes/header.php';
include 'db.php';

// Fetch all products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch best sellers
$stmt = $conn->query("SELECT * FROM products WHERE is_bestseller = 1");
$bestsellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h2>Best Sellers</h2>
    <div class="products">
        <?php foreach ($bestsellers as $product): ?>
            <div class="product">
                <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <p>$<?= $product['price'] ?></p>
                <a href="product.php?id=<?= $product['id'] ?>">View Product</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>All Products</h2>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <p>$<?= $product['price'] ?></p>
                <a href="product.php?id=<?= $product['id'] ?>">View Product</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>