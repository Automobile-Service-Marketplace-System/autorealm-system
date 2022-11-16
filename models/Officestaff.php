<?php

namespace app\models;

use app\core\Database;
use app\utils\FSUploader;

class Officestaff
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


//    public function register(): bool|array
//    {
//        $errors = $this->validateRegisterBody();
//
//        if (empty($errors)) {
//            try {
//                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
//            } catch (\Exception $e) {
//                $errors["image"] = $e->getMessage();
//            }
//            if (empty($errors)) {
//                $query = "INSERT INTO customer
//                    (
//                        f_name, l_name, contact_no, address, email,password, image
//                    )
//                    VALUES
//                    (
//                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
//                    )";
//
//                $statement = $this->pdo->prepare($query);
//                $statement->bindValue(":f_name", $this->body["f_name"]);
//                $statement->bindValue(":l_name", $this->body["l_name"]);
//                $statement->bindValue(":contact_no", $this->body["contact_no"]);
//                $statement->bindValue(":address", $this->body["address"]);
//                $statement->bindValue(":email", $this->body["email"]);
//                $hash = password_hash($this->body["password"], PASSWORD_DEFAULT);
//                $statement->bindValue(":password", $hash);
//                $statement->bindValue(":image", $imageUrl ?? "");
//                try {
//                    $statement->execute();
//                    return true;
//                } catch (\PDOException $e) {
//                    return false;
//                }
//            } else {
//                return $errors;
//            }
//
//        } else {
//            return $errors;
//        }
//    }


//    private function validateRegisterBody(): array
//    {
//        $errors = [];
//
//        if (strlen(trim($this->body['f_name'])) == 0) {
//            $errors['f_name'] = 'First name must not be empty.';
//        } else {
//            if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
//                $errors['f_name'] = 'First name must contain only letters.';
//            }
//        }
//
//        if (strlen($this->body['l_name']) == 0) {
//            $errors['l_name'] = 'Last name must not be empty.';
//        } else {
//            if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
//                $errors['l_name'] = 'First name must contain only letters.';
//            }
//        }
//
//        if (strlen($this->body['contact_no']) == 0) {
//            $errors['contact_no'] = 'Contact number must not be empty.';
//        } else if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
//            $errors['contact_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
//        } else {
//            $query = "SELECT * FROM customer WHERE contact_no = :contact_no";
//            $statement = $this->pdo->prepare($query);
//            $statement->bindValue(":contact_no", $this->body["contact_no"]);
//            $statement->execute();
//            if ($statement->rowCount() > 0) {
//                $errors['contact_no'] = 'Contact number already in use.';
//            }
//        }
//
//        if (strlen($this->body['address']) == 0) {
//            $errors['address'] = 'Address must not be empty.';
//        }
//        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
//            $errors['email'] = 'Email must be a valid email address.';
//        } else {
//            $query = "SELECT * FROM customer WHERE email = :email";
//            $statement = $this->pdo->prepare($query);
//            $statement->bindValue(':email', $this->body['email']);
//            $statement->execute();
//            $customer = $statement->fetchObject();
//            if ($customer) {
//                $errors['email'] = 'Email already in use.';
//            }
//        }
//
//        if (strlen($this->body['password']) == 0) {
//            $errors['password'] = 'Password length must be at least 6 characters';
//        } else if ($this->body['password'] !== $this->body['confirm_password']) {
//            $errors['password'] = 'Password & Confirm password must match';
//        }
//
//        if ($this->body["tc"] != "on") {
//            $errors['tc'] = 'You must agree to the terms and conditions.';
//        }
//
//        if ($this->body["pp"] != "on") {
//            $errors['pp'] = 'You must agree to the privacy policy.';
//        }
//
//        return $errors;
//    }


    public function login(): array|object
    {
        $errors = [];
        $officestaff = null;

        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $officestaff = $statement->fetchObject();
            if (!$officestaff) {
                $errors['email'] = 'Email does not exist';
            } else {
                if ($this->body['password'] != $officestaff->password) {
                    $errors['password'] = 'Password is incorrect';
                }
            }
        }
        if (empty($errors)) {
            return $officestaff;
        }
        return $errors;
    }


}