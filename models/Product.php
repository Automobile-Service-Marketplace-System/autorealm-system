<?php

namespace app\models;

use app\core\Database;
use PDO;


class Product
{
    private PDO $pdo;
    private array $body;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;

    }

    public function getProducts(): array
    {

        $result = $this->pdo->query("SELECT * FROM product")-> fetchAll(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";
        return $result;

//        $stmt = $this->pdo->prepare("SELECT * FROM product");
//        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}