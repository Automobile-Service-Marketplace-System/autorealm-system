<?php

namespace app\models;

use app\core\Database;
use PDO, Exception;

class InspectionReport
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $createBody)
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $createBody;
    }

    public function createInspectionReport() : int | string {
        $jobId = $this->body['job_id'];
        $statement = $this->pdo->prepare("INSERT INTO maintenance_inspection_report (job_card_id) VALUES (:job_card_id)");
        try {
            $statement->execute([
                ":job_card_id" => $jobId
            ]);
            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
