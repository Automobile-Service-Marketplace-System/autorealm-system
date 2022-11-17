<?php

namespace app\models;
use app\core\Database;

class SecurityOfficer
{
    private \PDO $pdo;
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function login(): array|object
    {
        $errors = [];
        $employee = null;

        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $employee = $statement->fetchObject();
            if (!$employee) {
                $errors['email'] = 'Email does not exist';
            } else {
                if ($this->body['password']!=$employee->password) {
                    $errors['password'] = 'Password is incorrect';
                }
            }
        }
        if (empty($errors)) {
            return $employee;
        }
        return $errors;
    }
}