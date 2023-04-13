<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO;
use Exception;

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


    public function getSuppliersList(): array
    {

        $suppliers = $this->pdo->query(
            "SELECT 
                
                s.supplier_id as ID,
                s.name as Name,
                s.address as Address,
                s.sales_manager as 'Sales Manager',
                s.email as Email,
                s.company_reg_no as 'Registration No'
                FROM supplier s"
        )->fetchAll(PDO::FETCH_ASSOC);
        $supplierList = [];
        foreach ($suppliers as $supplier) {
            $id = $supplier["ID"];
            $lastPurchaseReport = $this->pdo->query("SELECT * FROM stockpurchasereport WHERE supplier_id = $id ORDER BY date_time DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            $supplier["Last Purchase Date"] = $lastPurchaseReport["date_time"];
            $supplier["Last Supply Amount"] = $lastPurchaseReport["amount"];
            $supplierList[] = $supplier;
        }
        return $supplierList;
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
    public function addSuppliers()
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
                $statement->bindValue(":contact_no", $this->body["contact_no"]);
                $statement->execute();
                return true;

            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }

        return $errors;

    }

    private function validateAddSupplierForm(): array
    {
        $errors = [];

        if (empty($this->body["name"])) {
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

        if (empty($this->body["company_reg_no"])) {
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

        if (empty($this->body["email"])) {
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


        if (empty($this->body["contact_no"])) {
            $errors["contact_no"] = "Contact Number is required";
        } else {
            $query = "SELECT * FROM suppliercontact WHERE contact_no = :contact_no";
            $statement = $this->pdo->prepare($query);

            $statement->bindValue(":contact_no", $this->body["contact_no"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $errors['contact_no'] = 'Contact Number already in use.';
            }
        }

        return $errors;
    }

    public function updateSupplier(): bool|array|string
    {
        //check for the errors
        //$errors = $this->validateAddSupplierForm();
        $errors = [];

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

}