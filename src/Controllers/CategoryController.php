<?php

namespace tec\npg\Controllers;

use PDO;
use PDOException;

class CategoryController 
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
            error_log("Fejl ved forbindelse til database: " . $e->getMessage());
            throw $e; // Kast exceptionen igen for at stoppe scriptet
        }
    }

    public static function getAllCategories() : array
    {
        try {
            $stmnt = self::$pdo->prepare("SELECT * FROM kategorier");
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved hentning af kategorier: " . $e->getMessage());
            return [];
        }
    }
    
    public static function getProductsByCategory($categoryId): array
    {
    try {
        $stmnt = self::$pdo->prepare(
        "SELECT produkter.*, kategorier.kategori_navn 
        FROM produkter
        JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id
        WHERE produkter.kategori_id = :id");
        $stmnt->bindParam(':id', $categoryId);
        $stmnt->execute();
        $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    } catch (PDOException $e) {
        // Log eller håndter fejlen efter behov
        error_log("Fejl ved hentning af produkter efter kategori: " . $e->getMessage());
        return [];
    }
}

    public static function getCategoryById($categoryId)
    {
        try {
            $stmnt = self::$pdo->prepare("SELECT * FROM kategorier WHERE kategori_id = :id");
            $stmnt->bindParam(':id', $categoryId);
            $stmnt->execute();
            $result = $stmnt->fetch(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved hentning af kategori efter ID: " . $e->getMessage());
            return null;
        }
    }

    public static function addCategory($categoryName)
    {
        try {
            $stmnt = self::$pdo->prepare("INSERT INTO kategorier (kategori_navn) VALUES (:name)");
            $stmnt->bindParam(':name', $categoryName);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved tilføjelse af kategori: " . $e->getMessage());
            return false;
        }
    }

    public static function updateCategory($categoryId, $categoryName)
    {
        try {
            $stmnt = self::$pdo->prepare("UPDATE kategorier SET kategori_navn = :name WHERE kategori_id = :id");
            $stmnt->bindParam(':id', $categoryId);
            $stmnt->bindParam(':name', $categoryName);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved opdatering af kategori: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteCategory($categoryId)
    {
        try {
            $stmnt = self::$pdo->prepare("DELETE FROM kategorier WHERE kategori_id = :id");
            $stmnt->bindParam(':id', $categoryId);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved sletning af kategori: " . $e->getMessage());
            return false;
        }
    }
}