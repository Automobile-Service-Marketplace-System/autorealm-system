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

            $statement = $this->pdo->prepare(query: "SELECT job_card_id as id, vin as regNo FROM jobcard  WHERE employee_id = :foremanId");
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

                $query = "SELECT status from jobcard WHERE job_card_id = :jobId";
                $statement = $this->pdo->prepare(query: $query);
                $statement->bindValue(param: ":jobId", value: $job['id']);
                $statement->execute();
                $statusResult = $statement->fetch(mode: PDO::FETCH_ASSOC);

                $jobs[$statusResult["status"]][] = $job;
            }
            return $jobs;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}