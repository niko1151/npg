<?php

namespace tec\npg\Controllers;

use PDO;

class ProductController 
{
    public static function getAllProducts() : array
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmnt = $pdo->prepare("SELECT * FROM produkter");
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }
}