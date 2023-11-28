<?php

namespace tec\npg\Controllers;

use PDO;
use PDOException;

class ProductController 
{
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
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $pdo->prepare("SELECT * FROM produkter WHERE produkt_id = :id");
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

        // if ($result) {
        //     // Storing only the product ID in the cart
        //     $_SESSION['cart'][] = $id;
        //     echo 'success'; // Return 'success' directly (no need for return)
        // } else {
        //     echo 'Product not found'; // Return 'Product not found' if the product doesn't exist
        // }

        // } catch (PDOException $e) {
        //     error_log("Error adding product to cart: " . $e->getMessage());
        //     echo 'Error adding product to cart'; // Return an error message in case of exception
        // }
    }

    public static function addProduct($productName, $categoryId,$quantity ,$price, $description, $imageUrl)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $pdo->prepare(
                "INSERT INTO produkter (produkt_navn, kategori_id,antal , pris, beskrivelse, billede_url)
                VALUES (:produkt_navn, :kategori_id, :antal, :pris, :beskrivelse, :billede_url)"
            );
            $stmnt->execute(['produkt_navn'=>$productName, 'kategori_id'=>$categoryId, 'antal'=>$quantity, 'pris'=>$price, 'beskrivelse'=>$description, 'billede_url'=>$imageUrl]);
            $result = $stmnt->fetch(PDO::FETCH_OBJ); // Hent data som objekter
            return (bool)$result;
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error adding product: " . $e->getMessage());
            return false;
        }
    }

    public static function updateProduct($productId,$edit_product_name, $edit_product_category_id,$edit_product_quantity, $edit_product_price, $edit_product_description, $edit_product_imageUrl)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $pdo->prepare(
                "UPDATE produkter 
                SET produkt_navn = :produkt_navn, kategori_id = :kategori_id, antal = :antal, pris = :pris, beskrivelse = :beskrivelse, billede_url = :billede_url
                WHERE produkt_id = :produkt_id"
            );
            
            $stmnt->execute(['produkt_id'=>$productId, 'produkt_navn'=>$edit_product_name, 'kategori_id'=>$edit_product_category_id, 'antal'=>$edit_product_quantity, 'pris'=>$edit_product_price, 'beskrivelse'=>$edit_product_description, 'billede_url'=>$edit_product_imageUrl]);
            $result = $stmnt->fetch();
    
            return $result;
    
        } catch (PDOException $e) {
            // Log eller håndter fejlen efter behov
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteProduct($productId)
    {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=webshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $pdo->prepare("DELETE FROM produkter WHERE produkt_id = :id");
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