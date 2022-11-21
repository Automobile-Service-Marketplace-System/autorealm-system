<?php

namespace app\models;

use app\core\Database;
use PDO;

class Admin
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getAdminById(int $admin_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee e INNER JOIN admin a on e.employee_id = a.employee_id  WHERE e.employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $admin_id
        ]);
        return $stmt->fetchObject();
    }
}