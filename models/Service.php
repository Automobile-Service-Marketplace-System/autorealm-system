<?php

namespace app\models;

use app\core\Database;
use PDO;



use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;


class Service
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getServices(): array
    {
        return $this->pdo->query(
            "SELECT 
                        servicecode as ID,
                        service_name as Name,
                        description as Description, 
                        price as Price
                        
                    FROM service"

        )->fetchAll(PDO::FETCH_ASSOC);

    }

}