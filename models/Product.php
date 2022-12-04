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

       // $result = $this->pdo->query("SELECT * FROM product")-> fetchAll(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";

       // return $result;

//        $stmt = $this->pdo->prepare("SELECT * FROM product");
//        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_OBJ);

   // return $this->pdo->query("SELECT * FROM product")-> fetchAll(PDO::FETCH_ASSOC);

        return $this->pdo->query(
            "SELECT 
    
                        p.item_code as ID, 
                        p.name as Name, 
                        c.name as Category,
                        m.model_name as Model,
                        b.brand_name as Brand,
                        ROUND(p.price/100, 2) as 'Price (LKR)', 
                        p.quantity as Quantity

                    FROM product p 
                        
                        INNER JOIN model m on p.model_id = m.model_id 
                        INNER JOIN brand b on p.brand_id = b.brand_id 
                        INNER JOIN category c on p.category_id = c.category_id
            
                    ORDER BY p.item_code"

        )-> fetchAll(PDO::FETCH_ASSOC);

    }
}