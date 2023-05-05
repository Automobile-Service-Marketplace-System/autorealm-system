<?php

namespace app\models;

use app\core\Database;
use Exception;
use PDO;
use PDOException;

class Supplier
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getSuppliers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getSuppliersList(
        int|null $count = null,
        int|null $page = 1,
        string $searchTermSupplier = null,
        string $searchTermMail = null,
        array $options = [
                'status' => null,
                'supply_date' => null,
            ]

    ): array|string
    {
        $whereClause = null;
        $conditions = [];
        $dateFrom = null;
        $dateTo = null;

//        print_r($options);

        foreach($options as $option_key => $option_value) {
            if ($option_value !== null) {
                switch($option_key){
                    case 'status':
                        switch ($option_value) {
                            case 'active':
                                $conditions[] = "s.is_discontinued = FALSE";
                                break;
                            case 'discontinued':
                                $conditions[] = "s.is_discontinued = TRUE";
                                break;
                        }
                        break;
                    case "supply_date":
                        switch ($option_value) {
                            case 'all':
                                break;
                            case 'Today':
                                $dateFrom = date('Y-m-d 00:00:00');
                                $dateTo = date('Y-m-d 23:59:59');
                                break;
                            case 'Yesterday':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('yesterday'));
                                $dateTo = date('Y-m-d 23:59:59', strtotime('yesterday'));
                                break;
                            case 'Last7':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('-6 days'));
                                $dateTo = date('Y-m-d 23:59:59');
                                break;
                            case 'Last30':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('-29 days'));
                                $dateTo = date('Y-m-d 23:59:59');
                                break;
                            case 'Last90':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('-89 days'));
                                $dateTo = date('Y-m-d 23:59:59');
                                break;

                        }
                        break;
                }
            }
        }

