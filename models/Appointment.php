<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use Exception;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;

class Appointment{

    private PDO $pdo;
    private array $body;

    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }    

    public function getAppointments():array{
        return $this->pdo->query(
            "SELECT
                vehicle_reg_no as RegNo,
                date_and_time as DateandTime
                
            FROM appointment"
            
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}