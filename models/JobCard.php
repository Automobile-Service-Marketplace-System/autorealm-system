<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use DateTime;
use PDO, Exception;
use PDOException;

class JobCard
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $body=[])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }


    public function getAllJobsByForemanID(int $foremanId): array|string
    {
        try {

            ////             trying to test db latency
//            $currentTime = date("Y-m-d H:i:s");
//
//            $statement = $this->pdo->prepare(query: "SELECT job_card_id as id, vin as regNo, status, TIMESTAMPDIFF(MINUTE , start_date_time, end_date_time) as time_collapsed  FROM jobcard  WHERE employee_id = :foremanId");
//            $statement->bindValue(param: ":foremanId", value: $foremanId);
//            $statement->execute();
//            $rawJobs = $statement->fetchAll(mode: PDO::FETCH_ASSOC);
//
//
//            $jobs = [
//                "new" => [],
//                "in-progress" => [],
//                "completed" => [],
//            ];
//
//            foreach ($rawJobs as $rawJob) {
//                // make a copy of the raw job array
//                $job = $rawJob;
//                $query = "SELECT COUNT(job_card_id) FROM jobcardhasproduct jhp WHERE jhp.job_card_id = :jobId";
//                $statement = $this->pdo->prepare(query: $query);
//                $statement->bindValue(param: ":jobId", value: $job['id']);
//                $statement->execute();
//                $productCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
//                $job["productCount"] = $productCountResult["COUNT(job_card_id)"];
//
//                $query = "SELECT COUNT(job_card_id) FROM jobcardhasservice jhs WHERE jhs.job_card_id = :jobId";
//                $statement = $this->pdo->prepare(query: $query);
//                $statement->bindValue(param: ":jobId", value: $job['id']);
//                $statement->execute();
//                $serviceCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
//                $job["serviceCount"] = $serviceCountResult["COUNT(job_card_id)"];
//
//
//                $query = "SELECT COUNT(job_card_id) FROM jobcardhastechnician jhs WHERE jhs.job_card_id = :jobId";
//                $statement = $this->pdo->prepare(query: $query);
//                $statement->bindValue(param: ":jobId", value: $job['id']);
//                $statement->execute();
//                $technicianCountResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
//                $job["technicianCount"] = $technicianCountResult["COUNT(job_card_id)"];
//
//
//                $query = "SELECT SUM(CASE WHEN is_completed = 0 THEN 1 ELSE  0 END) as not_completed_count,SUM(CASE WHEN is_completed = 1 THEN 1 ELSE  0 END) as completed_count FROM jobcardhasservice WHERE job_card_id = :jobId";
//                $statement = $this->pdo->prepare(query: $query);
//                $statement->bindValue(param: ":jobId", value: $job['id']);
//                $statement->execute();
//                $serviceStatusResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
//                $all = (int)$serviceStatusResult["not_completed_count"] + (int)$serviceStatusResult["completed_count"];
//                $done = (int)$serviceStatusResult["completed_count"];
//                $job['done'] = $done;
//                $job['all'] = $all;
//                $jobs[$job["status"]][] = $job;
//            }
//            $now = date("Y-m-d H:i:s");
//            // get difference in seconds
//            $diff = strtotime($now) - strtotime($currentTime);
//            // get difference in milliseconds
//            $diff = $diff * 1000;
//            var_dump("Time taken to fetch jobs: " . $diff . "ms");
////            exit();
//            return $jobs;

            $query = "SELECT
              jc.job_card_id as id,
              jc.vin as regNo,
              jc.status,
              TIMESTAMPDIFF(MINUTE, jc.start_date_time, jc.end_date_time) as time_collapsed,
              COUNT(DISTINCT jhp.item_code) as productCount,
              COUNT(DISTINCT jhs.service_code) as serviceCount,
              COUNT(DISTINCT jht.employee_id) as technicianCount,
              SUM(CASE WHEN jhs.is_completed = 0 THEN 1 ELSE 0 END) as not_completed_count,
              SUM(CASE WHEN jhs.is_completed = 1 THEN 1 ELSE 0 END) as completed_count
          FROM
              jobcard jc
              LEFT JOIN jobcardhasproduct jhp ON jhp.job_card_id = jc.job_card_id
              LEFT JOIN jobcardhasservice jhs ON jhs.job_card_id = jc.job_card_id
              LEFT JOIN jobcardhastechnician jht ON jht.job_card_id = jc.job_card_id
          WHERE
              jc.employee_id = :foremanId
          GROUP BY
              jc.job_card_id";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":foremanId", $foremanId);
            $statement->execute();
            $rawJobs = $statement->fetchAll(PDO::FETCH_ASSOC);

            $jobs = [
                "new" => [],
                "in-progress" => [],
                "completed" => [],
            ];

            foreach ($rawJobs as $rawJob) {
                $job = $rawJob;
                $job['productCount'] = intval($job['productCount']);
                $job['serviceCount'] = intval($job['serviceCount']);
                $job['technicianCount'] = intval($job['technicianCount']);
                $all = intval($job['not_completed_count']) + intval($job['completed_count']);
                $job['done'] = intval($job['completed_count']);
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


            $query = "SELECT s.servicecode as Code, s.service_name as Name, jobcardhasservice.is_completed as IsCompleted FROM jobcardhasservice INNER  JOIN service s on jobcardhasservice.service_code = s.servicecode WHERE job_card_id = :job_card_id ORDER BY jobcardhasservice.created_at, jobcardhasservice.is_completed DESC";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $services = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $all = count($services);
            $completed = 0;
            foreach ($services as $service) {
                if ($service['IsCompleted'] == 1) {
                    $completed++;
                }
            }

            $query = "SELECT e.employee_id as ID, CONCAT(e.f_name, ' ', e.l_name) as Name, e.image as Image, e.contact_no as PhoneNo FROM jobcardhastechnician INNER  JOIN employee e on jobcardhastechnician.employee_id = e.employee_id WHERE job_card_id = :job_card_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $technicians = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            //            $query = "SELECT SUM(CASE WHEN is_completed = 0 THEN 1 ELSE  0 END) as not_completed_count,SUM(CASE WHEN is_completed = 1 THEN 1 ELSE  0 END) as completed_count FROM jobcardhasservice WHERE job_card_id = :jobId";
//            $statement = $this->pdo->prepare(query: $query);
//            $statement->bindValue(param: ":jobId", value: $jobId);
//            $statement->execute();
//            $serviceStatusResult = $statement->fetch(mode: PDO::FETCH_ASSOC);
//            $all = (int)$serviceStatusResult["not_completed_count"] + (int)$serviceStatusResult["completed_count"];
//            $done = (int)$serviceStatusResult["completed_count"];

            return [
                "products" => $products,
                "services" => $services,
                "technicians" => $technicians,
                "service_status" => [
                    "all" => $all,
                    "done" => $completed
                ]
            ];

        } catch (PDOException|Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAssignedJobServiceAndVehicleDetails(int $jobId): array|string
    {
        try {
            $query = "SELECT s.servicecode as Code, s.service_name as Name, jobcardhasservice.is_completed as IsCompleted FROM jobcardhasservice INNER  JOIN service s on jobcardhasservice.service_code = s.servicecode WHERE job_card_id = :job_card_id ORDER BY jobcardhasservice.created_at, jobcardhasservice.is_completed DESC";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(param: ":job_card_id", value: $jobId);
            $statement->execute();
            $services = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $all = count($services);
            $done = 0;
            foreach ($services as $service) {
                if ($service["IsCompleted"] == 1) {
                    $done++;
                }
            }
            return [
                "services" => $services,
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
        $jobs = $this->pdo->query(
            "SELECT
                job_card_id as 'JobCard ID',
                concat(c.f_name,' ',c.l_name) as 'Customer Name',
                concat(e.f_name,' ',e.l_name) as 'Employee Name',
                vehicle_reg_no as 'Vehicle Reg No',
                start_date_time as 'Start Date Time',
                end_date_time as 'End Date Time',
                status as 'Status'
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

    public function getAllJobsForForemanTechnicianAndAdmin(
        int|null $count = null,
        int|null $page = 1,
        string   $searchTermCustomer = null,
        string   $searchTermVehicleRegNo = null,
        string   $searchTermForemanName = null,
        array    $options = [
            'job_date' => null,
        ]
    ): bool|array|string
    {

        $whereClause = null;
        $conditions = [];

        foreach ($options as $option_key => $option_value) {
            if ($option_value !== null) {
                switch ($option_key) {
                    case "job_date":
                        if ($option_value !== "") {
                            $conditions[] = "DATE(j.start_date_time) = DATE(:job_date)";
                        }
                        break;
                }
            }
        }


        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }


        if ($searchTermCustomer !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(c.f_name,' ',c.l_name) LIKE :search_term_customer_name" : "WHERE c.f_name LIKE :search_term_customer_name";
        }

        if ($searchTermVehicleRegNo !== null) {
            $whereClause = $whereClause ? $whereClause . " AND v.reg_no LIKE :search_term_vehicle_reg_no" : "WHERE v.reg_no LIKE :search_term_vehicle_reg_no";
        }

        if ($searchTermForemanName !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(e.f_name,' ',e.l_name) LIKE :search_term_foreman_name" : "WHERE CONCAT(e.f_name,' ',e.l_name) LIKE :search_term_foreman_name";
        }

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";


        try {
            $statement = $this->pdo->prepare(
                "SELECT 
                        j.job_card_id, v.reg_no, 
                        CONCAT(b.brand_name, ' ', m.model_name) as vehicle_name,
                        j.start_date_time, 
                        j.end_date_time,
                        TIMEDIFF(j.end_date_time, j.start_date_time) as duration,
                        CONCAT(LEFT(e.f_name, 1), '. ', e.l_name) as employee_name, 
                        CONCAT(LEFT(c.f_name, 1), '. ', c.l_name) as customer_name 
                        FROM jobcard j 
                            INNER JOIN employee e on j.employee_id = e.employee_id 
                            INNER JOIN vehicle v on j.vin = v.vin 
                            INNER JOIN brand b on v.brand_id = b.brand_id 
                            INNER JOIN model m on v.model_id = m.model_id  
                            INNER JOIN customer c on j.customer_id = c.customer_id $whereClause $limitClause $pageClause");

            if ($options['job_date'] !== null && $options['job_date'] !== "" ) {
                $statement->bindValue(param: ":job_date", value: $options['job_date']);
            }

            if ($searchTermCustomer !== null) {
                $statement->bindValue(param: ":search_term_customer_name", value: "%" . $searchTermCustomer . "%");
            }

            if ($searchTermForemanName !== null) {
                $statement->bindValue(param: ":search_term_foreman_name", value: "%" . $searchTermForemanName . "%");
            }

            if ($searchTermVehicleRegNo !== null) {
                $statement->bindValue(param: ":search_term_vehicle_reg_no", value: "%" . $searchTermVehicleRegNo . "%");
            }

            $statement->execute();
            $rawJobs = $statement->fetchAll(PDO::FETCH_ASSOC);
            $jobs = [];

            foreach ($rawJobs as $rawJob) {
                $durationSegments = explode(":", $rawJob["duration"]);
                $hours = $durationSegments[0];
                $minutes = $durationSegments[1];
                $jobs[] = [
                    ...$rawJob,
                    'duration' => "{$hours}hr $minutes minutes",
                    'start_date_time' => (new DateTime($rawJob['start_date_time']))->format(format: "Y/m/d"),
                ];
            }

            // get total results
            $statement = $this->pdo->prepare(
                "SELECT 
                        COUNT(*) as total
                        FROM jobcard j 
                            INNER JOIN employee e on j.employee_id = e.employee_id 
                            INNER JOIN vehicle v on j.vin = v.vin 
                            INNER JOIN brand b on v.brand_id = b.brand_id 
                            INNER JOIN model m on v.model_id = m.model_id  
                            INNER JOIN customer c on j.customer_id = c.customer_id $whereClause $limitClause $pageClause");

            DevOnly::prettyEcho("SELECT 
                        COUNT(*) as total
                        FROM jobcard j 
                            INNER JOIN employee e on j.employee_id = e.employee_id 
                            INNER JOIN vehicle v on j.vin = v.vin 
                            INNER JOIN brand b on v.brand_id = b.brand_id 
                            INNER JOIN model m on v.model_id = m.model_id  
                            INNER JOIN customer c on j.customer_id = c.customer_id $whereClause $limitClause $pageClause");

            exit();
            if ($options['job_date'] !== null && $options['job_date'] !== "") {
                $statement->bindValue(param: ":job_date", value: $options['job_date']);
            }

            if ($searchTermCustomer !== null) {
                $statement->bindValue(param: ":search_term_customer_name", value: "%" . $searchTermCustomer . "%");
            }

            if ($searchTermForemanName !== null) {
                $statement->bindValue(param: ":search_term_foreman_name", value: "%" . $searchTermForemanName . "%");
            }

            if ($searchTermVehicleRegNo !== null) {
                $statement->bindValue(param: ":search_term_vehicle_reg_no", value: "%" . $searchTermVehicleRegNo . "%");
            }


            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $total = $result['total'];


            return [
                'jobs' => $jobs,
                'total' => $total
            ];
        } catch (PDOException|Exception $e) {
            DevOnly::prettyEcho($e->getMessage());
            return $e->getMessage();
        }
    }

    public function officeCreateJobCard(): bool|string
    {
        try {
            $query = "INSERT INTO 
                            jobcard(
                                vehicle_reg_no,
                                mileage,
                                customer_id,
                                employee_id)
                    VALUES(
                                :vehicle_reg_no,
                                :mileage,
                                :customer_id,
                                :employee_id)
                            ";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":vehicle_reg_no", $this->body["vehicle_reg_no"]);
            $statement->bindValue(":mileage", $this->body["mileage"]);
            $statement->bindValue(":customer_id", $this->body["customer_id"]);
            $statement->bindValue(":employee_id", $this->body["foreman_id"]);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return $e->getMessage();
        }
    }

    public function isInProgress(int $jobId): bool
    {
        try {
            $statement = $this->pdo->prepare("SELECT status FROM jobcard WHERE job_card_id = :job_card_id");
            $statement->bindValue(":job_card_id", $jobId);
            $statement->execute();
            $jobStatus = $statement->fetch(PDO::FETCH_ASSOC);
            return $jobStatus["status"] === "in-progress";
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getJobIdByTechnicianId(int $technicianId)
    {
        try {
            $statement = $this->pdo->prepare("SELECT j.job_card_id FROM jobcardhastechnician jcht INNER JOIN jobcard j on jcht.job_card_id = j.job_card_id WHERE jcht.employee_id = :employee_id AND j.status != 'finished' ORDER BY j.start_date_time DESC LIMIT 1");
            $statement->bindValue(":employee_id", $technicianId);
            $statement->execute();
            $jobCard = $statement->fetch(PDO::FETCH_ASSOC);
            return $jobCard["job_card_id"] ?? null;
        } catch (PDOException|Exception $e) {
            return $e->getMessage();
        }
    }

    public function changeJobServiceStatus(int $jobId, int $serviceCode, bool $status, int $technicianId): array|string
    {
        try {
            if ($status) {
                $statement = $this->pdo->prepare("UPDATE jobcardhasservice jhs INNER  JOIN jobcardhastechnician jht on jhs.job_card_id = jht.job_card_id SET jhs.is_completed = TRUE  WHERE jhs.job_card_id = :job_card_id AND jhs.service_code = :service_code AND jht.employee_id = :employee_id");
            } else {
                $statement = $this->pdo->prepare("UPDATE jobcardhasservice jhs INNER JOIN jobcardhastechnician jht on jhs.job_card_id = jht.job_card_id SET jhs.is_completed = FALSE WHERE jhs.job_card_id = :job_card_id AND jhs.service_code = :service_code AND jht.employee_id = :employee_id");
            }
            $statement->bindValue(":job_card_id", $jobId);
            $statement->bindValue(":service_code", $serviceCode);
            $statement->bindValue(":employee_id", $technicianId);
            $statement->execute();

            $statement = $this->pdo->prepare("SELECT is_completed as total FROM jobcardhasservice WHERE job_card_id = :job_card_id");
            $statement->bindValue(":job_card_id", $jobId);
            $statement->execute();
            $services = $statement->fetchAll(PDO::FETCH_ASSOC);

            $all = count($services);
            $done = 0;
            foreach ($services as $service) {
                if ($service["total"] == 1) {
                    $done++;
                }
            }


            return [
                "inProgress" => $all - $done,
                "completed" => $done
            ];
        } catch (PDOException|Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTotalOngoingJobs(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM jobcard where status != 'finished'");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getWeeklyJobStatus(): array
    {
        $stmt = $this->pdo->prepare("SELECT status, COUNT(*) AS count 
            FROM jobcard 
            WHERE start_date_time >= DATE_SUB(NOW(), INTERVAL 1 WEEK) 
            GROUP BY status;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}