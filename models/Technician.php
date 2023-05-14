<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;

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

    public function getCurrentlyAvailableTechnicians(): array | string
    {
        try {

            $stmt = $this->pdo->prepare("SELECT CONCAT(e.f_name, ' ', e.l_name) as Name, e.employee_id as ID, e.image as Image, t.is_available as IsAvailable FROM employee e INNER JOIN technician t on e.employee_id = t.employee_id  WHERE e.is_active = 1");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}