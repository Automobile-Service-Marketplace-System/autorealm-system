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
            $stmt = $this->pdo->query("SELECT brand_name, brand_id, brand_type, is_product_brand, is_vehicle_brand FROM brand");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

}