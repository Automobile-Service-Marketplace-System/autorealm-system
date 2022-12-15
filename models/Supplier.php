<?php

namespace app\models;

use app\core\Database;
use PDO;

class Supplier
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function  getSuppliers() : array {
        $stmt = $this->pdo->query("SELECT * FROM supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}