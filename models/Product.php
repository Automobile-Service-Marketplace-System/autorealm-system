<?php

namespace app\models;

use app\core\Database;
use PDO;



use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;


class Product
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
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

        )->fetchAll(PDO::FETCH_ASSOC);

    }

    public function addProducts(): bool|array|string
    {
        //$errors = $this->validateRegisterBody();
        $errors = [];

        if (empty($errors)) {
            $query = "INSERT INTO product 
                    (
                        name, category_id,product_type, brand_id, model_id, description, price, quantity
                    ) 
                 
                    VALUES 
                    (
                        :name, :category_id, :product_type, :brand_id, :model_id, :description, :price, :quantity
                    )";
            //for product table
            $statement = $this->pdo->prepare($query);
            $statement->bindValue("name", $this->body["name"]);
            $statement->bindValue(":category_id", $this->body["category_id"]);
            $statement->bindValue(":product_type", $this->body["product_type"]);
            $statement->bindValue(":brand_id", $this->body["brand_id"]);
            $statement->bindValue(":model_id", $this->body["model_id"]);
            $statement->bindValue(":description", $this->body["description"]);
            $statement->bindValue(":price", $this->body["selling_price"]);
            $statement->bindValue(":quantity", $this->body["quantity"]);
            try {
                $statement->execute();

                $query = "INSERT INTO stockpurchasereport 
                    (
                       item_code, date_time, supplier_id, unit_price, amount
                    ) 
                 
                    VALUES 
                    (
                      :item_code, :date_time, :supplier_id, :unit_price, :amount 
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":item_code", $this->pdo->lastInsertId());
                $statement->bindValue(":date_time", $this->body["date_time"]);
                $statement->bindValue(":supplier_id", $this->body["supplier_id"]);
                $statement->bindValue(":unit_price", $this->body["unit_price"]);
                $statement->bindValue(":amount", $this->body["quantity"]);

                try {
                    $statement->execute();
                    return true;
                } catch (\PDOException $e) {
                    return false;
                }
            } catch (\PDOException $e) {
                return $e->getMessage();
            }


        } else {
            return $errors;
        }


    }
}