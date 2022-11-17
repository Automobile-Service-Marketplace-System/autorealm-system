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

    public function register(): bool|array
    {
        $errors = $this->validateRegisterEmployee();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (\Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                $query = "INSERT INTO employee 
                    (
                        f_name, l_name, dob, address, email, job_role, contact_no, password, is_active, date of appointed, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :dob, :address, :email, :job_role, :contact_no, :password, :is_active, :date of appointed, :image
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


    private function validateRegisterEmployee(): array
    {
        $errors = [];

        if(strlen($this->body['nic']) == 0){
            $errors['nic'] = 'National Identity Card No must not be empty.';
        }
        else if (strlen($this->body['nic']) == 10 || strlen($this->body['nic']) == 12) {
            //NIC check
//            if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
//                $errors['contact_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
//            }
        } else {
            $query = "SELECT * FROM employee WHERE contact_no = :nic";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":nic", $this->body["nic"]);
            //contact_no replace with the contact_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['nic'] = 'NIC already in use.';
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

        if (empty($this->body['dob'])){
            $errors['dob'] = 'Please submit your date of birth.';
        }
        elseif (!preg_match('~^([0-9]{2})/([0-9]{2})/([0-9]{4})$~', $this->body['dob'], $parts)){
            $errors['dob']= 'The date of birth is not a valid date in the format MM/DD/YYYY';
        }
        elseif (!checkdate($parts[1],$parts[2],$parts[3])){
            $errors['dob'] = 'The date of birth is invalid. Please check that the month is between 1 and 12, and the day is valid for that month.';
        }

        if (strlen($this->body['contact_no']) == 0) {
            $errors['contact_no'] = 'Contact number must not be empty.';
        } else if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
            $errors['contact_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
        } else {
            $query = "SELECT * FROM employee WHERE contact_no = :contact_no";
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
            $query = "SELECT * FROM employee WHERE email = :email";
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