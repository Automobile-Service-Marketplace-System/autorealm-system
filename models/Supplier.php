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
                s4.`Last Purchase Date` as 'Last Purchase Date',
                s4.amount as 'Last Supply Amount'
                
                FROM supplier s LEFT JOIN stockpurchasereport s2 on s.supplier_id = s2.supplier_id 
                                INNER JOIN ( SELECT s3.supplier_id, s3.amount, MAX(s3.date_time) as 'Last Purchase Date' FROM stockpurchasereport s3 GROUP BY s3.supplier_id) 
                                s4 on s2.supplier_id=s4.supplier_id and s4.`Last Purchase Date`=s2.date_time GROUP BY s.supplier_id ORDER BY s.supplier_id 

"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

}