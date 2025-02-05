<?php
$host = 'localhost';
$dbname = 'belatkao_test_elektro';
$username = 'belatkao'; // Replace with your database username
$password = 'Maninek151*'; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>