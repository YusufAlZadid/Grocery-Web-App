<?php
$host = 'database-1.cxgma6sm2aml.ap-southeast-2.rds.amazonaws.com';
$dbname = 'grocery_store';
$username = 'admin';
$password = 'dhrubo20';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>