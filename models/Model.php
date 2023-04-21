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

}