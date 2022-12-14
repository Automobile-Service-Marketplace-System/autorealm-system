<?php

namespace app\models;

use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;
use PDO;

class Vehicle
{
    private \PDO $pdo;
    // PDO is a database access layer that provides a fast and
    // consistent interface for accessing and managing databases in PHP applications
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function getVehicles(): array 
    {

        return $this->pdo->query("
            SELECT 
                vin as VIN,
                reg_no as 'Registration no',
                manufactured_year as 'Manufactured Year',
                engine_capacity as 'Engine Capacity',
                vehicle_type as 'Vehicle Type',
                fuel_type as 'Fuel Type',
                transmission_type as 'Transmission Type',
                m.model_name as 'Model Name',
                b.brand_name as 'Brand Name',
                customer_id as 'Customer ID'
            FROM vehicle v INNER JOIN model m ON m.model_id = v.model_id
            INNER JOIN brand b ON b.brand_id = v.brand_id"
            )->fetchAll(PDO::FETCH_ASSOC);

    }


}