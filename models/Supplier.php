<?php

namespace app\models;

use app\core\Database;
use PDO;

class Supplier
{
    private \PDO $pdo;
    private array $body;


    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function  getSuppliers() : array {
        $stmt = $this->pdo->query("SELECT * FROM supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getSuppliersList(): array {

        return $this->pdo->query(
            "SELECT 
                s.supplier_id as ID, 
                s.name as Name, 
                s.address as Address, 
                s.sales_manager as 'Sales Manager', 
                s.email as Email,
                c.contact_no as 'Contact No'

            FROM supplier s
                INNER JOIN suppliercontact c on s.supplier_id = c.supplier_id
            ORDER BY s.supplier_id"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

}