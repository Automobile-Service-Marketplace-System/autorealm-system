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

    public function addVehicle(int $customer_id) 
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            $query = "INSERT INTO vehicle 
                (
                    vin, reg_no, engine_no, manufactured_year, engine_capacity, vehicle_type, fuel_type, transmission_type, customer_id, model_id, brand_id
                ) 
                VALUES 
                (
                    :vin, :reg_no, :engine_no, :manufactured_year, :engine_capacity, :vehicle_type, :fuel_type, :transmission_type, :customer_id, :model, :brand
                )";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":vin", $this->body["vin"]);
            $statement->bindValue(":reg_no", $this->body["reg_no"]);
            $statement->bindValue(":engine_no", $this->body["engine_no"]);
            $statement->bindValue(":manufactured_year", $this->body["manufactured_year"]);
            $statement->bindValue(":engine_capacity", $this->body["engine_capacity"]);
            $statement->bindValue(":vehicle_type", $this->body["vehicle_type"]);
            $statement->bindValue(":fuel_type", $this->body["fuel_type"]);
            $statement->bindValue(":transmission_type", $this->body["transmission_type"]);
            $statement->bindValue(":customer_id", $customer_id);
            $statement->bindValue(":model", $this->body["model"]);
            $statement->bindValue(":brand", $this->body["brand"]);
            try {
                $statement->execute();
                return true;
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return $errors;
        }
    }

    private function validateRegisterBody(): array
    {
        $errors = [];

        if (strlen($this->body['vin']) == 0) {
            $errors['contact_no'] = 'VIN must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE vin = :vin";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":vin", $this->body["vin"]);
            //contact_no replace with the contact_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['vin'] = 'VIN already in use.';
            }
        }

        if (strlen($this->body['engine_no']) == 0) {
            $errors['contact_no'] = 'Engine No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE engine_no = :engine_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":engine_no", $this->body["engine_no"]);
            //engine_no replace with the engine_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['engine_no'] = 'Engine No already in use.';
            }
        }

        if (strlen($this->body['reg_no']) == 0) {
            $errors['contact_no'] = 'Registration No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE reg_no = :reg_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":reg_no", $this->body["reg_no"]);
            //engine_no replace with the engine_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['reg_no'] = 'Registration No already in use.';
            }
        }

        return $errors;
    }

}
