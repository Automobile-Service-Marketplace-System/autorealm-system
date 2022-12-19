<?php

namespace app\models;

use app\core\Database;
use PDO;

class Vehicle
{
    private PDO $pdo;
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
                reg_no as 'Registration No',
                engine_no as 'Engine No',
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

    // public function getVehicleByID(): array
    // {

    //     return $this->pdo->query(
    //         "SELECT
    //             vin as VIN,
    //             reg_no as 'Registration no',
    //             engine_no as 'Engine No',
    //             manufactured_year as 'Manufactured Year',
    //             engine_capacity as 'Engine Capacity',
    //             vehicle_type as 'Vehicle Type',
    //             fuel_type as 'Fuel Type',
    //             transmission_type as 'Transmission Type',
    //             m.model_name as 'Model Name',
    //             b.brand_name as 'Brand Name',
    //             customer_id as 'Customer ID'
    //         FROM vehicle v 
    //             INNER JOIN model m ON m.model_id = v.model_id
    //             INNER JOIN brand b ON b.brand_id = v.brand_id"
    //     )->fetchAll(PDO::FETCH_ASSOC);

    // }

    public function getVehicleByID(int $customer_id): array
    {

        return $this->pdo->query(
            "SELECT
                vin,
                reg_no,
                engine_no,
                manufactured_year,
                engine_capacity,
                vehicle_type,
                fuel_type,
                transmission_type,
                m.model_name,
                b.brand_name,
                CONCAT(c.f_name, ' ', c.l_name) as full_name
            FROM vehicle v 
                INNER JOIN model m ON m.model_id = v.model_id
                INNER JOIN brand b ON b.brand_id = v.brand_id
                INNER JOIN customer c ON c.customer_id = v.customer_id
            WHERE
                v.customer_id = $customer_id"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

}
