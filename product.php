<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<?php include 'includes/header.php'; ?>

<main class="product-detail">
    <div class="product-image">
        <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    </div>
    <div class="product-info">
        <h2><?= $product['name'] ?></h2>
        <p class="price">$<?= $product['price'] ?></p>
        <p class="description"><?= $product['description'] ?></p>
        <a href="buy.php?id=<?= $product['id'] ?>" class="buy-btn">Buy Now</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>