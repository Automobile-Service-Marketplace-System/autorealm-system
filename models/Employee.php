<?php

namespace app\models;

use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;
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
                        :nic, :f_name, :l_name, :dob, :address, :email, :job_role, :con_no, :pw, 1, CURDATE(), :image
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":nic", $this->body["nic"]);
                $statement->bindValue(":f_name", $this->body["f_name"]);   
                $statement->bindValue(":l_name", $this->body["l_name"]);
                // full name with initialies
                $statement->bindValue(":dob", $this->body["dob"]);
                $statement->bindValue(":address", $this->body["address"]);
                $statement->bindValue(":email", $this->body["email"]);
                $statement->bindValue(":job_role", $this->body["job_role"]);
                $statement->bindValue(":con_no", $this->body["con_no"]);
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




        if (strlen($this->body['nic']) == 0) {
            $errors['nic'] = 'NIC number must not be empty.';
        // } else if (!preg_match('/^\+947\d{8}$/', $this->body['con_no'])) {
        //     $errors['con_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
        } else {
            $query = "SELECT * FROM employee WHERE nic = :nic";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":nic", $this->body["nic"]);
            //con_no replace with the con_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['nic'] = 'NIC number already in use.';
            }
        }


        if (strlen(trim($this->body['f_name'])) == 0) {  //remove whitespaces by trim(string)
            $errors['f_name'] = 'First name must not be empty.';
        } else {
            if (!preg_match('/^[\p{L} ]+$/u', $this->body['f_name'])) {
                $errors['f_name'] = 'First name must contain only letters.';
            }
        }

        if (strlen(trim($this->body['l_name'])) == 0) {  //remove whitespaces by trim(string)
            $errors['l_name'] = 'Last name must not be empty.';
        } else {
            if (!preg_match('/^[\p{L} ]+$/u', $this->body['l_name'])) {
                $errors['l_name'] = 'Last name must contain only letters.';
            }
        }


        if (strlen(trim($this->body['fi'])) == 0) {  //remove whitespaces by trim(string)
            $errors['fi'] = 'Full name with initialies must not be empty.';
        }
        


//         if (empty($dob)){
//             $errors['dob'] = 'Please submit your date of birth.';
//         }
//         elseif (!preg_match('~^([0-9]{2})/([0-9]{2})/([0-9]{4})$~', $this->body['dob'],$parts)){
//             $errors['dob'] = 'The date of birth is not a valid date in the format MM/DD/YYYY';
//         }
//         elseif (!checkdate($parts[1],$parts[2],$parts[3])){
//             $errors['dob'] = 'The date of birth is invalid. Please check that the month is between 1 and 12, and the day is valid for that month.';
//         }


        if (strlen($this->body['address']) == 0) {
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

        if( $this->body['job_role'] !=='security_officer' && $this->body['job_role'] !=='office_staff_member' && $this->body['job_role'] !=='foreman' && $this->body['job_role'] !=='technician' && $this->body['job_role'] !=='stock_manager'){
            $errors['job_role'] = 'You must select job type.';
        }


        if (strlen($this->body['con_no']) == 0) {
            $errors['con_no'] = 'Contact number must not be empty.';
        } else if (!preg_match('/^\+947\d{8}$/', $this->body['con_no'])) {
            $errors['con_no'] = 'Contact number must start with +94 7 and contain 10 digits.';
        } else {
            $query = "SELECT * FROM employee WHERE contact_no = :con_no";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":con_no", $this->body["con_no"]);
            //con_no replace with the con_no of this->body
            $statement->execute();
            // click go
            if ($statement->rowCount() > 0) {
                //Return the number of rows
                $errors['con_no'] = 'Contact number already in use.';
            }
        }

        
        if (strlen($this->body['password']) == 0) {
            $errors['password'] = 'password length must be at least 6 characters';
        } else if ($this->body['password'] !== $this->body['confirm_password']) {
            $errors['password'] = 'password & Confirm password must match';
        }

        return $errors;
    }


    public function login(): array |object
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
                con_no as 'Contact No',
                address as Address,
                email as email
            FROM employee")->fetchAll(PDO::FETCH_ASSOC);

    }
}