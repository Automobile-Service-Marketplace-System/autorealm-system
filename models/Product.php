<?php

namespace app\models;

use app\core\Database;
use PDO;;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;



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

    public function addProducts(): bool|array
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (\Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                $query = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email,password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":f_name", $this->body["f_name"]);
                $statement->bindValue(":l_name", $this->body["l_name"]);
                $statement->bindValue(":contact_no", $this->body["contact_no"]);
                $statement->bindValue(":address", $this->body["address"]);
                $statement->bindValue(":email", $this->body["email"]);
                $hash = password_hash($this->body["password"], PASSWORD_DEFAULT);
                $statement->bindValue(":password", $hash);
                $statement->bindValue(":image", $imageUrl ?? "");
                try {
                    $statement->execute();
                    return true;
                } catch (\PDOException $e) {
                    return false;
                }
            } else {
                return $errors;
            }

        } else {
            return $errors;
        }
    }
}