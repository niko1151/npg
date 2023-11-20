<?php

namespace tec\npg\Controllers;

use PDO;

class CategoryController 
{
    
    public static function getAllCategory() : array
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM kategorier");
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ); // Hent data som objekter

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching categories: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }
}