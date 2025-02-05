<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Košík</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Košík</h1>
    <a href="index.php">Zpět na hlavní stránku</a>
    <div class="cart">
        <?php
        if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            echo "<p>Košík je prázdný.</p>";
        } else {
            $total = 0;
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $sql = "SELECT * FROM products WHERE id = $productId";
                $result = $conn->query($sql);
                if ($row = $result->fetch_assoc()) {
                    $subtotal = $row['price'] * $quantity;
                    $total += $subtotal;
                    echo "
                    <div class='cart-item'>
                        <h2>{$row['name']}</h2>
                        <p>Cena: {$row['price']} Kč</p>
                        <p>Množství: $quantity</p>
                        <p>Mezisoučet: $subtotal Kč</p>
                    </div>";
                }
            }
            echo "<h3>Celková cena: $total Kč</h3>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
