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

    public function addBrand(): bool|array|string
    {
        $errors = $this->validateBrandName();
        $isProductBrand = isset($this->body['is_product_brand']) && $this->body['is_product_brand'] === "1" ? 1 : 0;
        $isVehicleBrand = isset($this->body['is_vehicle_brand']) && $this->body['is_vehicle_brand'] === "1" ? 1 : 0;

        if (!$isProductBrand && !$isVehicleBrand) {
            $errors['is_product_brand'] = "Please select at least one option";
            $errors['is_vehicle_brand'] = "Please select at least one option";
            return $errors;
        }

        if (empty($errors)) {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO brand (brand_name, is_vehicle_brand, is_product_brand) 
                    VALUES (:name, :is_vehicle_brand, :is_product_brand)");

                $stmt->bindValue(":name", $this->body['brand_name']);
                $stmt->bindValue(":is_vehicle_brand", $isVehicleBrand);
                $stmt->bindValue(":is_product_brand", $isProductBrand);
                $stmt->execute();

                return true;
            } catch (PDOException $e) {
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
    private function validateBrandName(): array
    {
        $errors = [];
        if (trim($this->body["brand_name"]) === "") {
            $errors['brand_name'] = "Brand name cannot be empty";
        } elseif (preg_match("/^[0-9]+$/", $this->body["brand_name"])) {
            $errors['brand_name'] = "Brand name cannot be only numbers";
        } else {
            $stmt = $this->pdo->prepare("SELECT brand_name FROM brand WHERE brand_name = :brand_name");
            $stmt->bindValue(":brand_name", $this->body['brand_name']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $errors['brand_name'] = "Brand name already exists";
            }
        }
        return $errors;
    }


}