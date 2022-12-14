<?php
namespace  app\models;

use app\core\Database;
use PDO;

class Brand
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function  getBrands() : array {
        $stmt = $this->pdo->query("SELECT * FROM brand");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}