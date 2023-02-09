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

    public function getInvoices(): array
    {

        return $this->pdo->query("
            SELECT
            invoice_no as 'Invoice No',
            customer_name as 'Customer Name',
            total_cost as 'Total Cost',
            type as Type,
            employee_id as 'Employee ID',
            job_card_id as 'JobCard ID'
            FROM invoice"
        )->fetchAll(PDO::FETCH_ASSOC);

    }
}