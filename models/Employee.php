<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use app\utils\FSUploader;
use app\utils\Util;
use Exception;
use PDO;
use PDOException;

class Employee
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function getEmployeeById(int $employee_id): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employee WHERE employee_id = :employee_id");
        $stmt->execute([
            ":employee_id" => $employee_id,

        ]);
        return $stmt->fetchObject();
    }

    public function register(): bool|array
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "employee/profile-photos");
            } catch (Exception $e) {
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
                } catch (PDOException $e) {
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

        // if (trim($this->body['fi']) === '') {
        //     $errors['fi'] = 'Full name with initials must not be empty.';
        // }

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
            $statement->bindValue(":nic", $this->body["nic"]);
            $statement->execute();
            if ($statement->rowCount() > 0) {
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
            if ($employee) {
                $errors['email'] = 'email already in use.';
            }
        }

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
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            $statement->execute();
            if ($statement->rowCount() > 0) {
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
            //filter_var: filters variables
            $errors['email'] = 'email must be a valid email address';
        } else {
            $query = "SELECT * FROM employee WHERE email = :email";
            //Creates a SQL query with a parameter placeholder named ":email".
            $statement = $this->pdo->prepare($query);
            //Uses the PDO object's "prepare" method to prepare the query for execution.
            $statement->bindValue(':email', $this->body['email']);
            //Binds the value of the ":email" parameter placeholder to the value of the "email" key in the "body" array.
            $statement->execute();
            $employee = $statement->fetchObject();
            //Fetches the first result of the executed query as an object using the "fetchObject" method.
            if (!$employee) {
                $errors['email'] = 'email does not exist';
            } else if (!password_verify($this->body['password'], $employee->password)) {
                //checks if the hash of the provided password matches the hashed password stored in the "$employee->password" property.
                $errors['password'] = 'password is incorrect';

            }
        }
        if (empty($errors)) {
            return $employee;
        }
        return $errors;
    }

    public function getEmployees(
        int|null $count = null,
        int|null $page = 1,
        string $searchTermName = null,
        string $searchTermId = null,
        array $options =[
            'employeeStatus' => null,
            'employeeRole' => null        
        ]): array|string
    {
        $whereClause = null;
        $conditions =[];

        foreach ($options as $option_key => $option_value){
            if($option_value !== null){
                switch($option_key){
                    case 'employeeRole':
                        switch($option_value){
                            case "all":
                                // $conditions[] = "job_role = 'admin' OR job_role = 'security_officer' OR job_role = 'office_staff_member' OR job_role = 'foreman' OR job_role = 'technician' OR job_role = 'stock_manager'";
                                break;
                            case "admin":
                                $conditions[] = "job_role = 'admin'";
                                break;
                            case "security_officer":
                                $conditions[] = "job_role = 'security_officer'";
                                break;
                            case "office_staff_member":
                                $conditions[] = "job_role = 'office_staff_member'";
                                break;
                            case "foreman":
                                $conditions[] = "job_role = 'foreman'";
                                break;
                            case "technician":
                                $conditions[] = "job_role = 'technician'";
                                break;
                            case "stock_manager":
                                $conditions[] = "job_role = 'stock_manager'";
                                break;
                        }
                        break;

                    case 'employeeStatus':
                        switch($option_value){
                            case "active":
                                $conditions[] = "is_active = TRUE";
                                break;
                            case "busy":
                                $conditions[] = "is_active = FALSE";
                                break;
                        }
                    break;
                }
            }
        }

        if(!empty($conditions)){
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        if($searchTermName !== null){
            $whereClause = $whereClause ? $whereClause . " AND f_name LIKE :search_term_name" : " WHERE f_name LIKE :search_term_name";
        }

        if($searchTermId !== null){
            $whereClause = $whereClause ? $whereClause . " AND employee_id LIKE :search_term_id" : " WHERE employee_id LIKE :search_term_id";
        }

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        
        // var_dump(('Tharushi'));
        // var_dump($whereClause);

        $query =  "SELECT 
                employee_id as ID,
                f_name as 'First Name',
                l_name as 'Last Name',
                contact_no as 'Contact No',
                email as Email,
                job_role as JobType,
                is_active as isActive,
                image as Image
            FROM employee $whereClause $limitClause $pageClause ";
        
        $statement = $this->pdo->prepare($query);

        if($searchTermName !== null){
            $statement->bindValue(":search_term_name", "%" . $searchTermName . "%", PDO::PARAM_STR);
        }

        if($searchTermId !== null){
            $statement->bindValue(":search_term_id", "%" . $searchTermId . "%", PDO::PARAM_STR);
        }

        try{

            $statement->execute();
            $employees = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $this->pdo->prepare("
                SELECT count(*) as total FROM employee $whereClause"
            );

            if($searchTermName !== null){
                $statement->bindValue(":search_term_name", "%" . $searchTermName . "%", PDO::PARAM_STR);
            }
    
            if($searchTermId !== null){
                $statement->bindValue(":search_term_id", "%" . $searchTermId . "%", PDO::PARAM_STR);
            }

            $statement -> execute();
            $totalEmployees = $statement->fetch(PDO::FETCH_ASSOC);

            return [
                "total" => $totalEmployees['total'],
                "employees" => $employees
            ];

        }
        catch(PDOException $e){
            return $e->getMessage();
        }

    }

    private function validateUpdateFormBody(): array
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

        // if (trim($this->body['fi']) === '') {
        //     $errors['fi'] = 'Full name with initials must not be empty.';
        // }

        if (empty($this->body['dob'])) {
            $errors['dob'] = 'Date of birth must not be empty.';
        } elseif (!Util::isRealDate($this->body['dob'])) {
            $errors['dob'] = 'Date of birth is not a valid date.';
        }

        if ($this->body['nic'] === '') {
            $errors['nic'] = 'NIC number must not be empty.';
        } else if (!preg_match('/^(\d{9}[xXvV]|\d{12})$/', $this->body['nic'])) {
            $errors['nic'] = 'NIC No must be in either be in 996632261V or 200022203401 format.';
        } else {
            $query = "SELECT * FROM employee WHERE nic = :nic";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":nic", $this->body["nic"]);
            $statement->execute();
            if ($statement->rowCount() > 1) {
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
            $statement->fetchObject();
            if ($statement->rowCount() > 1) {
                $errors['email'] = 'email already in use.';

            }
        }

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
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            $statement->execute();
            if ($statement->rowCount() > 1) {
                $errors['contact_no'] = 'Contact number already in use.';
            }
        }
        return $errors;
    }

    public function update(int $employee_id, string $new_job_role, string $before_job_role): bool|array
    {
        $errors = $this->validateUpdateFormBody();
        var_dump($new_job_role);
        var_dump($before_job_role);
        var_dump($employee_id);
        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "employee/profile-photos");
            } catch (Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                if($new_job_role!== $before_job_role){
                    if($before_job_role=='security_officer'){
                        $query = "DELETE from securityofficer where employee_id= $employee_id";
                        $statement = $this->pdo->prepare($query);
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                        if($new_job_role=='office_staff_member'){
                            $query = "INSERT into officestaff (employee_id) values ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='foreman'){
                            $query = "INSERT into foreman (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='technician'){
                            $query = "INSERT into technician (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        else{
                            $query = "INSERT into stockmanager (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                    }
                    elseif($before_job_role=="office_staff_member"){
                        $query = "DELETE from officestaff where employee_id= $employee_id";
                        $statement = $this->pdo->prepare($query);
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                        if($new_job_role=='security_officer'){
                            $query = "INSERT into securityofficer (employee_id) values ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='foreman'){
                            $query = "INSERT into foreman (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='technician'){
                            $query = "INSERT into technician (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        else{
                            $query = "INSERT into stockmanager (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }                  
                    }
                    elseif($before_job_role=="foreman"){
                        $query = "DELETE from foreman where employee_id= $employee_id";
                        var_dump($query);
                        $statement = $this->pdo->prepare($query);
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                        if($new_job_role=='office_staff_member'){
                            $query = "INSERT into officestaff (employee_id) values ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='security_officer'){
                            $query = "INSERT into securityofficer (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='technician'){
                            $query = "INSERT into technician (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        else{
                            $query = "INSERT into stockmanager (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }                  
                    }
                    elseif($before_job_role=="technician"){
                        $query = "DELETE from technician where employee_id= $employee_id";
                        $statement = $this->pdo->prepare($query);
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                        if($new_job_role=='office_staff_member'){
                            $query = "INSERT into officestaff (employee_id) values ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='foreman'){
                            $query = "INSERT into foreman (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='security_officer'){
                            $query = "INSERT into securityofficer (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        else{
                            $query = "INSERT into stockmanager (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }                      
                    }
                    elseif($before_job_role=="stock_manager"){
                        $query = "DELETE from stockmanager where employee_id= $employee_id";
                        $statement = $this->pdo->prepare($query);
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }
                        if($new_job_role=='office_staff_member'){
                            $query = "INSERT into officestaff (employee_id) values ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='foreman'){
                            $query = "INSERT into foreman (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        elseif($new_job_role=='technician'){
                            $query = "INSERT into technician (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        else{
                            $query = "INSERT into securityofficer (employee_id) VALUES ($employee_id)";
                            $statement = $this->pdo->prepare($query);
                        }
                        try{
                            $statement->execute();
                        }
                        catch(PDOException $e){
                            $errors["db_error"] = $e->getMessage();
                            return $errors;
                        }                 
                    }
                }
                $query = "UPDATE employee SET
                    NIC = :nic,
                    f_name = :f_name, 
                    l_name = :l_name,
                    dob = :dob,
                    address = :address,
                    email = :email,
                    job_role = :job_role,
                    contact_no = :contact_no,
                    image = :image
                WHERE employee_id = :employee_id";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":nic", $this->body["nic"]);
                $statement->bindValue(":f_name", $this->body["f_name"]);
                $statement->bindValue(":l_name", $this->body["l_name"]);               
                $statement->bindValue(":dob", $this->body["dob"]);
                $statement->bindValue(":address", $this->body["address"]);
                $statement->bindValue(":email", $this->body["email"]);
                $statement->bindValue(":job_role", $this->body["job_role"]);
                $statement->bindValue(":contact_no", $this->body["contact_no"]);
                $statement->bindValue(":employee_id", $employee_id);
                $statement->bindValue(":image", $imageUrl ?? "");
                try{
                    $statement->execute();
                    return $statement->rowCount() > 0;
                }
                catch(PDOException $e){
                    $errors["db_error"] = $e->getMessage();
                    return $errors;
                }
            } else {
                return $errors;
            }
        } 
        else {
            return $errors;
        }
    }

    public function deleteEmployeeById(int $employee_id):bool|string

    {
        var_dump($employee_id);
        try {
            $query ="UPDATE employee SET is_active = FALSE WHERE employee_id = :employee_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":employee_id", $employee_id);
            $statement->execute();

            return $statement->rowCount() > 0;
        }
        catch (PDOException $e){

        var_dump($e->getMessage());
            return "Error deleting Employee";

        }
    }
}
