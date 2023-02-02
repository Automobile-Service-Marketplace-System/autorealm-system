<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use Exception;

use app\core\Request;
use app\core\Response;

class Order
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $body=[])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getOrders(): array{

    }
}