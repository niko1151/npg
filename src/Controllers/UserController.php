<?php
namespace tec\npg\Controllers;

use PDO;
use PDOException;

/**
 * UserController-klassen håndterer operationer relateret til brugere i webshoppen.
 */
class UserController
{
    /**
     * Henter alle brugere fra databasen.
     *
     * @return array Et array af objekter repræsenterer brugere.
     */
    public static function getAllUsers() : array 
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Forbereder og udfører en SQL-forespørgsel for at hente alle brugere
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

    /**
     * Henter en bruger baseret på brugerens ID.
     *
     * $id Brugerens ID.
     * @return object|null Et objekt repræsenterer brugeren eller null, hvis den ikke findes.
     */
    public static function getUser($id)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Forbereder og udfører en SQL-forespørgsel for at hente en bruger baseret på ID
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

    /**
     * Tjekker brugerlogin ved at sammenligne e-mail og adgangskode.
     *
     * $email Brugerens e-mail.
     * $adgangskode Brugerens adgangskode.
     * @return object|null Et objekt repræsenterer brugeren eller null, hvis login mislykkes.
     */
    public static function checkUserLogin($email, $adgangskode)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Forbereder og udfører en SQL-forespørgsel for at tjekke brugerlogin
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

    /**
     * Opretter en ny bruger i databasen.
     *
     * $FirstName Fornavn på den nye bruger.
     * $LastName Efternavn på den nye bruger.
     * $Email E-mail på den nye bruger.
     * $Telefon Telefonnummer på den nye bruger.
     * $Pass Adgangskode på den nye bruger.
     * $Adresse Adresse på den nye bruger.
     * $By By på den nye bruger.
     * $PostNr Postnummer på den nye bruger.
     * @return bool True, hvis oprettelsen er vellykket; ellers false.
     */
    public static function createUser($FirstName, $LastName, $Email, $Telefon, $Pass, $Adresse, $By, $PostNr)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Forbereder og udfører en SQL-forespørgsel for at oprette en ny bruger
            $stmnt = $pdo->prepare(
            "INSERT INTO kunder (fornavn, efternavn, email, adgangskode, adresse, by_navn, postnummer, telefonnummer, adminP) 
            VALUES (:fornavn, :efternavn, :email, :adgangskode, :adresse, :by_navn, :postnummer, :telefonnummer, 0);");
            $stmnt->execute([
                'fornavn'=>$FirstName,
                'efternavn'=>$LastName,
                'email'=>$Email,
                'adgangskode'=>$Pass,
                'adresse'=>$Adresse,
                'by_navn'=>$By,
                'postnummer'=>$PostNr,
                'telefonnummer'=>$Telefon
            ]);

            // Hent data som objekter
            $result = $stmnt->fetch(PDO::FETCH_OBJ);

            return (bool)$result;

        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error fetching User: " . $e->getMessage());
            return []; // Returner en tom liste i tilfælde af fejl
        }
    }
}
