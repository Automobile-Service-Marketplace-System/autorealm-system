<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO;
use PDOException;
use Exception;

class Invoice
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }


    public function getInvoices(
        int|null $count = null, 
        int|null $page = 1,
        string $searchTermCustomer = null, 
        string $searchTermEmployee = null,): array
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $whereClause = null;

        if ($searchTermCustomer !== null) {
            $whereClause = $whereClause ? $whereClause . " AND customer_name LIKE :search_term_cus" : "WHERE customer_name LIKE :search_term_cus";
        }

        if ($searchTermEmployee !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(e.f_name,' ',e.l_name) LIKE :search_term_emp" : "WHERE CONCAT(e.f_name,' ',e.l_name) LIKE :search_term_emp";
        }

        $statement = $this->pdo->prepare(
            "SELECT
                invoice_no as 'Invoice No',
                customer_name as 'Customer Name',
                total_cost as 'Total Cost',
                type as Type,
                CONCAT(e.f_name,' ',e.l_name) as 'Employee Name',
                job_card_id as 'JobCard ID'
            FROM 
                invoice i
            INNER JOIN employee e ON e.employee_id = i.employee_id
            $whereClause
            ORDER BY invoice_no DESC $limitClause $pageClause"
        );

        if ($searchTermCustomer !== null) {
            $statement->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
        }

        if ($searchTermEmployee !== null) {
            $statement->bindValue(":search_term_emp", "%" . $searchTermEmployee . "%", PDO::PARAM_STR);
        }

        try{

            $statement->execute();
            $invoices = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $this->pdo->prepare(
                "SELECT
                    count(*) as total
                FROM 
                    invoice i
                INNER JOIN employee e ON e.employee_id = i.employee_id
                $whereClause"
            );

            if ($searchTermCustomer !== null) {
                $statement->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
            }

            if ($searchTermEmployee !== null) {
                $statement->bindValue(":search_term_emp", "%" . $searchTermEmployee . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $totalInvoices = $statement->fetch(PDO::FETCH_ASSOC);


        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return [
            "total" => $totalInvoices['total'],
            "invoices" => $invoices
        ];
    }

    public function getInvoiceRevenueData(): array|string
    {
        try {
            $statement = $this->pdo->prepare(
                "SELECT 
                        DATE_FORMAT(i.created_at, '%Y-%m-%d') AS Date,
                        SUM(ihp.quantity * ihp.price_at_invoice)/100 AS InvoiceRevenue
                        FROM `invoice` i
                        JOIN invoice_has_product ihp ON i.invoice_no = ihp.invoice_no
                        GROUP BY Date
                        ORDER BY Date;");
            $statement->execute();
            $revenueData = $statement->fetchAll(PDO::FETCH_ASSOC);
//            var_dump($revenueData);

            return $revenueData;
        } catch (PDOException|Exception $e) {
            return "Failed to get invoice revenue data : " . $e->getMessage();
        }
    }

    public function createInvoice(int $employeeId)
    {
        try {
            $this->pdo->beginTransaction();

            $itemCosts = $this->body['product_amounts'];
            $serviceCosts = $this->body['service_amounts'];

            $totalCost = 0;
            foreach (array_merge($itemCosts, $serviceCosts) as $cost) {
                $totalCost += (double) $cost;
            }

            DevOnly::prettyEcho($totalCost);

            // create the invoice record,
            $statement = $this->pdo->prepare(
                "INSERT INTO invoice 
                        (customer_name, 
                         customer_phone,
                         customer_email,
                         customer_address,
                         total_cost, 
                         type, 
                         employee_id, 
                         job_card_id, 
                         created_at,
                         job_card_id,
                         employee_id
                         ) VALUES 
                (
                 :customer_name,
                    :customer_phone,
                    :customer_email,
                    :customer_address,
                    :total_cost,
                    :type,
                    :employee_id,
                    :job_card_id,
                    :created_at,
                    :job_card_id,
                    :employee_id
                )"
            );

        } catch (PDOException|Exception $e) {
            $this->pdo->rollBack();
            return "Failed to begin transaction : " . $e->getMessage();
        }
    }
}