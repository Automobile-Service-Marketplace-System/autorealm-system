<?php

namespace app\models;

use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;
use PDO;

class Customer
{
    private \PDO $pdo;
    // PDO is a database access layer that provides a fast and
    // consistent interface for accessing and managing databases in PHP applications
    private array $body;


    public function __construct(array $registerBody = [])
    {
            $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getCustomerById(int $customer_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE customer_id = :customer_id");
        $stmt->execute([
            ":customer_id" => $customer_id
        ]);
        return $stmt->fetchObject();
    }

    public function register(): bool|array
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (\Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                $query1 = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email,password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                $statement = $this->pdo->prepare($query1);
                $statement->bindValue(":f_name", $this->body["f_name"]);
                $statement->bindValue(":l_name", $this->body["l_name"]);
                $statement->bindValue(":contact_no", $this->body["contact_no"]);
                $statement->bindValue(":address", $this->body["address"]);
                $statement->bindValue(":email", $this->body["email"]);
                $hash = password_hash($this->body["password"], PASSWORD_DEFAULT);
                $statement->bindValue(":password", $hash);
                $statement->bindValue(":image", $imageUrl ?? "");
                try {
                    $statement->execute();
                    return true;
                } catch (\PDOException $e) {
                    return false;
                }
            } else {
                return $errors;
            }

        } else {
            return $errors;
        }
    }


    private function validateRegisterBody(): array
    {
        $errors = [];

        if (strlen(trim($this->body['f_name'])) == 0) {  //remove whitespaces by trim(string)
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
        } else if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
            $errors['contact_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
        } else {
            $query = "SELECT * FROM customer WHERE contact_no = :contact_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            //contact_no replace with the contact_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['contact_no'] = 'Contact number already in use.';
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
            //returns the current statement as an object to customer.
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


    public function login(): array |object
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
                $errors['email'] = 'Email does not exist';
            } else {
                if (!password_verify($this->body['password'], $customer->password)) {
                    $errors['password'] = 'Password is incorrect';
                }
            }
        }
        if (empty($errors)) {
            return $customer;
        }
        return $errors;
    }

    public function getCustomers(): array 
    {

        return $this->pdo->query("
            SELECT 
                customer_id as ID,
                CONCAT(f_name, ' ', l_name) as 'Full Name',
                contact_no as 'Contact No',
                address as Address,
                email as Email
            FROM customer")->fetchAll(PDO::FETCH_ASSOC);

    }

    


}