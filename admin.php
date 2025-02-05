<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'db.php';

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin.php');
    exit();
}

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, is_bestseller) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image, $is_bestseller]);
    header('Location: admin.php');
    exit();
}

// Handle product editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, is_bestseller = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $image, $is_bestseller, $id]);
    header('Location: admin.php');
    exit();
}

// Fetch all products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<main class="admin-dashboard">
    <h2>Admin Dashboard</h2>

    <!-- Add Product Form -->
    <div class="form-container">
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="text" name="image" placeholder="Image File Name" required>
            <label>
                <input type="checkbox" name="is_bestseller"> Best Seller
            </label>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <h3>Products</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Best Seller</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td>$<?= $product['price'] ?></td>
                        <td><?= $product['is_bestseller'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="#" class="edit-btn" data-id="<?= $product['id'] ?>" data-name="<?= $product['name'] ?>" data-description="<?= $product['description'] ?>" data-price="<?= $product['price'] ?>" data-image="<?= $product['image'] ?>" data-bestseller="<?= $product['is_bestseller'] ?>">Edit</a>
                            <a href="admin.php?delete_product=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Edit Product</h3>
            <form method="POST">
                <input type="hidden" name="id" id="editProductId">
                <input type="text" name="name" id="editProductName" placeholder="Product Name" required>
                <textarea name="description" id="editProductDescription" placeholder="Description" required></textarea>
                <input type="number" name="price" id="editProductPrice" placeholder="Price" step="0.01" required>
                <input type="text" name="image" id="editProductImage" placeholder="Image File Name" required>
                <label>
                    <input type="checkbox" name="is_bestseller" id="editProductBestseller"> Best Seller
                </label>
                <button type="submit" name="edit_product">Save Changes</button>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>