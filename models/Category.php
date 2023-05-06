<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;

class Category
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getCategories(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT name, category_id FROM category");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }

    }
}