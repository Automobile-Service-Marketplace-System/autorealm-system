<?php

namespace app\models;

use app\core\Database;
use DateTime;
use PDO, Exception;

class PersistentSession
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    /**
     * @throws Exception
     */
    public function setCustomerSession(int $customer_id): string
    {
        $query = "INSERT INTO usersession (selector, hashed_validator, customer_id, expiry) VALUES (:selector, :hashed_validator, :customer_id, :expiry)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':customer_id', $customer_id);

        $selector = $customer_id . bin2hex(random_bytes(16));
        $validator = $customer_id . bin2hex(random_bytes(32));
        $hashedValidator = password_hash($validator, PASSWORD_DEFAULT);

        $statement->bindValue(':selector', $selector);
        $statement->bindValue(':hashed_validator', $hashedValidator);
        $statement->bindValue(':customer_id', $customer_id);
        // now + 30 days
        $expireDateTime = new DateTime("@".(time() + 2592000));
        $statement->bindValue(':expiry', $expireDateTime->format('Y-m-d H:i:s'));
        $statement->execute();
        return $selector . ':' . $validator;
    }


    public function checkCustomerSession(string $clientToken): bool|int
    {
        [$selector, $validator] = explode(':', $clientToken);
        $query = "SELECT * FROM usersession WHERE selector = :selector";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':selector', $selector);
        $statement->execute();
        $session = $statement->fetchObject();
        if ($session && $session->customer_id && password_verify($validator, $session->hashed_validator)   && time() < $session->expiry) {
            return $session->customer_id;
        }
        return false;
    }


    public function deleteCustomerSession(int $customer_id): void
    {
        // delete if exists
        $query = "DELETE FROM usersession WHERE customer_id = :customer_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->execute();
    }


    /**
     * @throws Exception
     */
    public function setEmployeeSession(int $employee_id, string $role): string
    {
        $query = "INSERT INTO usersession (selector, hashed_validator, employee_id, expiry, employee_role) VALUES (:selector, :hashed_validator, :employee_id, :expiry, :employee_role)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':employee_id', $employee_id);
        $selector = $employee_id . bin2hex(random_bytes(16));
        $validator = $employee_id . bin2hex(random_bytes(32));
        $hashedValidator = password_hash($validator, PASSWORD_DEFAULT);

        $statement->bindValue(':selector', $selector);
        $statement->bindValue(':hashed_validator', $hashedValidator);
        $statement->bindValue(':employee_id', $employee_id);
        $statement->bindValue(':employee_role', $role);
        // 30 days
        // now + 30 days
        $expireDateTime = new DateTime("@".(time() + 2592000));
        $statement->bindValue(':expiry', $expireDateTime->format('Y-m-d H:i:s'));
        $statement->execute();
        return $selector . ':' . $validator;

    }

    public function checkEmployeeSession(string $clientToken): array|bool
    {
        [$selector, $validator] = explode(':', $clientToken);
        $query = "SELECT * FROM usersession WHERE selector = :selector";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':selector', $selector);
        $statement->execute();
        $session = $statement->fetchObject();
        if ($session && password_verify($validator, $session->hashed_validator) && time() < $session->expiry) {
            $employee_id = $session->employee_id;
            if (!$employee_id) {
                return false;
            }
            return [
                'employee_id' => $employee_id,
                'role' => $session->employee_role
            ];
        }
        return false;
    }


    public function deleteEmployeeSession(int $employee_id): void
    {
        // delete if exists
        $query = "DELETE FROM usersession WHERE employee_id = :employee_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':employee_id', $employee_id);
        $statement->execute();
    }
}