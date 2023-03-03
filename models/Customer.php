<?php

namespace app\models;

use app\core\Database;
use app\core\Session;
use app\utils\EmailClient;
use app\utils\FSUploader;
use Exception;
use PDO;
use PDOException;
use SendinBlue\Client\ApiException;

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

    public function tempRegister(): bool|array|string
    {
        $errors = $this->validateTempRegisterBody();

        if (empty($errors)) {
            try {
                $imageUrl = FSUploader::upload(innerDir: "customers/profile-photos");
            } catch (Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                //for customer table
                $query = "INSERT INTO temp_customer 
                    (
                        f_name, l_name, contact_no, address, email, password, image, email_verification_code, mobile_verification_code
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image, :email_verification_code, :mobile_verification_code
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

                //                //cryptographically secure 6-digits OTP code
                try {
                    $email_otp = (string) random_int(100000, 999999);
                    $statement->bindValue(":email_verification_code", $email_otp);
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                try {
                    $mobile_otp = (string) random_int(100000, 999999);
                    $statement->bindValue(":mobile_verification_code", $mobile_otp);
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                try {
                    $statement->execute();
                    //                    try {
                    //                        EmailClient::sendEmail(
                    //                            receiverEmail: $this->body["email"],
                    //                            receiverName: $this->body["f_name"] . " " . $this->body["l_name"],
                    //                            subject: "Email Verification",
                    //                            params: [
                    //                                "CODE" => $email_verification_code
                    //                            ]
                    //                        );
                    //                    } catch (ApiException $e) {
                    //                        error_log($e->getMessage());
                    //                        return false;
                    //                    }
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

    public function register(): bool|array|string
    {
        $errors = $this->validateRegisterBody();
        if (empty($errors)) {
            $sql = "SELECT * FROM temp_customer WHERE email_verification_code = :code";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":code" => $this->body["code"]
            ]);
            $tempCustomer = $stmt->fetchObject();
            if ($tempCustomer) {
                $query = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email, password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":f_name", $tempCustomer->f_name);
                $statement->bindValue(":l_name", $tempCustomer->l_name);
                $statement->bindValue(":contact_no", $tempCustomer->contact_no);
                $statement->bindValue(":address", $tempCustomer->address);
                $statement->bindValue(":email", $tempCustomer->email);
                $statement->bindValue(":password", $tempCustomer->password);
                $statement->bindValue(":image", $tempCustomer->image);

                try {
                    $statement->execute();
                    $sql = "DELETE FROM temp_customer WHERE email_verification_code = :code";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ":code" => $this->body["code"]
                    ]);
                    return true;
                } catch (PDOException $e) {
                    return false;
                }
            } else {
                $errors["verification_code"] = "Invalid verification code";
                return $errors;
            }
        } else {
            return $errors;
        }
    }

    public function registerWithVehicle(): bool|array|string
    {
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

    private function validateTempRegisterBody(): array
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

    private function validateRegisterWithVehicleBody(): array
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

    private function validateRegisterBody(): array
    {
        $errors = [];

        $verificationCode = $this->body['code'];
        $sql = "SELECT * FROM temp_customer WHERE email_verification_code = :code";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':code', $verificationCode);
        $statement->execute();
        $tempCustomer = $statement->fetchObject();
        if (!$tempCustomer) {
            $errors['verification_code'] = 'Invalid verification code';
        }
        return $errors;
    }

    private function validateUpdateCustomerBody(): array
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
            $query = "SELECT * FROM customer WHERE contact_no = :contact_no AND customer_id != :customer_id";
            $statement = $this->pdo->prepare($query);
            //prepare the query for the database
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            //contact_no replace with the contact_no of this->body
            $statement->bindValue(":customer_id", $this->body["customer_id"]);

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

        return $errors;
    }

    public function updateCustomer()
    {
        $errors = $this->validateUpdateCustomerBody();
        if (empty($errors)) {
            $query = "UPDATE customer SET
                        f_name= :f_name, 
                        l_name= :l_name, 
                        contact_no= :contact_no, 
                        address= :address 
                        WHERE customer_id= :customer_id";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":f_name", $this->body["f_name"]);
            $statement->bindValue(":l_name", $this->body["l_name"]);
            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            $statement->bindValue(":address", $this->body["address"]);
            $statement->bindValue(":customer_id", $this->body["customer_id"]);
            
            try {
                $statement->execute();
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }

        } else {
            return $errors;
        }
    }
}
