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
                (total_cost) / 100 as 'Total Cost',
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

            $realItemCosts = [];

            for($i = 0; $i < count($itemCosts); $i++) {
                $realItemCosts[] = $itemCosts[$i] - ($itemCosts[$i] * $this->body['product_percentages'][$i])/100;
            }

            $realServiceCosts = [];

            for($i = 0; $i < count($serviceCosts); $i++) {
                $realServiceCosts[] = $serviceCosts[$i] - ($serviceCosts[$i] * $this->body['service_discounts'][$i])/100;
            }

            $totalCost = 0;
            foreach (array_merge($realItemCosts, $realServiceCosts) as $cost) {
                $totalCost += (double) $cost;
            }

//            DevOnly::prettyEcho($totalCost);

            // create the invoice record,
            $statement = $this->pdo->prepare(
                "INSERT INTO invoice 
                        (customer_name, 
                         customer_phone,
                         customer_email,
                         customer_address,
                        total_cost,
                         job_card_id,
                         employee_id
                         ) 
                    VALUES (
                    :customer_name,
                    :customer_phone,
                    :customer_email,
                    :customer_address,
                    :total_cost,
                    :job_card_id,
                    :employee_id
                )"
            );
            $statement->bindValue(":customer_name", $this->body['customer_name'], PDO::PARAM_STR);
            $statement->bindValue(":customer_phone", $this->body['customer_phone'], PDO::PARAM_STR);
            $statement->bindValue(":customer_email", $this->body['customer_email'], PDO::PARAM_STR);
            $statement->bindValue(":customer_address", $this->body['customer_address'], PDO::PARAM_STR);
            $statement->bindValue(":total_cost", $totalCost * 100, PDO::PARAM_STR);
            $statement->bindValue(":employee_id", $employeeId, PDO::PARAM_INT);
            $statement->bindValue(":job_card_id", $this->body['job_id'] ?? null, PDO::PARAM_INT);
            $statement->execute();

            $invoiceId = $this->pdo->lastInsertId();

            $productCount = count($this->body['item_codes']);
            $products = [];

            for ($i = 0; $i < $productCount; $i++) {
                $products[] = [
                    "item_code" => $this->body['item_codes'][$i],
                    "quantity" => $this->body['product_quantities'][$i],
                    "unit_price" => $this->body['product_unit_prices'][$i]*100,
                    "discount" => $this->body['product_percentages'][$i],
                    "product_amount" => $this->body['product_amounts'][$i]*100,
                    "name" => $this->body['product_names'][$i],
                ];
            }
//            DevOnly::prettyEcho($products);

            $service_count = count($this->body['service_codes']);
            $services = [];

            for ($i = 0; $i < $service_count; $i++) {
                $services[] = [
                    "service_code" => $this->body['service_codes'][$i],
                    "service_cost" => $this->body['service_costs'][$i]*100,
                    "discount" => $this->body['service_discounts'][$i],
                    "service_amount" => $this->body['service_amounts'][$i]*100,
                    "name" => $this->body['service_names'][$i],
                ];
            }

//            DevOnly::prettyEcho($services);

            foreach ($products as $product) {
                $statement = $this->pdo->prepare(
                    "INSERT INTO invoice_has_product 
                        (invoice_no, 
                         item_code,
                         quantity,
                         price_at_invoice
                         ) 
                        VALUES (
                        :invoice_no,
                        :item_code,
                        :quantity,
                        :price_at_invoice
                    )"
                );
                $statement->bindValue(":invoice_no", $invoiceId, PDO::PARAM_INT);
                $statement->bindValue(":item_code", $product['item_code'], PDO::PARAM_STR);
                $statement->bindValue(":quantity", $product['quantity'], PDO::PARAM_INT);

                $discountedPrice = $product['unit_price'] - ($product['unit_price'] * ($product['discount'] / 100));
                $statement->bindValue(":price_at_invoice", $discountedPrice, PDO::PARAM_INT);
                $statement->execute();
            }


            foreach ($services as $service) {
                $statement = $this->pdo->prepare(
                    "INSERT INTO invoice_has_services 
                        (invoice_no, 
                         service_code,
                         price_at_invoice
                         ) 
                        VALUES (
                        :invoice_no,
                        :service_code,
                        :price_at_invoice
                    )"
                );
                $statement->bindValue(":invoice_no", $invoiceId, PDO::PARAM_INT);
                $statement->bindValue(":service_code", $service['service_code'], PDO::PARAM_STR);

                $discountedPrice = $service['service_cost'] - ($service['service_cost'] * ($service['discount'] / 100));
                $statement->bindValue(":price_at_invoice", $discountedPrice, PDO::PARAM_INT);
                $statement->execute();
            }




            $this->pdo->commit();
            return true;

        } catch (PDOException|Exception $e) {
//            var_dump($e->getMessage());
            $this->pdo->rollBack();
            return "Failed to begin transaction : " . $e->getMessage();
        }
    }
}