<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Bypass router and test DB directly
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/Core/Database.php';

echo "<h2>Testing Database Connection...</h2>";
echo "Host: " . DB_SERVER . "<br>";
echo "User: " . DB_USER . "<br>";
echo "DB: " . DB_DATABASE . "<br><hr>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "<h3 style='color:green'>Connection Successful!</h3>";
    
    $stmt = $conn->prepare("SELECT * FROM tbl_items");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h4>Found " . count($items) . " items in tbl_items</h4>";
    if (count($items) === 0) {
        echo "<p style='color:red'>The query succeeded but 0 items were returned. The table is empty on this specific database server!</p>";
    } else {
        echo "<pre>";
        print_r($items);
        echo "</pre>";
    }
    
} catch (PDOException $e) {
    echo "<h3 style='color:red'>PDO Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
} catch (Exception $e) {
    echo "<h3 style='color:red'>General Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
