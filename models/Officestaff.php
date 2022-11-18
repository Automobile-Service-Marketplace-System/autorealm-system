<?php

namespace app\models;

use app\core\Database;

class OfficeStaff
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function getOfficeStaffById(int $employee_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee WHERE employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $employee_id
        ]);
        return $stmt->fetchObject();
    }

    public function login(): array|object
    {
        $errors = [];
        $officeStaff = null;

        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $officeStaff = $statement->fetchObject();
            if (!$officeStaff) {
                $errors['email'] = 'Email does not exist';
            } else {
                if ($this->body['password'] != $officeStaff->password) {
                    $errors['password'] = 'Password is incorrect';
                }
            }
        }
        if (empty($errors)) {
            return $officeStaff;
        }
        return $errors;
    }


}