<?php

namespace app\core;

class Database
{
    private static Database $instance;
    public \PDO $pdo;

    private final function __construct()
    {
        $dsn = $_ENV['DB_DSN'] ?? '';
        $user = $_ENV['DB_USER'] ?? '';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $this->pdo = new \PDO(dsn: $dsn, username: $user, password: $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }


    public static function getInstance(): Database
    {
        if(!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

}
