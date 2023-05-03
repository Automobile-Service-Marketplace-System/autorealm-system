<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO, Exception;
use PDOException;

class JobCard
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getAllJobsByForemanID(int $foremanId): array|string
    {
        try {

            $statement = $this->pdo->prepare(query: "SELECT job_card_id as id, vin as regNo, status, TIMESTAMPDIFF(MINUTE , start_date_time, end_date_time) as time_collapsed  FROM jobcard  WHERE employee_id = :foremanId");
            $statement->bindValue(param: ":foremanId", value: $foremanId);
            $statement->execute();
            $rawJobs = $statement->fetchAll(mode: PDO::FETCH_ASSOC);


            $jobs = [
                "new" => [],
                "in-progress" => [],
                "completed" => [],
            ];

            foreach ($rawJobs as $rawJob) {
                // make a copy of the raw job array
                $job = $rawJob;
                $query = "SELECT COUNT(job_card_id) FROM jobcardhasproduct jhp WHERE jhp.job_card_id = :jobId";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":jobId", value: $job['id']);
                $statement->execute();
                $productCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
                $job["productCount"] = $productCountResult["COUNT(job_card_id)"];

                $query = "SELECT COUNT(job_card_id) FROM jobcardhasservice jhs WHERE jhs.job_card_id = :jobId";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":jobId", value: $job['id']);
                $statement->execute();
                $serviceCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
                $job["serviceCount"] = $serviceCountResult["COUNT(job_card_id)"];


                $query = "SELECT COUNT(job_card_id) FROM jobcardhastechnician jhs WHERE jhs.job_card_id = :jobId";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":jobId", value: $job['id']);
                $statement->execute();
                $technicianCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
                $job["technicianCount"] = $technicianCountResult["COUNT(job_card_id)"];


                $query = "SELECT SUM(CASE WHEN is_completed = 0 THEN 1 ELSE  0 END) as not_completed_count,SUM(CASE WHEN is_completed = 1 THEN 1 ELSE  0 END) as completed_count FROM jobcardhasservice WHERE job_card_id = :jobId";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":jobId", value: $job['id']);
                $statement->execute();
                $serviceStatusResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
                $all = (int)$serviceStatusResult["not_completed_count"] + (int)$serviceStatusResult["completed_count"];
                $done = (int)$serviceStatusResult["completed_count"];
                $job['done'] = $done;
                $job['all'] = $all;
                $jobs[$job["status"]][] = $job;
            }
            return $jobs;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVehicleDetailsByJobId(int $jobId): string|array
    {
        $query = "SELECT vin FROM jobcard WHERE job_card_id = :job_card_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(param: ":job_card_id", value: $jobId);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $vin = $statement->fetch(mode: PDO::FETCH_ASSOC)['vin'];
            $query = "SELECT 
                            CONCAT(b.brand_name,' ',m.model_name,' ',YEAR(my.year), ' Edition') as vehicle_name, 
                            v.reg_no as reg_no, 
                            CONCAT(c.f_name, ' ', c.l_name) as customer_name
                          FROM vehicle v 
                              LEFT JOIN brand b ON v.brand_id = b.brand_id 
                              LEFT JOIN model m ON v.model_id = m.model_id 
                              INNER JOIN modelyear my on m.model_id = my.model_id 
                              INNER  JOIN customer c on v.customer_id = c.customer_id 
                          WHERE v.vin = :vin";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":vin", value: $vin);
            $statement->execute();
            return $statement->fetch(mode: PDO::FETCH_ASSOC);
        }

        return [
            "error" => "Invalid job id"
        ];
    }

    public function startJob(int $jobId, array $productIds, array $serviceCodes, array $technicianIds): bool|string
    {
        try {
            $this->pdo->beginTransaction();
            foreach ($productIds as $productId) {
                $query = "SELECT quantity FROM product WHERE item_code = :item_code";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":item_code", value: $productId);
                $statement->execute();
                $product = $statement->fetch(mode: PDO::FETCH_ASSOC);
                if (!$product) {
                    throw new Exception(message: "Invalid product id");
                }

                if ($product['quantity'] <= 0) {
                    throw new Exception(message: "Product out of stock");
                }


                $query = "UPDATE product SET quantity = quantity - 1 WHERE item_code = :item_code";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":item_code", value: $productId);
                $statement->execute();

                $query = "INSERT INTO jobcardhasproduct (job_card_id, item_code) VALUES (:job_card_id, :product_id)";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(param: ":job_card_id", value: $jobId);
                $statement->bindValue(param: ":product_id", value: $productId);
                $statement->execute();
            }

            foreach ($serviceCodes as $serviceCode) {
                $query = "INSERT INTO jobcardhasservice (job_card_id, service_code) VALUES (:job_card_id, :service_code)";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(param: ":job_card_id", value: $jobId);
                $statement->bindValue(param: ":service_code", value: $serviceCode);
                $statement->execute();
            }

            foreach ($technicianIds as $technicianId) {
                $query = "INSERT INTO jobcardhastechnician (job_card_id, employee_id) VALUES (:job_card_id, :employee_id)";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(param: ":job_card_id", value: $jobId);
                $statement->bindValue(param: ":employee_id", value: $technicianId);
                $statement->execute();


                $query = "UPDATE technician SET is_available = FALSE WHERE employee_id = :employee_id";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(param: ":employee_id", value: $technicianId);
                $statement->execute();
            }

            $query = "UPDATE jobcard SET status = 'in-progress' WHERE job_card_id = :job_card_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException|Exception $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
    }

    public function getProductsServicesTechniciansInJob(int $jobId): array|string
    {
        try {

            $query = "SELECT p.item_code as ID, p.name as Name, p.image as images FROM jobcardhasproduct INNER  JOIN product p on jobcardhasproduct.item_code = p.item_code WHERE job_card_id = :job_card_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $rawProducts = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $products = [];

            foreach ($rawProducts as $product) {
                $products[] = [
                    "ID" => $product['ID'],
                    "Name" => $product['Name'],
                    "Image" => json_decode($product['images'])[0]
                ];
            }


            $query = "SELECT s.servicecode as Code, s.service_name as Name, jobcardhasservice.is_completed as IsCompleted FROM jobcardhasservice INNER  JOIN service s on jobcardhasservice.service_code = s.servicecode WHERE job_card_id = :job_card_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $services = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $query = "SELECT e.employee_id as ID, CONCAT(e.f_name, ' ', e.l_name) as Name, e.image as Image FROM jobcardhastechnician INNER  JOIN employee e on jobcardhastechnician.employee_id = e.employee_id WHERE job_card_id = :job_card_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $technicians = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $query = "SELECT SUM(CASE WHEN is_completed = 0 THEN 1 ELSE  0 END) as not_completed_count,SUM(CASE WHEN is_completed = 1 THEN 1 ELSE  0 END) as completed_count FROM jobcardhasservice WHERE job_card_id = :jobId";
            $statement = $this->pdo->prepare(query: $query);
            $statement->bindValue(param: ":jobId", value: $jobId);
            $statement->execute();
            $serviceStatusResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
            $all = (int)$serviceStatusResult["not_completed_count"] + (int)$serviceStatusResult["completed_count"];
            $done = (int)$serviceStatusResult["completed_count"];

            return [
                "products" => $products,
                "services" => $services,
                "technicians" => $technicians,
                "service_status" => [
                    "all" => $all,
                    "done" => $done
                ]
            ];

        } catch (PDOException|Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllJobs(int|null $count = null, int|null $page = 1): array
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $jobs =  $this->pdo->query("
            SELECT
                job_card_id as 'JobCard ID',
                concat(c.f_name,' ',c.l_name) as 'Customer Name',
                concat(e.f_name,' ',e.l_name) as 'Employee Name',
                vin as 'VIN',
                start_date_time as 'Start Date Time',
                end_date_time as 'End Date Time',
                status as 'Status',
                mileage as 'Mileage',
                customer_observation as 'Customer Observation'
            FROM 
                jobcard j 
            INNER JOIN 
                customer c ON c.customer_id = j.customer_id
            INNER JOIN 
                employee e ON e.employee_id = j.employee_id
            ORDER BY
                j.job_card_id $limitClause $pageClause"
        )->fetchAll(PDO::FETCH_ASSOC);

        $totalJobs = $this->pdo->query(
            "SELECT COUNT(*) as total FROM jobcard"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            "total" => $totalJobs['total'],
            "jobCards" => $jobs
        ];

    }

    // public function createJobCard(): bool | string
    // {
    //     try {
    //         $query = $this->pdo->prepare("INSERT INTO jobcard 
    //             (
    //                 start_date_time, customer_observation, mileage, vin, customer_id
    //             ) 
    //             VALUES 
    //             (
    //                 :start_date_time, :customer_observation, :mileage, :vin, :customer_id
    //             )"
    //         );

    //     $statement = $this->pdo->prepare($query);
    //     $statement->bindValue(":start_date_time", $this->body["start_date_time"]);
    //     $statement->bindValue(":customer_observation", $this->body["customer_observation"]);
    //     $statement->bindValue(":mileage", $this->body["mileage"]);
    //     $statement->bindValue(":vin", $this->body["vin"]);
    //     $statement->bindValue(":customer_id", $this->body["customer_id"]);
    //     $statement->execute();
    //     return true;
    //     } catch (PDOException $e) {
    //         echo $e->getMessage();
    //     }
    //     return "Internal Server Error";
    // }
}

