<?php

namespace app\models;

use app\core\Database;
use PDO;

class JobCard
{
    private \PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getAllJobs() :array {
        $statement = $this->pdo->query("SELECT * FROM jobcard");
        $rawJobs = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}