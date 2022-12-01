<?php

namespace app\models;

use app\core\Database;
use PDO;

class Technician
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getTechnicianById(int $technician_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee e INNER JOIN technician t on e.employee_id = t.employee_id  WHERE e.employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $technician_id
        ]);
        return $stmt->fetchObject();
    }

}