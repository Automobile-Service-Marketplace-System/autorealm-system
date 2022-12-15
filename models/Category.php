<?php

namespace app\models;

use app\core\Database;
use PDO;

class Category
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function  getCategories() : array {
        $stmt = $this->pdo->query("SELECT * FROM category");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}