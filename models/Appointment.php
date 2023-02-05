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
                concat(f_name, ' ', l_name) as Name,
                appointment.vehicle_reg_no as RegNo,
                appointment.date as Date,
                appointment.from_time as FromTime,
                appointment.to_time as ToTime            
            FROM appointment 
            inner join customer on customer.customer_id=appointment.customer_id"
            
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppointments():array{
        return $this->pdo->query(
            "SELECT
                concat(f_name, ' ', l_name) as Name,
                appointment.vehicle_reg_no as RegNo,
                appointment.date as Date,
                appointment.from_time as FromTime,
                appointment.to_time as ToTime            
            FROM appointment 
            inner join customer on customer.customer_id=appointment.customer_id"
            
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
