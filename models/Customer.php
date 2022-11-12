<?php

namespace app\models;

use app\core\Database;

class Customer
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function register(): bool|array
    {
        $errors = $this->validateRegisterBody();
        if (empty($errors)) {
            $query = "INSERT INTO customer (NIC, f_name, l_name, contact_no, address, email, password) 
                  VALUES (:NIC, :f_name, :l_name, :contact_no, :address, :email, :password)";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":NIC", $this->body["nic"]);
            $statement->bindValue(":f_name", $this->body["f_name"]);
            $statement->bindValue(":l_name", $this->body["l_name"]);
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            $statement->bindValue(":address", $this->body["address"]);
            $statement->bindValue(":email", $this->body["email"]);
            $statement->bindValue(":password", $this->body["password"]);
            try {
                $statement->execute();
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        } else {
            return $errors;
        }
    }


    private function validateRegisterBody(): array
    {
        $errors = [];

        if (strlen($this->body['nic']) == 0) {
            $errors['NIC'] = 'NIC must not be empty.';
        } else if (!preg_match('/^(?:19|20)?\d{2}[0-9]{10}|[0-9]{9}[vVxX]$/', $this->body['nic'])) {
            {
                $errors['NIC'] = 'NIC must be a valid Sri Lankan NIC number.';
            }
        } else {
            $query = "SELECT * FROM customer WHERE  NIC = :NIC";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":NIC", $this->body["nic"]);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $errors['NIC'] = 'NIC already exists.';
            }
        }

        if (strlen(trim($this->body['f_name'])) == 0) {
            $errors['f_name'] = 'First name must not be empty.';
        } else {
            if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
                $errors['f_name'] = 'First name must contain only letters.';
            }
        }

        if (strlen($this->body['l_name']) == 0) {
            $errors['l_name'] = 'Last name must not be empty.';
        } else {
            if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
                $errors['l_name'] = 'First name must contain only letters.';
            }
        }

        if (strlen($this->body['contact_no']) == 0) {
            $errors['contact_no'] = 'Contact number must not be empty.';
        } else {
            if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
                $errors['contact_no'] = 'Contact number must start with +947 and contain 10 digits.';
            }
        }

        if (strlen($this->body['address']) == 0) {
            $errors['address'] = 'Address must not be empty.';
        }
        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address.';
        } else {
            $query = "SELECT * FROM customer WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $customer = $statement->fetchObject();
            if ($customer) {
                $errors['email'] = 'Email already in use.';
            }
        }

        if (strlen($this->body['password']) == 0) {
            $errors['password'] = 'Password length must be at least 6 characters';
        } else if ($this->body['password'] !== $this->body['confirm_password']) {
            $errors['password'] = 'Password & Confirm password must match';
        }

        return $errors;
    }


    public function login(): array|object
    {
        $errors = [];
        $customer = null;

        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else {
            $query = "SELECT * FROM customer WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $customer = $statement->fetchObject();
            if (!$customer) {
                $errors['email'] = 'Email does not exists';
            } else {
                if ($this->body['password'] !== $customer->password) {
                    $errors['password'] = 'Password is incorrect';
                }
            }
        }
        if (empty($errors)) {
            return $customer;
        }
        return $errors;

    }


}