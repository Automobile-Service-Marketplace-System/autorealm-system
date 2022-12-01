<?php

namespace app\models;

use app\core\Database;
use PDO;

class Admin
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


}