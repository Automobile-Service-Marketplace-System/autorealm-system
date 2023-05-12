<?php

namespace app\models;

use app\core\Database;
use PDO;

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
}