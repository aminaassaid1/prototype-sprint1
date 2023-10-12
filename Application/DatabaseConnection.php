<?php
try {
    // Database connection parameters
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prototype";

    // Create a PDO instance with error handling
    $conn = new PDO("mysql:host=$serverName;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO error mode to exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>