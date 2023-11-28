<?php

namespace tec\npg\Controllers;

use PDO;
use PDOException;

/**
 * Klassen CategoryController håndterer operationer relateret til kategorier i webshoppen.
 */
class CategoryController 
{

    /**
     * Henter alle kategorier fra databasen.
     *
     * @return array Et array af objekter repræsenterer kategorier.
     */
    public static function getAllCategories() : array
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente alle kategorier
            $stmnt = $pdo->prepare("SELECT * FROM kategorier");
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved hentning af kategorier: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Henter produkter baseret på en given kategori.
     *
     * $categoryId Kategoriens ID.
     * @return array Et array af objekter repræsenterer produkter.
     */
    public static function getProductsByCategory($categoryId): array
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente produkter baseret på kategori
            $stmnt = $pdo->prepare(
                "SELECT produkter.*, kategorier.kategori_navn 
                FROM produkter
                JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id
                WHERE produkter.kategori_id = ?");
            $stmnt->execute([$categoryId]);
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved hentning af produkter efter kategori: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Henter en kategori baseret på kategoriens ID.
     *
     * $categoryId Kategoriens ID.
     * @return object|null Et objekt repræsenterer kategorien eller null, hvis den ikke findes.
     */
    public static function getCategoryById($categoryId)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente en kategori baseret på ID
            $stmnt = $pdo->prepare("SELECT * FROM kategorier WHERE kategori_id = :id");
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

    /**
     * Tilføjer en ny kategori til databasen.
     *
     * $categoryName Navnet på den nye kategori.
     * @return bool True, hvis tilføjelsen er vellykket; ellers false.
     */
    public static function addCategory($categoryName)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at tilføje en ny kategori
            $stmnt = $pdo->prepare("INSERT INTO kategorier (kategori_navn) VALUES (:name)");
            $stmnt->bindParam(':name', $categoryName);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved tilføjelse af kategori: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Opdaterer en eksisterende kategori i databasen.
     *
     * $categoryId Kategoriens ID.
     * $categoryName Nyt navn på kategorien.
     * @return bool True, hvis opdateringen er vellykket; ellers false.
     */
    public static function updateCategory($categoryId, $categoryName)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at opdatere en kategori
            $stmnt = $pdo->prepare(
                "UPDATE kategorier 
                SET kategori_navn = :kategori_navn
                WHERE kategori_id = :kategori_id"
            );

            $stmnt->execute(['kategori_id' => $categoryId, 'kategori_navn' => $categoryName]);

            return true;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Fejl ved opdatering af kategori: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sletter en kategori fra databasen baseret på kategoriens ID.
     * $categoryId Kategoriens ID.
     * @return bool True, hvis sletningen er vellykket; ellers false.
     */
    public static function deleteCategory($categoryId)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at slette en kategori
            $stmnt = $pdo->prepare("DELETE FROM kategorier WHERE kategori_id = :id");
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
