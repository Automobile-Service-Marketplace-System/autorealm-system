<?php

namespace app\models;

use app\core\Database;
use PDO;

class Foreman
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getForemanById(int $foreman_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee e INNER JOIN foreman f on e.employee_id = f.employee_id  WHERE e.employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $foreman_id
        ]);
        return $stmt->fetchObject();
    }

    public function getForemanAvailability():array{
        return $this->pdo->query(
            "SELECT
                concat(f_name, ' ', l_name) as Name,
                is_available as Availability,
                image as Image            
            FROM foreman f
            inner join employee e on e.employee_id =f.employee_id"
            
        )->fetchAll(PDO::FETCH_ASSOC);
    }

}