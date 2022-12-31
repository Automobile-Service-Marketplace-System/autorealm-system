<?php

namespace app\models;

use app\core\Database;
use app\utils\FSUploader;

class Admin
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getAdminById(int $admin_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee e INNER JOIN admin a on e.employee_id = a.employee_id  WHERE e.employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $admin_id
        ]);
        return $stmt->fetchObject();
    }
    
    public function login(): array |object
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
                if (!password_verify($this->body['password'], $employee->password)) {
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