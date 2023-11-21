<?php

namespace tec\npg\Controllers;

use PDO;
use PDOException;

class ProductController 
{
    private static $pdo;

    public function __construct()
    {
        // Initialiser PDO-forbindelsen i konstruktøren
        try {
            self::$pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error connecting to database: " . $e->getMessage());
        }
    }

    public static function getAllProducts() : array
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmnt = $pdo->prepare(
            "SELECT produkter.*, kategorier.kategori_navn 
            FROM produkter 
            INNER JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id;");
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    public static function getProductDetails($productId)
{
    try {
        $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmnt = $pdo->prepare(
            "SELECT produkter.*, kategorier.kategori_navn 
            FROM produkter 
            INNER JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id
            WHERE produkter.produkt_id = :productId;"
        );
        $stmnt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmnt->execute();
        $result = $stmnt->fetch(PDO::FETCH_OBJ); // Fetch as object instead of array

        return $result;
    } catch (PDOException $e) {
        // Log eller håndter fejlen efter behov
        error_log("Error fetching product details: " . $e->getMessage());
        return null;
    }
}

    public static function getProductById($productId)
    {
        try {
            $stmnt = self::$pdo->prepare("SELECT * FROM produkter WHERE produkt_id = :id");
            $stmnt->bindParam(':id', $productId);
            $stmnt->execute();
            $result = $stmnt->fetch(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching product by ID: " . $e->getMessage());
            return null;
        }
    }

    public static function addProduct($productName, $price, $categoryId, $description)
    {
        try {
            $stmnt = self::$pdo->prepare(
                "INSERT INTO produkter (produkt_navn, pris, kategori_id, beskrivelse) 
                VALUES (:name, :price, :categoryId, :description)"
            );
            $stmnt->bindParam(':name', $productName);
            $stmnt->bindParam(':price', $price);
            $stmnt->bindParam(':categoryId', $categoryId);
            $stmnt->bindParam(':description', $description);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error adding product: " . $e->getMessage());
            return false;
        }
    }

    public static function updateProduct($productId, $productName, $price, $categoryId, $description)
    {
        try {
            $stmnt = self::$pdo->prepare(
                "UPDATE produkter 
                SET produkt_navn = :name, pris = :price, kategori_id = :categoryId, beskrivelse = :description
                WHERE produkt_id = :id"
            );
            $stmnt->bindParam(':id', $productId);
            $stmnt->bindParam(':name', $productName);
            $stmnt->bindParam(':price', $price);
            $stmnt->bindParam(':categoryId', $categoryId);
            $stmnt->bindParam(':description', $description);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteProduct($productId)
    {
        try {
            $stmnt = self::$pdo->prepare("DELETE FROM produkter WHERE produkt_id = :id");
            $stmnt->bindParam(':id', $productId);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}