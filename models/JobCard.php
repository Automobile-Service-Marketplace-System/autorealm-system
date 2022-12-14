<?php

namespace app\models;

use app\core\Database;
use PDO, Exception;

class JobCard
{
    private \PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getAllJobsByForemanID(int $foremanId) :array | string {
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

    public function  getVehicleDetailsByJobId(int $jobId) : string | array {
        $query = "SELECT vin FROM jobcard WHERE job_card_id = :job_card_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(param: ":job_card_id", value: $jobId);
        $statement->execute();
        if($statement->rowCount() > 0)  {
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
}