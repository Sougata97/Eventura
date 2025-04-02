<?php
// Database connection
$host = 'localhost';
$dbname = 'eventura';
$username = 'root';
$password = ''; // Empty if using default XAMPP settings

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Error handling
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
