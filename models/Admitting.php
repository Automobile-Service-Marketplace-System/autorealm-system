<?php

namespace app\models;

use app\core\Database;
use app\utils\FSUploader;
use app\utils\Util;
use PDO;

class Admitting
{    
    private PDO $pdo;
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    // public function validateAdmittingReport():array{
    //     $errors=[];
    // }

    public function addAdmittingReport(Request $req, Response $res):string{
        // $errors = $this->validateAdmittingReport();
    }
}