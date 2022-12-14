<?php

namespace app\models;

use app\core\Database;
use app\utils\FSUploader;
use app\utils\Util;
use PDO;

class Employee
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
//        var_dump($this->body);
    }

    public function getEmployeeById(int $employee_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee WHERE employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $employee_id
        ]);
        return $stmt->fetchObject();
    }

    public function register(): bool|array
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "employee/profile-photos");
            } catch (\Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                $query = "INSERT INTO employee 
                    (
                        NIC, f_name, l_name, dob, address, email, job_role, contact_no, password,is_active, date_of_appointed, image
                    ) 
                    VALUES 
                    (
                        :nic, :f_name, :l_name, :dob, :address, :email, :job_role, :contact_no, :password, 1, CURDATE(), :image
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":nic", $this->body["nic"]);
                $statement->bindValue(":f_name", $this->body["f_name"]);
                $statement->bindValue(":l_name", $this->body["l_name"]);
                // full name with initials
                $statement->bindValue(":dob", $this->body["dob"]);
                $statement->bindValue(":address", $this->body["address"]);
                $statement->bindValue(":email", $this->body["email"]);
                $statement->bindValue(":job_role", $this->body["job_role"]);
                $statement->bindValue(":contact_no", $this->body["contact_no"]);
                
                $hash = password_hash($this->body["password"], PASSWORD_DEFAULT);
                $statement->bindValue(":password", $hash);
                $statement->bindValue(":image", $imageUrl ?? "");
                try {
                    $statement->execute();
                    $lastInsertedId = $this->pdo->lastInsertId();
                    switch ($this->body['job_role']) {
                        case "foreman":
                            $query = "INSERT INTO  foreman (employee_id, is_available) VALUES (:employee_id, 1)";
                            $statement = $this->pdo->prepare($query);
                            $statement->bindValue(":employee_id", $lastInsertedId);
                            $statement->execute();
                            break;
                        case "security_officer":
                            $query = "INSERT INTO securityofficer (employee_id, shift) VALUES (:employee_id,'day')";
                            $statement = $this->pdo->prepare($query);
                            $statement->bindValue(":employee_id", $lastInsertedId);
                            $statement->execute();
                            break;
                        case "technician":
                            $query = "INSERT INTO technician (employee_id, is_available, speciality) VALUES (:employee_id, 1, 'none')";
                            $statement = $this->pdo->prepare($query);
                            $statement->bindValue(":employee_id", $lastInsertedId);
                            $statement->execute();
                            break;
                        case "stock_manager":
                            $query = "INSERT INTO stockmanager (employee_id) VALUES (:employee_id)";
                            $statement = $this->pdo->prepare($query);
                            $statement->bindValue(":employee_id", $lastInsertedId);
                            $statement->execute();
                            break;
                        case "office_staff_member":
                            $query = "INSERT INTO officestaff (employee_id, type) VALUES (:employee_id, 'clerk')";
                            $statement = $this->pdo->prepare($query);
                            $statement->bindValue(":employee_id", $lastInsertedId);
                            $statement->execute();
                            break;
                        default:
                            break;

                    }
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


        if (trim($this->body['f_name']) === '') {
            $errors['f_name'] = 'First name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
            $errors['f_name'] = 'First name must contain only letters.';
        }

        if (trim($this->body['l_name']) === '') {
            $errors['l_name'] = 'Last name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
            $errors['l_name'] = 'Last name must contain only letters.';
        }


        if (trim($this->body['fi']) === '') {
            $errors['fi'] = 'Full name with initials must not be empty.';
        }


        if (empty($this->body['dob'])) {
            $errors['dob'] = 'Date of birth must not be empty.';
        } elseif (!Util::isRealDate($this->body['dob'])) {
            $errors['dob'] = 'Date of birth is not a valid date.';
        }


        if ($this->body['nic'] === '') {
            $errors['nic'] = 'NIC number must not be empty.';
        } else if (!preg_match('/^(\d{9}[xXvV]|\d{12})$/', $this->body['nic'])) {
            $errors['nic'] = 'NIC No must be in either be in 996632261V or 200022203401 forma.';
        } else {
            $query = "SELECT * FROM employee WHERE nic = :nic";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":nic", $this->body["nic"]);
            //contact_no replace with the contact_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['nic'] = 'NIC number already in use.';
            }
        }

        if ($this->body['address'] === '') {
            $errors['address'] = 'Address must not be empty.';
        }


        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email must be a valid email address.';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $employee = $statement->fetchObject();
            //returns the current statement as an object to employee.
            if ($employee) {
                $errors['email'] = 'email already in use.';
            }
        }


        // if (!(($this->body["security-officer"]) == "on" || ($this->body["office-staff"]) == "on" || ($this->body["foreman"]) == "on" || ($this->body["technician"]) == "on" ||($this->body["stock-manager"]) == "on" )) {
        //     $errors['tc'] = 'You must select job type.';
        // }

        if ($this->body['job_role'] !== 'security_officer' && $this->body['job_role'] !== 'office_staff_member' && $this->body['job_role'] !== 'foreman' && $this->body['job_role'] !== 'technician' && $this->body['job_role'] !== 'stock_manager') {
            $errors['job_role'] = 'You must select job type.';
        }


        if ($this->body['contact_no'] === '') {
            $errors['contact_no'] = 'Contact number must not be empty.';
        } else if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no'])) {
            $errors['contact_no'] = 'Contact number must start with +947 and contain 12 digits.';
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


        if (strlen($this->body['password']) < 6) {
            $errors['password'] = 'password length must be at least 6 characters';
        } else if ($this->body['password'] !== $this->body['confirm_password']) {
            $errors['password'] = 'password & Confirm password must match';
        }

        return $errors;
    }


    public function login(): array|object
    {
        $errors = [];
        $employee = null;

        if (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email must be a valid email address';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $this->body['email']);
            $statement->execute();
            $employee = $statement->fetchObject();
            if (!$employee) {
                $errors['email'] = 'email does not exist';
            } else if (!password_verify($this->body['password'], $employee->password)) {
                $errors['password'] = 'password is incorrect';

            }
        }
        if (empty($errors)) {
            return $employee;
        }
        return $errors;
    }

    public function getEmployee(): array
    {

        return $this->pdo->query("
            SELECT 
                employee_id as ID,
                CONCAT(f_name, ' ', l_name) as 'Full Name',
                contact_no as 'Contact No',
                address as Address,
                email as email
            FROM employee")->fetchAll(PDO::FETCH_ASSOC);

    }
}
