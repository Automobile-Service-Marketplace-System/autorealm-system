<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;

class Brand
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getBrands(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT brand_name, brand_id, is_product_brand, is_vehicle_brand FROM brand");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function addBrand() : bool|array|string
    {
        $errors = $this->validataModelName();

        if($this->body['is_product_brand'] == '1' && $this->body['is_vehicle_brand'] == '1'){
        $this->body['is_vehicle_brand']  = true;
            $this->body['is_product_brand']  = true;
        }
        elseif($this->body['is_vehicle_brand'] == '1'){
            $this->body['is_vehicle_brand']  = true;
            $this->body['is_product_brand']  = false;
        }
        elseif($this->body['is_product_brand'] == '1'){
            $this->body['is_product_brand']  = true;
            $this->body['is_vehicle_brand']  = false;
        }


        if(empty($errors)){
            try {
                $stmt = $this->pdo->prepare("INSERT INTO brand (brand_name, is_vehicle_brand, is_product_brand) 
                    VALUES (:name, :is_vehicle_brand, :is_product_brand)");

                $stmt->bindValue(":name", $this->body['brand_name']);
                $stmt->bindValue(":is_vehicle_brand", $this->body['is_vehicle_brand']);
                $stmt->bindValue(":is_product_brand", $this->body['is_product_brand']);
                $stmt->execute();
                return true;
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }
        return $errors;
    }


    public function getBrandsOptList(): array|string
    {
        try {
            $query = "SELECT brand_id, brand_name FROM brand";
            $stmt = $this->pdo->query($query);
            $stmt->execute();

           return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return "Error getting brands list";

        }


    }


}