<?php
namespace tec\npg\Controllers;

// use tec\npg\PDO;
include 'db_config.php';


class UserController
{

    public static function getUser($id)
    {
        $stmnt = PDO::getInstance()->prepare("SELECT * FROM kunder where kunde_id = ?;");
        $stmnt->execute([$id]);
        $result = $stmnt->fetchObject();

        return $result;
    }
    public static function checkUserLogin()
    {
        $stmnt = PDO::getInstance()->prepare("SELECT * FROM kunder where email = ? && adgangskode = ?;");
        $stmnt->execute([]);
        $result = $stmnt->fetchObject();

        return $result;
    }

    public static function getAllUsers() : array
    {
        $stmnt = PDO::getInstance()->prepare("SELECT * FROM kunder;");
        $stmnt->execute([]);
        $result = $stmnt->fetchAll();

        return $result;
    }
    

}