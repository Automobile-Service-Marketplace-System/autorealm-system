<?php

namespace app\models;

use app\core\Database;
use Exception;
use PDO;
use PDOException;

class Holiday
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getHolidays(): bool|array|string
    {
        try {
            // get holidays from database where date is between the start of current month and end of next month
            $statement = $this->pdo->prepare(
                "SELECT 
                    id,
                    date
                FROM 
                    holiday
                WHERE 
                    date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND DATE_FORMAT(NOW() + INTERVAL 2 MONTH, '%Y-%m-31')"
            );
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException | Exception $e) {
            return $e->getMessage();
        }
    }
}