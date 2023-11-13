<?php
$servername = "127.0.0.1:3306"; // MySQL server name (usually "localhost")
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "webshop"; // MySQL database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>