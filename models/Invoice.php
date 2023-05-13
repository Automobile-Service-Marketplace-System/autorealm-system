<?php

namespace app\models;

use app\core\Database;
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


    public function getInvoices(int|null $count = null, int|null $page = 1): array
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $invoices = $this->pdo->query(
            "SELECT
                invoice_no as 'Invoice No',
                customer_name as 'Customer Name',
                total_cost as 'Total Cost',
                type as Type,
                employee_id as 'Employee ID',
                job_card_id as 'JobCard ID'
            FROM 
                invoice
            ORDER BY invoice_no DESC $limitClause $pageClause"
        )->fetchAll(PDO::FETCH_ASSOC);

        $totalInvoices = $this->pdo->query(
            "SELECT COUNT(*) as total FROM invoice"
        )->fetch(PDO::FETCH_ASSOC);

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
}