//        var_dump($dateFrom);

        if(!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        if($searchTermSupplier !== null){
            $whereClause = $whereClause ? $whereClause . " AND s.name LIKE :search_term_sup" :
                                            " WHERE s.name LIKE :search_term_sup AND s.is_discontinued = FALSE";
        }

        if($searchTermMail !== null){
            $whereClause = $whereClause ? $whereClause . " AND s.email LIKE :search_term_mail" :
                                            " WHERE s.email LIKE :search_term_mail AND s.is_discontinued = FALSE";
        }

//       var_dump($whereClause);


        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $query = "SELECT   
                    s.supplier_id as ID,
                    s.name as Name,
                    s.address as Address,
                    s.sales_manager as 'Sales Manager',
                    s.email as Email,
                    s.company_reg_no as 'Registration No'
                    FROM supplier s 
                    $whereClause
                    $limitClause $pageClause";

        $stmt = $this->pdo->prepare($query);

        if($searchTermSupplier !== null){
            $stmt->bindValue(":search_term_sup", "%".$searchTermSupplier."%", PDO::PARAM_STR);
        }

        if($searchTermMail !== null){
            $stmt->bindValue(":search_term_mail", "%".$searchTermMail."%", PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        $supplierList = [];
        foreach ($suppliers as $supplier) {
            $id = $supplier["ID"];

            if(isset($dateFrom) && isset($dateTo)){
                $lastPurchaseReport = $this->pdo->query("SELECT * FROM stockpurchasereport WHERE supplier_id = $id AND date_time BETWEEN '$dateFrom' AND '$dateTo' ORDER BY date_time DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            }else {
                $lastPurchaseReport = $this->pdo->query("SELECT * FROM stockpurchasereport WHERE supplier_id = $id ORDER BY date_time DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            }
            if($lastPurchaseReport) {
                $supplier["Last Purchase Date"] = $lastPurchaseReport["date_time"];
                $supplier["Last Supply Amount"] = $lastPurchaseReport["amount"];
            }
            $supplierList[] = $supplier;

        }
        //get multiple contact numbers for the relevant supplier from suppliercontact table
        foreach ($supplierList as &$supplier) {
            $id = $supplier["ID"];
            $contactNumbers = $this->pdo->query("SELECT contact_no FROM suppliercontact WHERE supplier_id = $id")->fetchAll(PDO::FETCH_COLUMN);
            $supplier["Contact Numbers"] = $contactNumbers;
        }

        $totalSuppliers = $this->pdo->query(
            "SELECT COUNT(*) FROM supplier where is_discontinued = FALSE"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            "suppliers" => $supplierList,
            "total" => $totalSuppliers["COUNT(*)"]
        ];
    }
//"SELECT
//
//                s.supplier_id as ID,
//                s.name as Name,
//                s.address as Address,
//                s.sales_manager as 'Sales Manager',
//                s.email as Email,
//                s.company_reg_no as 'Registration No',
//                s4.`Last Purchase Date` as 'Last Purchase Date',
//                s4.amount as 'Last Supply Amount'
//
//                FROM supplier s LEFT JOIN stockpurchasereport s2 on s.supplier_id = s2.supplier_id
//                                LEFT JOIN ( SELECT s3.supplier_id, s3.amount, MAX(s3.date_time) as 'Last Purchase Date' FROM stockpurchasereport s3 GROUP BY s3.supplier_id)
//                                s4 on s2.supplier_id=s4.supplier_id and s4.`Last Purchase Date`=s2.date_time GROUP BY s.supplier_id ORDER BY s.supplier_id
//
//"
    public function addSuppliers(): bool|array|string
    {
        $errors = $this->validateAddSupplierForm();

        if (empty($errors)) {
            $query = "INSERT INTO supplier 
                (
                 name, company_reg_no, email , address, sales_manager
                ) 
            VALUES 
                (
                :name, :company_reg_no, :email, :address, :sales_manager
                 )";

            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":name", $this->body["name"]);
            $statement->bindValue(":company_reg_no", $this->body["company_reg_no"]);
            $statement->bindValue(":email", $this->body["email"]);
            $statement->bindValue(":address", $this->body["address"]);
            $statement->bindValue(":sales_manager", $this->body["sales_manager"]);

            try {
                $statement->execute();

                $query = "INSERT INTO suppliercontact (supplier_id, contact_no) VALUES (:supplier_id, :contact_no)";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":supplier_id", $this->pdo->lastInsertId());
                $statement->bindValue(":contact_no", $this->body["contact_no_1"]);
                $statement->execute();
                $query2 = "INSERT INTO suppliercontact (supplier_id, contact_no) VALUES (:supplier_id, :contact_no)";
                $statement2 = $this->pdo->prepare($query2);
                $statement2->bindValue(":supplier_id", $this->pdo->lastInsertId());
                $statement2->bindValue(":contact_no", $this->body["contact_no_2"]);
                $statement2->execute();
                return true;

            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }

        return $errors;

    }



    public function updateSupplier(): bool|array|string
    {
        //check for the errors
        $errors = $this->validateUpdateSupplier();
//        $errors = [];

        if (empty($errors)) {
            $query = "UPDATE supplier SET
                name = :name,
                email = :email,
                company_reg_no = :company_reg_no,
                address = :address,
                sales_manager = :sales_manager
                
                WHERE supplier_id = :supplier_id";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":name", $this->body["name"]);
            $statement->bindValue(":email", $this->body["email"]);
            $statement->bindValue(":company_reg_no", $this->body["company_reg_no"]);
            $statement->bindValue(":address", $this->body["address"]);
            $statement->bindValue(":sales_manager", $this->body["sales_manager"]);
            $statement->bindValue(":supplier_id", $this->body["supplier_id"]);

            try {
                $statement->execute();
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return $errors;
        }
    }

    public function deleteSupplierById(int $id):bool|string
    {
        try {
            $query ="UPDATE supplier SET is_discontinued = TRUE WHERE supplier_id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();

            return $statement->rowCount() > 0;
        }
        catch (PDOException $e){
            return "Error deleting Supplier";

        }
    }

    public function getSuppliersOptList(): array|string
    {
        try {
            $query = "SELECT supplier_id, name FROM supplier WHERE is_discontinued = FALSE";
            $statement = $this->pdo->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return "Error getting suppliers list";
        }
    }


    //validations

    private function validateAddSupplierForm(): array
    {
        $errors = [];

        if (trim($this->body["name"]) === "") {
            $errors["name"] = "Name is required";
        } else {
            $query = "SELECT * FROM supplier WHERE name = :name";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":name", $this->body["name"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['name'] = 'Supplier Name already in use.';
            }
        }

        if (trim($this->body["company_reg_no"])==="") {
            $errors["company_reg_no"] = "Business reg no is required";
        } else {
            $query = "SELECT * FROM supplier WHERE company_reg_no = :company_reg_no";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":company_reg_no", $this->body["company_reg_no"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['company_reg_no'] = 'Company Registration Number already in use.';
            }
        }

        if (trim($this->body["email"])==="") {
            $errors["email"] = "Email is required";
        } else {
            $query = "SELECT * FROM supplier WHERE email = :email";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":email", $this->body["email"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['email'] = 'Email already in use.';
            }
        }


        if (empty($this->body["contact_no_1"])) {
            $errors["contact_no"] = "Contact Number is required";
        }
        else if (!preg_match('/^\+947\d{8}$/', $this->body['contact_no_1'])) {
                $errors['contact_no'] = 'Contact number must start with +947 and contain 12 digits.';
            }
        else {
            $query = "SELECT * FROM suppliercontact WHERE contact_no = :contact_no";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":contact_no", $this->body["contact_no_1"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['contact_no_1'] = 'Contact Number already in use.';
            }

            $query2 = "SELECT * FROM suppliercontact WHERE contact_no = :contact_no";
            $statement2 = $this->pdo->prepare($query2);

            $statement2->bindValue(":contact_no", $this->body["contact_no_2"]);
            $statement2->execute();

            if ($statement2->rowCount() > 0) {
                $errors['contact_no_2'] = 'Contact Number already in use.';
            }
        }

        return $errors;
    }

    private function validateUpdateSupplier(): array
    {
        $errors = [];

        if (trim($this->body["name"]) === "") {
            $errors["name"] = "Name is required";
        } else {
            $query = "SELECT * FROM supplier WHERE name = :name AND name != :old_name";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":name", $this->body["name"]);
            $statement->bindValue(":old_name", $this->body["old_name"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['name'] = 'Supplier Name already in use.';
            }
        }

        if (trim($this->body["company_reg_no"])==="") {
            $errors["company_reg_no"] = "Business reg no is required";
        } else {
            $query = "SELECT * FROM supplier WHERE company_reg_no = :company_reg_no AND company_reg_no != :old_company_reg_no";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":company_reg_no", $this->body["company_reg_no"]);
            $statement->bindValue(":old_company_reg_no", $this->body["old_company_reg_no"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['company_reg_no'] = 'Company Registration Number already in use.';
            }
        }

        if (trim($this->body["email"])==="") {
            $errors["email"] = "Email is required";
        } else {
            $query = "SELECT * FROM supplier WHERE email = :email AND email != :old_email";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":email", $this->body["email"]);
            $statement->bindValue(":old_email", $this->body["old_email"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['email'] = 'Email already in use.';
            }

        }

        return $errors;
    }


}