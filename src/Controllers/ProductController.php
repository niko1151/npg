<?php

namespace tec\npg\Controllers;

use PDO;
use PDOException;

/**
 * ProductController håndterer operationer relateret til produkter i webshoppen.
 */
class ProductController 
{
    /**
     * Metode som henter alle produkter fra databasen med tilhørende kategorinavne.
     *
     * @return array Et array af objekter repræsenterer produkter.
     */
    public static function getAllProducts() : array
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente produkter og tilhørende kategorinavne
            $stmnt = $pdo->prepare(
                "SELECT produkter.*, kategorier.kategori_navn 
                FROM produkter 
                INNER JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id;"
            );
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Metode som søger efter produkter baseret på et søgeord.
     *
     * Tager værdien fra søgefeltet og sender den til controlleren som $query.
     * Returnerer et array af objekter, der repræsenterer søgeresultaterne, eller et tomt array i tilfælde af fejl.
     *
     * $query Søgeordet, der skal søges efter i produktets navn.
     * @return array Et array af objekter repræsenterer søgeresultaterne eller et tomt array i tilfælde af fejl.
     */
    public static function searchProducts($query) : array
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at søge efter produkter baseret på navnet
            $stmnt = $pdo->prepare(
                "SELECT * FROM produkter WHERE produkt_navn LIKE :query"
            );
            $stmnt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);
    
            return $result;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error searching products: " . $e->getMessage());
            return []; // Returnerer et tomt array i tilfælde af fejl
        }
    }

    public static function addToCart($id)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmnt = $pdo->prepare("SELECT * FROM produkter WHERE produkt_id = ?");
            $stmnt->execute([$id]);
            $result = $stmnt->fetch(PDO::FETCH_OBJ);
    
            if ($result) {
                $_SESSION['cart'][] = $result;
                echo 'success'; // Return 'success' directly (no need for return)
            } else {
                echo 'Product not found'; // Return 'Product not found' if the product doesn't exist
            }
        } catch (PDOException $e) {
            error_log("Error adding product to cart: " . $e->getMessage());
            echo 'Error adding product to cart'; // Return an error message in case of exception
        }
    }


    /**
     * Metode som henter tre tilfældige produkter fra databasen med tilhørende kategorinavne.
     *
     * @return array Et array af objekter repræsenterer tilfældige produkter.
     */
    public static function getThreeRandomProducts() : array
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente tre tilfældige produkter og tilhørende kategorinavne
            $stmnt = $pdo->prepare(
                "SELECT produkter.*, kategorier.kategori_navn 
                FROM produkter 
                INNER JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id
                ORDER BY RAND() 
                LIMIT 3;"
            );
            $stmnt->execute();
            $result = $stmnt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error fetching random products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * metode Henter detaljer for et bestemt produkt baseret på produktets ID.
     *
     * $productId Produktets ID.
     * @return object|null Et objekt repræsenterer produktet eller null, hvis produktet ikke findes.
     */
    public static function getProductDetails($productId)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente detaljer for et produkt og tilhørende kategorinavn
            $stmnt = $pdo->prepare(
                "SELECT produkter.*, kategorier.kategori_navn 
                FROM produkter 
                INNER JOIN kategorier ON produkter.kategori_id = kategorier.kategori_id
                WHERE produkter.produkt_id = :productId;"
            );
            $stmnt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmnt->execute();
            $result = $stmnt->fetch(PDO::FETCH_OBJ); // Fetch som objekt i stedet for array

            return $result;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error fetching product details: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Opdaterer et produkt i databasen baseret på produktets ID.
     *
     * $productId Produktets ID.
     * $edit_product_name Nyt navn på produktet.
     * $edit_product_category_id Ny kategori ID til produktet.
     * $edit_product_quantity Ny mængde af produktet.
     * $edit_product_price Ny pris på produktet.
     * $edit_product_description Ny beskrivelse af produktet.
     * $edit_product_imageUrl Ny billed-URL for produktet.
     * True, hvis opdateringen er vellykket; ellers false.
     */
    public static function updateProduct($productId, $edit_product_name, $edit_product_category_id, $edit_product_quantity, $edit_product_price, $edit_product_description, $edit_product_imageUrl)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at opdatere et produkt
            $stmnt = $pdo->prepare(
                "UPDATE produkter 
                SET produkt_navn = :produkt_navn, kategori_id = :kategori_id, antal = :antal, pris = :pris, beskrivelse = :beskrivelse, billede_url = :billede_url
                WHERE produkt_id = :produkt_id"
            );
            
            $stmnt->execute([
                'produkt_id' => $productId,
                'produkt_navn' => $edit_product_name,
                'kategori_id' => $edit_product_category_id,
                'antal' => $edit_product_quantity,
                'pris' => $edit_product_price,
                'beskrivelse' => $edit_product_description,
                'billede_url' => $edit_product_imageUrl
            ]);
            

            return true; // Returnerer true, da opdateringen blev gennemført uden fejl
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Henter et produkt fra databasen baseret på produktets ID.
     *
     * @param int $productId Produktets ID.
     * @return object|null Et objekt repræsenterer produktet eller null, hvis produktet ikke findes.
     */
    public static function getProductById($productId)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at hente et produkt baseret på ID
            $stmnt = $pdo->prepare("SELECT * FROM produkter WHERE produkt_id = :id");
            $stmnt->bindParam(':id', $productId);
            $stmnt->execute();
            $result = $stmnt->fetch(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error fetching product by ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tilføjer et nyt produkt til databasen.
     *
     * $productName Navnet på det nye produkt.
     * $categoryId ID'en for kategorien, som produktet tilhører.
     * $quantity Antallet af det nye produkt.
     * $price Prisen på det nye produkt.
     * $description Beskrivelse af det nye produkt.
     * $imageUrl URL'en til billedet af det nye produkt.
     * True, hvis tilføjelsen er vellykket; ellers false.
     */
    public static function addProduct($productName, $categoryId, $quantity, $price, $description, $imageUrl)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at tilføje et nyt produkt
            $stmnt = $pdo->prepare(
                "INSERT INTO produkter (produkt_navn, kategori_id, antal, pris, beskrivelse, billede_url)
                VALUES (:produkt_navn, :kategori_id, :antal, :pris, :beskrivelse, :billede_url)"
            );
            $stmnt->execute([
                'produkt_navn' => $productName,
                'kategori_id' => $categoryId,
                'antal' => $quantity,
                'pris' => $price,
                'beskrivelse' => $description,
                'billede_url' => $imageUrl
            ]);

            return true; // Returnerer true, da tilføjelsen blev gennemført uden fejl
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error adding product: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sletter et produkt fra databasen baseret på produktets ID.
     *
     * @param int $productId Produktets ID.
     * @return bool True, hvis sletningen er vellykket; ellers false.
     */
    public static function deleteProduct($productId)
    {
        try {
            // Opretter en forbindelse til databasen
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Forbereder og udfører en SQL-forespørgsel for at slette et produkt
            $stmnt = $pdo->prepare("DELETE FROM produkter WHERE produkt_id = :id");
            $stmnt->bindParam(':id', $productId);
            $stmnt->execute();

            return true;
        } catch (PDOException $e) {
            // Håndterer databasefejl og logger dem
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}
