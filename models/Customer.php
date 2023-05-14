<?php

namespace app\models;

use app\core\Database;
use app\core\Session;
use app\utils\DevOnly;
use app\utils\EmailClient;
use app\utils\FSUploader;
use app\utils\SmsClient;
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

    // public function getCustomerCountData():array|string{
    //     try{
    //         $statement = $this->pdo->prepare("SELECT
    //         count(cvc.*) from as count from customer_verification_codes cvc
    //         join customer c on c.customer_id=cvc.customer_id
    //         WHERE created_at BETWEEN DATE_FORMAT(CURRENT_DATE, '%Y-%m-01') 
    //         AND CURRENT_DATE");
    //         $statement->execute();
    //         $CustomerCount = $statement->fetchAll(PDO::FETCH_ASSOC);
    //         return $CustomerCount;
    //     }
    //     catch(PDOException|Exception $e){
    //         return "Failed to get data : " . $e->getMessage();
    //     }
    // }

    public function getCustomerById(int $customer_id): bool|object|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE customer_id = :customer_id");
        $stmt->execute([
            ":customer_id" => $customer_id
        ]);
        return $stmt->fetchObject();
    }

    public function getCustomerByPaymentId(string $paymentId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE payment_id = :payment_id");
        $stmt->execute([
            ":payment_id" => $paymentId
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
                try {
                    $this->pdo->beginTransaction();
                    $customerCreateQuery = "INSERT INTO customer 
                    (
                        f_name, l_name, contact_no, address, email, password, image
                    ) 
                    VALUES 
                    (
                        :f_name, :l_name, :contact_no, :address, :email, :password, :image
                    )";

                    $statement = $this->pdo->prepare($customerCreateQuery);
                    $statement->bindValue(":f_name", $this->body["f_name"]);
                    $statement->bindValue(":l_name", $this->body["l_name"]);
                    $statement->bindValue(":contact_no", $this->body["contact_no"]);
                    $statement->bindValue(":address", $this->body["address"]);
                    $statement->bindValue(":email", $this->body["email"]);
                    $hash = password_hash($this->body["password"], PASSWORD_DEFAULT);
                    $statement->bindValue(":password", $hash);
                    $statement->bindValue(":image", $imageUrl ?? "");

                    $statement->execute();

                    $customerId = $this->pdo->lastInsertId();

                    $customerVerificationCodesQuery = "INSERT INTO customer_verification_codes (customer_id,  email_otp) VALUE (:customer_id,  :email_otp)";
                    $emailOtp = (string)random_int(100000, 999999);
                    //                    $mobileOtp = (string)random_int(100000, 999999);
                    $statement = $this->pdo->prepare($customerVerificationCodesQuery);
                    $statement->bindValue(":customer_id", $customerId);
                    //                    $statement->bindValue(":mobile_otp", $mobileOtp);
                    $statement->bindValue(":email_otp", $emailOtp);

                    $statement->execute();
                    EmailClient::sendEmail(
                        receiverEmail: $this->body["email"],
                        receiverName: $this->body["f_name"] . " " . $this->body["l_name"],
                        subject: "Email Verification",
                        params: [
                            "CODE" => $emailOtp
                        ]
                    );

                    $this->pdo->commit();

                    //                    SmsClient::sendSmsToCustomer(customer: $this->body, message: "Your verification code is {$mobileOtp}");
                    return ["customerId" => $customerId];
                } catch (PDOException | Exception $e) {
                    $this->pdo->rollBack();
                    return $e->getMessage();
                }
            } else {
                return ["errors" => $errors];
            }
        } else {
            return ["errors" => $errors];
        }
    }

    public function retryVerifying(int $customerId, string $mode): array|bool
    {
        // check if customer id is valid
        // make sure mode is either email or mobile
        if ($mode !== "email" && $mode !== "mobile") {
            return [
                "message" => "Invalid mode"
            ];
        }

        try {
            $customer = $this->getCustomerById($customerId);
            if ($customer) {
                $query = "UPDATE customer_verification_codes SET {$mode}_otp = :otp WHERE customer_id = :customer_id";
                $statement = $this->pdo->prepare($query);
                $otp = (string)random_int(100000, 999999);
                $statement->bindValue(":otp", $otp);
                $statement->bindValue(":customer_id", $customerId);
                $statement->execute();

                if ($mode === "email") {
                    EmailClient::sendEmail(
                        receiverEmail: $customer->email,
                        receiverName: $customer->f_name . " " . $customer->l_name,
                        subject: "Email Verification",
                        params: [
                            "CODE" => $otp
                        ]
                    );
                } else {
                    SmsClient::sendSmsToCustomer(customer: [
                        "contact_no" => $customer->contact_no,
                        "f_name" => $customer->f_name,
                        "l_name" => $customer->l_name,
                        "email" => $customer->email,
                        "address" => $customer->address,
                    ], message: "Your verification code is {$otp}");
                }

                return true;
            }
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }

        return [
            "message" => "Customer not found"
        ];
    }

    /**
     * @throws Exception
     */
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
                $this->pdo->beginTransaction();
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

                $customerId = $this->pdo->lastInsertId();

                $customerVerificationCodesQuery = "INSERT INTO customer_verification_codes (customer_id,  email_otp) VALUE (:customer_id,  :email_otp)";
                $emailOtp = (string)random_int(100000, 999999);
                //                    $mobileOtp = (string)random_int(100000, 999999);
                $statement = $this->pdo->prepare($customerVerificationCodesQuery);
                $statement->bindValue(":customer_id", $customerId);
                //                    $statement->bindValue(":mobile_otp", $mobileOtp);
                $statement->bindValue(":email_otp", $emailOtp);

                $statement->execute();

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
                var_dump($this->body);
                $statement->bindValue(":vin", $this->body["vin"]);
                $statement->bindValue(":reg_no", $this->body["reg_no"]);
                $statement->bindValue(":engine_no", $this->body["engine_no"]);
                $statement->bindValue(":manufactured_year", $this->body["manufactured_year"]);
                $statement->bindValue(":engine_capacity", $this->body["engine_capacity"]);
                $statement->bindValue(":vehicle_type", $this->body["vehicle_type"]);
                $statement->bindValue(":fuel_type", $this->body["fuel_type"]);
                $statement->bindValue(":transmission_type", $this->body["transmission_type"]);
                $statement->bindValue(":customer_id", $customerId);
                $statement->bindValue(":model", $this->body["model"]);
                $statement->bindValue(":brand", $this->body["brand"]);
                try {
                    $statement->execute();
                    $this->pdo->commit();
                    return true;
                } catch (PDOException $e) {
                    DevOnly::prettyEcho($e->getMessage());
                    $this->pdo->rollBack();
                    exit();
                    return $e->getMessage();
                }
            } else {
                return $errors;
            }
        } else {
            return $errors;
        }
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

    public function getCustomers(
        int|null $count = null,
        int|null $page = 1,
        string $searchTermCustomer = null,
        string $searchTermEmail = null
    ): array {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $whereClause = null;

        if ($searchTermCustomer !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(f_name,' ',l_name) LIKE :search_term_cus" : " WHERE CONCAT(f_name,' ',l_name) LIKE :search_term_cus";
        }

        if ($searchTermEmail !== null) {
            $whereClause = $whereClause ? $whereClause . " AND email LIKE :search_term_email" : " WHERE email LIKE :search_term_email";
        }

        $statement = $this->pdo->prepare(
            "SELECT 
                customer_id as ID,
                CONCAT(f_name, ' ', l_name) as 'Full Name',
                contact_no as 'Contact No',
                address as Address,
                email as Email
            FROM customer
            $whereClause
            ORDER BY customer_id DESC $limitClause $pageClause"
        );

        if ($searchTermCustomer !== null) {
            $statement->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
        }

        if ($searchTermEmail !== null) {
            $statement->bindValue(":search_term_email", "%" . $searchTermEmail . "%", PDO::PARAM_STR);
        }

        try {

            $statement->execute();
            $customers = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $this->pdo->prepare(
                "SELECT COUNT(*) as total FROM customer $whereClause"
            );

            if ($searchTermCustomer !== null) {
                $statement->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
            }

            if ($searchTermEmail !== null) {
                $statement->bindValue(":search_term_email", "%" . $searchTermEmail . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $totalCustomers = $statement->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return [
            "total" => $totalCustomers['total'],
            "customers" => $customers
        ];
    }

    public function setPaymentId(int $customerId, string $paymentId): string|array
    {
        try {
            $query = "UPDATE customer SET payment_id = :payment_id WHERE customer_id = :customer_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':payment_id', $paymentId);
            $statement->bindValue(':customer_id', $customerId);
            $statement->execute();
            return ['message' => 'Payment ID set successfully'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function verifyContactDetails(int $customerId, string $mode, string $otp): bool|array
    {
        if ($mode !== "email" && $mode !== "mobile") {
            return "Invalid mode";
        }
        try {
            $query = "SELECT email FROM customer WHERE customer_id = :customer_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':customer_id', $customerId);
            $statement->execute();
            $customer = $statement->fetchObject();
            if (!$customer) {
                return ["message" => "Customer not found"];
            }

            $query = "SELECT * FROM customer_verification_codes WHERE customer_id = :customer_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':customer_id', $customerId);
            $statement->execute();
            $verificationCodes = $statement->fetchObject();
            if (!$verificationCodes) {
                return ["message" => "Verification code not found"];
            }

            if ($mode === "email") {
                if ($verificationCodes->email_otp !== $otp) {
                    return ["message" => "Invalid OTP"];
                }
                $query = "UPDATE customer SET is_email_verified = 1 WHERE customer_id = :customer_id";
                $disableOTPQuery = "UPDATE customer_verification_codes SET email_otp = NULL WHERE customer_id = :customer_id";
            } else {
                if ($verificationCodes->mobile_otp !== $otp) {
                    return ["message" => "Invalid OTP"];
                }
                $query = "UPDATE customer SET is_phone_verified = 1 WHERE customer_id = :customer_id";
                $disableOTPQuery = "UPDATE customer_verification_codes SET mobile_otp = NULL WHERE customer_id = :customer_id";
            }
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':customer_id', $customerId);
            $statement->execute();

            $statement = $this->pdo->prepare($disableOTPQuery);
            $statement->bindValue(':customer_id', $customerId);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            return ["message" => $e->getMessage()];
        }
    }

    //    validation methods
    private function validateRegisterBody(): array
    {
        $errors = [];

        if (trim($this->body['f_name']) === '') { //remove whitespaces by trim(string)
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

        if (trim($this->body['f_name']) === '') { //remove whitespaces by trim(string)
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

        if (trim($this->body['address']) === '') {
            $errors['address'] = 'Address must not be empty.';
        }

        return $errors;
    }

    public function updateCustomer() : bool|string|array
    {
        $errors = $this->validateUpdateCustomerBody();
        if (empty($errors)) {
            $query = "UPDATE customer SET
                        f_name= :f_name, 
                        l_name= :l_name, 
                        address= :address 
                        WHERE customer_id= :customer_id";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":f_name", $this->body["f_name"]);
            $statement->bindValue(":l_name", $this->body["l_name"]);
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

    public function getTotalCustomers(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM customer");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
