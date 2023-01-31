<?php

namespace app\models;

use app\core\Database;
use PDO;

class Appointment
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

    public function getOwnerInfo(int $vin): array
    {

        return $this->pdo->query(
            "SELECT
                CONCAT(c.f_name, ' ', c.l_name) as full_name,
                c.contact_no,
                c.email,
                v.reg_no,
                v.engine_no,
                m.model_name,
                b.brand_name
            FROM vehicle v 
                RIGHT JOIN model m ON m.model_id = v.model_id
                RIGHT JOIN brand b ON b.brand_id = v.brand_id
                RIGHT JOIN customer c ON c.customer_id = v.customer_id
            WHERE
                v.vin = $vin"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppointments(): array
    {

        return $this->pdo->query(
            "SELECT
                appointment_id as 'Appointment ID',
                vehicle_reg_no as 'Vehicle Reg No',
                CONCAT(c.f_name, ' ', c.l_name) as 'Customer Name',                milage as 'Milage',
                remarks as 'Remarks',
                service_type as 'Service Type',
                date_and_time as 'Date & Time',
                time_id as 'Time ID'
            FROM 
                appointment a
            INNER JOIN customer c ON c.customer_id = a.customer_id"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

}
