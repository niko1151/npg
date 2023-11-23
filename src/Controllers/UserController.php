<?php
namespace tec\npg\Controllers;

use PDO;
use PDOException;

class UserController
{

    public static function getAllUsers() : array 
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM kunder;");
            $stmnt->execute([]);
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ); // Hent data som objekter

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching User: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }

    public static function getUser($id)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM kunder where kunde_id = ?;");
            $stmnt->execute([$id]);
            $result = $stmnt->fetch(PDO::FETCH_OBJ); // Hent data som objekter

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching User: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }

    public static function checkUserLogin($email, $adgangskode)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM kunder where email = :email && adgangskode = :adgangskode;");
            $stmnt->execute(['email'=>$email, 'adgangskode'=>$adgangskode]);
            $result = $stmnt->fetch(PDO::FETCH_OBJ); // Hent data som objekter

            return $result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching checkUserLogin: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }

    public static function createUser($FirstName, $LastName, $Email, $Telefon, $Pass, $Adresse, $By, $PostNr)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare(
            "INSERT INTO kunder (fornavn, efternavn, email, adgangskode, adresse, by_navn, postnummer, telefonnummer,adminP) 
            VALUES (:fornavn, :efternavn, :email, :adgangskode, :adresse, :by_navn, :postnummer, :telefonnummer, 0);");
            $stmnt->execute(['fornavn'=>$FirstName, 'efternavn'=>$LastName, 'email'=>$Email, 'adgangskode'=>$Pass, 'adresse'=>$Adresse, 'by_navn'=>$By, 'postnummer'=>$PostNr, 'telefonnummer'=>$Telefon]);
            $result = $stmnt->fetch(PDO::FETCH_OBJ); // Hent data som objekter

            return (bool)$result;

        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching User: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }
}