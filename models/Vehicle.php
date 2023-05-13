<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use app\utils\DevOnly;

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

    public function getVehicles(
        int | null $count = null, 
        int | null $page = 1, 
        string $searchTermRegNo = null, 
        string $searchTermCustomer = null,
        string $vehicleType = null
        ): array|string
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $whereClause = null;
        $conditions = null;
        

        if ($vehicleType !== null) {
            switch ($vehicleType) {
                case "all":
                    break;
                case "Bike":
                    $conditions = "vehicle_type = 'Bike'";
                    break;
                case "Car":
                    $conditions = "vehicle_type = 'Car'";
                    break;
                case "Jeep":
                    $conditions = "vehicle_type = 'Jeep'";
                    break;
                case "Van":
                    $conditions = "vehicle_type = 'Van'";
                    break;
                case "Lorry":
                    $conditions = "vehicle_type = 'Lorry'";
                    break;
                case "Bus":
                    $conditions = "vehicle_type = 'Bus'";
                    break;
                case "Other":
                    $conditions = "vehicle_type = 'Other'";
                    break;
            }
        }

        
        if ($searchTermRegNo !== null) {
            $whereClause = $whereClause ? $whereClause . " AND reg_no LIKE :search_term_reg" : "WHERE reg_no LIKE :search_term_reg";
        }

        if ($searchTermCustomer !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(c.f_name,' ',c.l_name) LIKE :search_term_cus" : "WHERE CONCAT(c.f_name,' ',c.l_name) LIKE :search_term_cus";
        }

        if ($conditions !== null) {
            $whereClause = $whereClause ? $whereClause . " AND $conditions " : "WHERE $conditions";
        }

            $statement = $this->pdo->prepare(
                "SELECT
                    vin as VIN,
                    reg_no as 'Registration No',
                    engine_no as 'Engine No',
                    CONCAT(c.f_name, ' ',c.l_name) as 'Customer Name',
                    manufactured_year as 'Manufactured Year',
                    engine_capacity as 'Engine Capacity',
                    vehicle_type as 'Vehicle Type',
                    fuel_type as 'Fuel Type',
                    transmission_type as 'Transmission Type',
                    m.model_name as 'Model Name',
                    m.model_id as 'Model ID',
                    b.brand_id as 'Brand ID',
                    b.brand_name as 'Brand Name',
                    v.customer_id as 'Customer ID'
                FROM
                    vehicle v
                INNER JOIN customer c ON c.customer_id = v.customer_id
                INNER JOIN model m ON m.model_id = v.model_id
                INNER JOIN brand b ON b.brand_id = v.brand_id
                $whereClause
                ORDER BY v.vin $limitClause $pageClause");

        if ($searchTermRegNo !== null) {
            $statement->bindValue(":search_term_reg", "%" . $searchTermRegNo . "%", PDO::PARAM_STR);
        }

        if ($searchTermCustomer !== null) {
            $statement->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
        }

        try{

            $statement->execute();
            $vehicles = $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $totalVehicles = $this->pdo->query(
            "SELECT COUNT(*) as total FROM vehicle"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            "total" => $totalVehicles['total'],
            "vehicles" => $vehicles,
        ];
    }

    public function getVehiclesByID(int $customer_id): array | string
    {
        try {
            $statement = $this->pdo->prepare("SELECT
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
                v.customer_id = :customer_id");
            $statement->bindValue(":customer_id", $customer_id);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$results) {
                return "No vehicle found";
            }

            $resultsWithLastService = [];

            foreach ($results as $result) {

            //    DevOnly::prettyEcho($result);

                $statement = $this->pdo->prepare("SELECT
                    mileage,
                    start_date_time
                FROM jobcard j
                WHERE
                    j.vin = :vin
                ORDER BY
                    j.start_date_time DESC
                LIMIT 1");
                $statement->bindValue(":vin", $result['vin']);
                $statement->execute();
                $lastService = $statement->fetch(PDO::FETCH_ASSOC);
//                DevOnly::prettyEcho($lastService);

                if ($lastService) {
                    $result['last_service_mileage'] = $lastService['mileage'];
                    $result['last_service_date'] = $lastService['start_date_time'];
                } else {
                    $result['last_service_mileage'] = "No service history";
                    $result['last_service_date'] = "N/A";
                }

                $resultsWithLastService[] = $result;
//
//                DevOnly::prettyEcho($result);
            }

//            DevOnly::prettyEcho($resultsWithLastService);

            return $resultsWithLastService;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return "Internal Server Error";

    }

    public function getVehicleNamesByID(int $customer_id): array | string
    {
        try {
            $statement = $this->pdo->prepare("SELECT
                v.reg_no,
                m.model_name,
                b.brand_name
            FROM vehicle v
                INNER JOIN model m ON m.model_id = v.model_id
                INNER JOIN brand b ON b.brand_id = v.brand_id
            WHERE
                v.customer_id = :customer_id");
            $statement->bindValue(":customer_id", $customer_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return "Internal Server Error";

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
            $errors['vin'] = 'VIN must not be empty.';
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
            $errors['engine_no'] = 'Engine No must not be empty.';
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
            $errors['reg_no'] = 'Registration No must not be empty.';
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

    private function validateUpdateVehicleBody(): array
    {
        $errors = [];

        if (strlen($this->body['vin']) == 0) {
            $errors['vin'] = 'VIN must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE vin = :vin AND vin != :old_vin";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":vin", $this->body["vin"]);
            $statement->bindValue(":old_vin", $this->body["old_vin"]);
            $statement->execute();

            $vehicle = $statement->fetch();
            if ($vehicle) {
                $errors['vin'] = 'VIN already in use.';
            }
        }

        if (strlen($this->body['engine_no']) == 0) {
            $errors['engine_no'] = 'Engine No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE engine_no = :engine_no AND engine_no != :old_engine_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":engine_no", $this->body["engine_no"]);
            $statement->bindValue(":old_engine_no", $this->body["old_engine_no"]);

            $statement->execute();
            $vehicle = $statement->fetch();

            if ($vehicle) {
                $errors['engine_no'] = 'Engine No already in use.';
            }
        }

        if (strlen($this->body['reg_no']) == 0) {
            $errors['reg_no'] = 'Registration No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE reg_no = :reg_no AND reg_no != :old_reg_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":reg_no", $this->body["reg_no"]);
            $statement->bindValue(":old_reg_no", $this->body["old_reg_no"]);

            $statement->execute();
            $vehicle = $statement->fetch();

            if ($vehicle) {
                $errors['reg_no'] = 'Registration No already in use.';
            }
        }

        return $errors;
    }

    public function updateVehicle()
    {
        $errors = $this->validateUpdateVehicleBody();
        if (empty($errors)) {

            try {
                $query = "UPDATE vehicle SET
                vin = :vin,
                reg_no = :reg_no,
                engine_no = :engine_no,
                manufactured_year = :manufactured_year,
                engine_capacity = :engine_capacity,
                vehicle_type = :vehicle_type,
                fuel_type = :fuel_type,
                transmission_type = :transmission_type,
                model_id = :model_id,
                brand_id = :brand_id,
                customer_id = :customer_id
                WHERE vin= :old_vin";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":vin", $this->body["vin"]);
                $statement->bindValue(":reg_no", $this->body["reg_no"]);
                $statement->bindValue(":engine_no", $this->body["engine_no"]);
                $statement->bindValue(":manufactured_year", $this->body["manufactured_year"]);
                $statement->bindValue(":engine_capacity", $this->body["engine_capacity"]);
                $statement->bindValue(":vehicle_type", $this->body["vehicle_type"]);
                $statement->bindValue(":fuel_type", $this->body["fuel_type"]);
                $statement->bindValue(":transmission_type", $this->body["transmission_type"]);
                $statement->bindValue(":model_id", $this->body["model_id"]);
                $statement->bindValue(":brand_id", $this->body["brand_id"]);
                $statement->bindValue(":customer_id", $this->body["customer_id"]);
                $statement->bindValue(":old_vin", $this->body["old_vin"]);
                $statement->execute();
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }

        } else {
            return $errors;
        }
    }

}
