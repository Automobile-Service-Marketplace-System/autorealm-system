<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;

class Model
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getModels(): array
    {
        try {

            $stmt = $this->pdo->query("SELECT brand_id, model_id, is_product_model, is_vehicle_model, model_name FROM model");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

     public function addModel() : bool|array|string
     {
        $errors = $this->validateModelName();
         $is_vehicle_model = false;
         $is_product_model = false;

        if($this->body['model_type']=="vehicle"){
            $is_vehicle_model = true;

        }
        elseif($this->body['model_type']=="product"){

            $is_product_model = true;
        }


        if(empty($errors)){
            try {
                $stmt = $this->pdo->prepare("INSERT INTO model (model_name, brand_id, is_vehicle_model, is_product_model) 
                    VALUES (:name, :brand_id, :is_vehicle_model, :is_product_model)");

                $stmt->bindValue(":name", $this->body['model_name']);
                $stmt->bindValue(":brand_id", $this->body['brand_id']);
                $stmt->bindValue(":is_vehicle_model", $is_vehicle_model);
                $stmt->bindValue(":is_product_model", $is_product_model);
                $stmt->execute();
                return true;
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }
        return $errors;
     }

    private function validateModelName(): array
    {
        $errors = [];
        if (trim($this->body["model_name"]) === "") {
            $errors['model_name'] = "Model name cannot be empty";
        }
        elseif (preg_match("/^[0-9]+$/", $this->body["model_name"])) {
            $errors['model_name'] = "Model name cannot be only numbers";
        }
        return $errors;
    }
}