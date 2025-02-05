<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total_amount = 0;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE product_id = $product_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total_amount += $product['price'] * $quantity;
        }
    }

    // Insert order into database
    $sql = "INSERT INTO orders (user_id, total_amount) VALUES ($user_id, $total_amount)";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                    VALUES ($order_id, $product_id, $quantity, (SELECT price FROM products WHERE product_id = $product_id))";
            $conn->query($sql);
        }
        unset($_SESSION['cart']); // Clear cart after order is placed
        echo "Order placed successfully!";
    } else {
        echo "Error placing order: " . $conn->error;
    }
}

$conn->close();
?>
