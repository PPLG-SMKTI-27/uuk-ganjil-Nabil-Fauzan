<?php
$host = "localhost";
$dbname = "buku_tamu";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database: $dbname<br><br>";
    
    // Check tables
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📊 Tables in database:<br>";
    if(count($tables) > 0) {
        foreach($tables as $table) {
            echo "• $table<br>";
        }
    } else {
        echo "❌ No tables found!<br>";
    }
    
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>