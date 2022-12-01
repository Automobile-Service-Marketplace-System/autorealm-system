<?php

namespace app\core;


use PDO;

class Database
{
    private static Database $instance;
    public PDO $pdo;

    final private function __construct()
    {
        $dsn = $_ENV['DB_DSN'] ?? '';
        $user = $_ENV['DB_USER'] ?? '';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $this->pdo = new PDO(dsn: $dsn, username: $user, password: $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }


    public static function getInstance(): Database
    {
        if(!isset(self::$instance)) {
            //checks whether a variable is set, which means that it has to be declared and is not NULL.
            //This function returns true if the variable exists and is not NULL, otherwise it returns false.
            self::$instance = new Database();
        }
        return self::$instance;
    }

}
