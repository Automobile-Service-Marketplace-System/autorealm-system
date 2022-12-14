<?php

namespace app\models;

use app\core\Database;
use app\core\Session;
use app\utils\FSUploader;
use Exception;
use PDO;
use PDOException;

class Customer
{
    private PDO $pdo;
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

    public function register(): bool|array|string
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                //for customer table
                $query = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email, password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                $statement = $this->pdo->prepare($query);
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
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    return false;
                }
            } else {
                return $errors;
            }

        } else {
            return $errors;
        }
    }

    public function registerWithVehicle() : bool | array | string {
        $errors = $this->validateRegisterWithVehicleBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                //for customer table
                $query = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email, password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                $statement = $this->pdo->prepare($query);
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
                    // return true;
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    return false;
                }

                //for vehicle table
                $query = "INSERT INTO vehicle 
                    (
                        vin, reg_no, engine_no, manufactured_year, engine_capacity, vehicle_type, fuel_type, transmission_type, customer_id, model_id, brand_id
                    ) 
                    VALUES 
                    (
                        :vin, :reg_no, :engine_no, :manufactured_year, :engine_capacity, :vehicle_type, :fuel_type, :transmission_type, :customer_id, :model, :brand
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":vin", $this->body["vin"]);
                $statement->bindValue(":reg_no", $this->body["reg_no"]);
                $statement->bindValue(":engine_no", $this->body["engine_no"]);
                $statement->bindValue(":manufactured_year", $this->body["manufactured_year"]);
                $statement->bindValue(":engine_capacity", $this->body["engine_capacity"]);
                $statement->bindValue(":vehicle_type", $this->body["vehicle_type"]);
                $statement->bindValue(":fuel_type", $this->body["fuel_type"]);
                $statement->bindValue(":transmission_type", $this->body["transmission_type"]);
                $statement->bindValue(":customer_id", $this->pdo->lastInsertId());
                $statement->bindValue(":model", $this->body["model"]);
                $statement->bindValue(":brand", $this->body["brand"]);
                try {
                    $statement->execute();
                    return true;
                } catch (PDOException $e) {
                    return $e->getMessage();
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

        if (trim($this->body['f_name']) === '') {  //remove whitespaces by trim(string)
            $errors['f_name'] = 'First name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
            $errors['f_name'] = 'First name must contain only letters.';
        }

        if (trim($this->body['l_name']) === '') {
            $errors['l_name'] = 'Last name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
            $errors['l_name'] = 'First name must contain only letters.';
        }

        if (trim($this->body['contact_no']) === '') {
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

        if (trim($this->body['address']) === '') {
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

        if ($this->body['password'] === '') {
            $errors['password'] = 'Password length must be at least 6 characters';
        } else if ($this->body['password'] !== $this->body['confirm_password']) {
            $errors['password'] = 'Password & Confirm password must match';
        }

        return $errors;
    }

    private function validateRegisterWithVehicleBody() : array {
        $errors = [];

        if (trim($this->body['f_name']) === '') {  //remove whitespaces by trim(string)
            $errors['f_name'] = 'First name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
            $errors['f_name'] = 'First name must contain only letters.';
        }

        if (trim($this->body['l_name']) === '') {
            $errors['l_name'] = 'Last name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
            $errors['l_name'] = 'First name must contain only letters.';
        }

        if (trim($this->body['contact_no']) === '') {
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

        if (trim($this->body['address']) === '') {
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

        if ($this->body['password'] === '') {
            $errors['password'] = 'Password length must be at least 6 characters';
        } else if ($this->body['password'] !== $this->body['confirm_password']) {
            $errors['password'] = 'Password & Confirm password must match';
        }

        //for vehicle
        if ($this->body['vin'] === '') {
            $errors['vin'] = 'VIN must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE vin = :vin";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":vin", $this->body["vin"]);
            //contact_no replace with the contact_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['vin'] = 'VIN already in use.';
            }
        }

        if ($this->body['engine_no'] === '') {
            $errors['engine_no'] = 'Engine No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE engine_no = :engine_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":engine_no", $this->body["engine_no"]);
            //engine_no replace with the engine_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['engine_no'] = 'Engine No already in use.';
            }
        }

        if ($this->body['reg_no'] === '') {
            $errors['reg_no'] = 'Registration No must not be empty.';
        } else {
            $query = "SELECT * FROM vehicle WHERE reg_no = :reg_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":reg_no", $this->body["reg_no"]);
            //engine_no replace with the engine_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['reg_no'] = 'Registration No already in use.';
            }
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
                $errors['email'] = 'Email does not exist';
            } else if (!password_verify($this->body['password'], $customer->password)) {
                $errors['password'] = 'Password is incorrect';
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