<?php
namespace tec\npg\Controllers;

use PDO;

class UserController
{

    public static function getUser($id)
    {
        $stmnt = PDO::getInstance()->prepare("SELECT * FROM kunder where kunde_id = ?;");
        $stmnt->execute([$id]);
        $result = $stmnt->fetchObject();

        return $result;
    }
    public static function checkUserLogin($email, $adgangskode)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM kunder where email = :email && adgangskode = :adgangskode;");
            $stmnt->execute(['email'=>$email, 'adgangskode'=>$adgangskode]);
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ); // Hent data som objekter

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching categories: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }

    public static function getAllUsers() : array
    {
        $stmnt = PDO::getInstance()->prepare("SELECT * FROM kunder;");
        $stmnt->execute([]);
        $result = $stmnt->fetchAll();

        return $result;
    }
    

}