<?php
namespace  app\models;

use app\core\Database;
use PDO;

class Model
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function  getModels() : array {
        $stmt = $this->pdo->query("SELECT * FROM model");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}