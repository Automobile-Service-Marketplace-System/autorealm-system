<?php

namespace app\models;

use app\core\Database;

class Customer
{
    private \PDO $pdo;
    private array $registerBody;



    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->registerBody = $registerBody;
    }


    public function register(): bool
    {
        $query = "INSERT INTO customer (
                      NIC, 
                      f_name, 
                      l_name, 
                      contact_no, 
                      address, 
                      email, 
                      password
                    ) 
                    VALUES (
                            :NIC, 
                            :f_name, 
                            :l_name, 
                            :contact_no, 
                            :address, 
                            :email, 
                            :password
                    )";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":NIC", $this->registerBody["nic"]);
        $statement->bindValue(":f_name", $this->registerBody["f_name"]);
        $statement->bindValue(":l_name", $this->registerBody["l_name"]);
        $statement->bindValue(":contact_no", $this->registerBody["contact_no"]);
        $statement->bindValue(":address", $this->registerBody["address"]);
        $statement->bindValue(":email", $this->registerBody["email"]);
        $statement->bindValue(":password", $this->registerBody["password"]);
        $statement->execute();

        // check if the query was successful
        if($statement->rowCount() > 0) {
            return true;
        }
        return false;
    }


    public function validateRegisterBody(): array
    {
        $errors = [];

        if (strlen($this->registerBody['nic']) == 0) {
            $errors['NIC'] = 'NIC must be 10 characters';
        }

        if (strlen($this->registerBody['f_name']) == 0) {
            $errors['f_name'] = 'First name must be 3 characters';
        }

        if (strlen($this->registerBody['l_name']) == 0) {
            $errors['l_name'] = 'Last name must be 3 characters';
        }

        if (strlen($this->registerBody['contact_no']) == 0) {
            $errors['contact_no'] = 'Contact number must be 10 characters';
        }

        if (strlen($this->registerBody['address']) == 0) {
            $errors['address'] = 'Address must be 3 characters';
        }
        if (!filter_var($this->registerBody['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else {
            $query = "SELECT * FROM customer WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->registerBody['email']);
            $statement->execute();
            $customer = $statement->fetchObject();
            if ($customer) {
                $errors['email'] = 'Email already exists';
            }
        }

        if (strlen($this->registerBody['password']) == 0) {
            $errors['password'] = 'Password length must be atleast 6 characters';
        } else if ($this->registerBody['password'] !== $this->registerBody['confirm_password']) {
            $errors['password'] = 'Password & Confirm password must match';
        }

        return $errors;
    }


}