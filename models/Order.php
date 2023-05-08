<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO;
use PDOException;
use Exception;


class Order
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getOrders(
        int|null $count = null,
        int|null $page = 1,
        string   $searchTermCustomer = null,
        string   $searchTermOrder = null,
        array    $options = [
            'status' => null,
            'order_date' => null,
        ]
    ): array|string

    {
//        DevOnly::prettyEcho($options);
//        var_dump($searchTermCustomer);
//        var_dump($searchTermOrder);
        //number of rows

        $whereClause = null;
        $conditions = [];
        $dateFrom = null;
        $dateTo = null;

        foreach ($options as $option_key => $option_value) {
            if ($option_value !== null) {
                switch ($option_key) {
                    case "status":
                        switch ($option_value) {
                            case "all":
                                $conditions[] = "o.status != 'Unpaid'";
                                break;
                            case "Not Prepared":
                                $conditions[] = "o.status = 'Paid'";
                                break;
                            case "Prepared":
                                $conditions[] = "o.status = 'Prepared'";
                                break;
                            case "Delivery":
                                $conditions[] = "o.status = 'Delivery'";
                                break;
                            case "CourierConfirmed":
                                $conditions[] = "o.status = 'CourierConfirmed'";
                                break;
                            case "CustomerConfirmed":
                                $conditions[] = "o.status = 'CustomerConfirmed'";
                                break;

                        }
                        break;
                    case "order_date":
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
                            case 'Last90Days':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('-89 days'));
                                $dateTo = date('Y-m-d 23:59:59');
                                break;

                        }
                        break;

                }
            }
        }

        if(isset($dateTo) && isset($dateFrom)){
            $conditions[] = "o.created_at BETWEEN :dateFrom AND :dateTo";
        }

        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

//        DevOnly::prettyEcho($whereClause);

        if ($searchTermCustomer !== null) {
            $whereClause = $whereClause ? $whereClause . " AND CONCAT(c.f_name,' ',c.l_name) LIKE :search_term_cus" : "WHERE c.f_name LIKE :search_term_cus AND o.status != 'Unpaid'";
        }

        if ($searchTermOrder !== null) {
            $whereClause = $whereClause ? $whereClause . " AND o.order_no LIKE :search_term_id" : "WHERE o.order_no LIKE :search_term_id AND o.status != 'Unpaid'";
        }


//        DevOnly::prettyEcho($whereClause);

        $limitClause = $count ? "LIMIT $count" : "";
        //starting point of retrieving rows
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $query =
            "SELECT 
                          DISTINCT(o.order_no) as ID,
                          o.status as Status,
                          c.customer_id as 'CustomerID',
                          CONCAT(c.f_name,' ',c.l_name) as 'Customer Name',
                          c.address as 'Shipping Address',
                          SUM(h.price_at_order * h.quantity) as 'Payment Amount',
                          o.created_at as 'Order Date'
                     FROM `order` o
                          INNER JOIN customer c on o.customer_id = c.customer_id
                          INNER JOIN orderhasproduct h on o.order_no = h.order_no
                    
                     $whereClause
                     
                     GROUP BY o.order_no, o.created_at
                     ORDER BY o.created_at DESC $limitClause $pageClause";

        $stmt = $this->pdo->prepare($query);

        if ($searchTermCustomer !== null) {
            $stmt->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
        }

        if ($searchTermOrder !== null) {
            $stmt->bindValue(":search_term_id", "%" . $searchTermOrder . "%", PDO::PARAM_STR);
        }

        if(isset($dateTo) && isset($dateFrom)){
            $stmt->bindValue(":dateFrom", $dateFrom);
            $stmt->bindValue(":dateTo", $dateTo);
        }

        try {
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

          //totQuery to get the total orders when filter is applied

            $totQuery =
                "SELECT 
                          COUNT(DISTINCT(o.order_no)) as total
                     FROM `order` o
                          INNER JOIN customer c on o.customer_id = c.customer_id
                          INNER JOIN orderhasproduct h on o.order_no = h.order_no
                    
                     $whereClause";

            $totStmt = $this->pdo->prepare($totQuery);

            if ($searchTermCustomer !== null) {
                $totStmt->bindValue(":search_term_cus", "%" . $searchTermCustomer . "%", PDO::PARAM_STR);
            }

            if ($searchTermOrder !== null) {
                $totStmt->bindValue(":search_term_id", "%" . $searchTermOrder . "%", PDO::PARAM_STR);
            }

            if(isset($dateTo) && isset($dateFrom)){
                $totStmt->bindValue(":dateFrom", $dateFrom);
                $totStmt->bindValue(":dateTo", $dateTo);
            }

            $totStmt->execute();
            $totalOrders = $totStmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
//
//        $totalOrders = $this->pdo->query(
//            "SELECT COUNT(*) as total FROM `order` WHERE status != 'Unpaid'  "
//        )->fetch(PDO::FETCH_ASSOC);

        return [
            "orders" => $orders,
            "total" => $totalOrders['total'],
        ];
    }


    public function getOrdersForCustomer(int $customerId, int $page, int $limit, string $status): array|string
    {
        $limitClause = $limit ? "LIMIT $limit" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $limit : "";
        $whereClause = $status !== "All" ? "AND status = '$status'" : "";


        $stmt = $this->pdo->prepare("SELECT * FROM `order` WHERE customer_id = :customer_id $whereClause ORDER BY created_at DESC $limitClause $pageClause");
        $stmt->bindValue(":customer_id", $customerId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            return [];
        }


        $orders = [];
        foreach ($results as $result) {
            $orderId = $result['order_no'];
            $status = $result['status'];
            $orderDate = $result['created_at'];

            $orders[$orderId] = [
                "Order ID" => $orderId,
                "Status" => $status,
                "Order Date" => $orderDate,
                "Items" => []
            ];

            $stmt = $this->pdo->prepare("SELECT  
                                                (ohp.price_at_order / 100) as Price,
                                                p.name as 'Product Name',
                                                p.item_code as 'Product Code',
                                                ohp.quantity as 'Quantity'
                                            FROM `order` o 
                                            INNER JOIN `orderhasproduct` ohp
                                            ON o.order_no = ohp.order_no 
                                            INNER JOIN `product` p
                                            ON ohp.item_code = p.item_code WHERE o.order_no = :order_no");
            $stmt->bindValue(":order_no", $orderId);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$items) {
                return [];
            }
            foreach ($items as $item) {
                $orders[$orderId]["Items"][] = [
                    'Product Name' => $item['Product Name'],
                    'Item Code' => $item['Product Code'],
                    'Quantity' => $item['Quantity'],
                    'Price' => (float)$item['Price'],
                    'Total' => $item['Quantity'] * $item['Price']
                ];
            }
        }

        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM `order` WHERE customer_id = :customer_id");
        $stmt->bindValue(":customer_id", $customerId);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];


        return [
            "orders" => $orders,
            "total" => $total
        ];
    }


    public function createOrder(int $customerId): array|string
    {
        // get the cart of the customer
        $cartModel = new ShoppingCart();
        $cartItems = $cartModel->getCartItemsByCustomerId($customerId);
        if (is_string($cartItems)) {
            return $cartItems;
        }

        try {

            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare(
                "INSERT INTO `order` 
                    (  
                     customer_id,
                     status
                    ) 
                    VALUE 
                     (
                        :customer_id,
                        'Not Prepared'
                     )"
            );
            $stmt->bindValue(":customer_id", $customerId);
            $stmt->execute();
            $orderId = $this->pdo->lastInsertId();


            foreach ($cartItems as $cartItem) {
                $itemCode = $cartItem['item_code'];
                $quantity = $cartItem['amount'];
                $priceAtOrder = $cartItem['price'];
                $stmt = $this->pdo->prepare(
                    "INSERT INTO orderhasproduct (item_code, order_no, quantity, price_at_order) VALUE  (:item_code, :order_no, :quantity, :price_at_order)"
                );
                $stmt->bindValue(":item_code", $itemCode);
                $stmt->bindValue(":order_no", $orderId);
                $stmt->bindValue(":quantity", $quantity);
                $stmt->bindValue(":price_at_order", $priceAtOrder);
                $stmt->execute();
            }

            $this->pdo->commit();

            return [
                'message' => 'Order created successfully.',
            ];
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return "Order creation failed : " . $e->getMessage();
        }

    }

    public function getOrderById(int $orderId): array|string
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `order` WHERE order_no = :order_no");
        $stmt->bindValue(":order_no", $orderId);
        $stmt->execute();
        $orderDetails = $stmt->fetch(PDO::FETCH_ASSOC);

//to get product details
        $stmt = $this->pdo->prepare("SELECT  
                                                (ohp.price_at_order / 100) as Price,
                                                p.name as 'Product Name',
                                                p.item_code as 'Product Code',
                                                ohp.quantity as 'Quantity'
                                            FROM `order` o 
                                            INNER JOIN `orderhasproduct` ohp
                                            ON o.order_no = ohp.order_no 
                                            INNER JOIN `product` p
                                            ON ohp.item_code = p.item_code WHERE o.order_no = :order_no");
        $stmt->bindValue(":order_no", $orderId);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $orderDetails["Items"][] = [
                'Product Name' => $item['Product Name'],
                'Item Code' => $item['Product Code'],
                'Quantity' => $item['Quantity'],
                'Price' => (float)$item['Price'],
                'Product Total' => $item['Quantity'] * $item['Price']
            ];
        }

        $customerId = $orderDetails['customer_id'];

        //Get Customer details and insert it into the order details

        $stmt = $this->pdo->prepare("SELECT 
                                   CONCAT(f_name, ' ', l_name) as 'customer_name',
                                   contact_no,
                                   address,
                                   email 
                                    FROM `customer` WHERE customer_id = :customer_id");
        $stmt->bindValue(":customer_id", $customerId);
        $stmt->execute();
        $customerDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderDetails['cusDetails'] = $customerDetails;


        $employeeId = $orderDetails['employee_id'];
        //get employee details and insert it into the order details
        $stmt = $this->pdo->prepare("SELECT 
                                   CONCAT(f_name, ' ', l_name) as 'employee_name',
                                   contact_no
                                    FROM `employee` WHERE employee_id = :employee_id");
        $stmt->bindValue(":employee_id", $employeeId);
        $stmt->execute();
        $employeeDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderDetails['empDetails'] = $employeeDetails;

        return $orderDetails;
    }

    public function updateOrderStatus(int $orderNo, string $mode, string $status): bool|string|array
    {
        $errors = $this->validateUpdateOrderStatusBody([
            'mode' => $mode,
            'status' => $status
        ]);
        if (!empty($errors)) {
            return $errors;
        }
        $dateTime = $status ? date("Y-m-d H:i:s") : "NULL";
        $columnName = "";
        switch ($mode) {
            case  "Prepared":
                $columnName = "prepared_date_time";
                break;
            case "Delivery":
                $columnName = "shipped_date_time";
                break;
            case "CourierConfirmed":
                $columnName = "courier_confirmed_date_time";
                break;
        }
        $mode = $status ? $mode : $this->getPreviousStatus($mode);
        try {
            $stmt = $this->pdo->prepare("UPDATE `order` SET $columnName = '$dateTime', status = '$mode' WHERE order_no = :order_no");
            $stmt->bindValue(":order_no", $orderNo);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Order status update failed : " . $e->getMessage();
        }
    }


    private function getPreviousStatus(string $status): string
    {
        return match ($status) {
            "Delivery" => "Prepared",
            "CourierConfirmed" => "Delivery",
            default => "Paid",
        };
    }


    private function validateUpdateOrderStatusBody(array $body): array
    {
        $errors = [];
        if (!isset($body['mode'])) {
            $errors[] = "Mode is required.";
        }

        if ($body['mode'] !== "Prepared" && $body['mode'] !== "Delivery" && $body['mode'] !== "CourierConfirmed") {
            $errors[] = "Invalid mode.";
        }

        if (!isset($body['status'])) {
            $errors[] = "Status is required.";
        }
        return $errors;
    }

    public function getOrderRevenueData() : array | string
    {
        try {
            $statement =  $this->pdo->prepare(
                "SELECT 
                        DATE_FORMAT(o.ordered_date_time, '%Y-%m-%d') AS ordered_year_month,
                        SUM(ohp.quantity * ohp.price_at_order) AS revenue
                        FROM `order` o
                        JOIN orderhasproduct ohp ON o.order_no = ohp.order_no
                        GROUP BY ordered_year_month
                        ORDER BY ordered_year_month;");
            $statement->execute();
            $revenueData =  $statement->fetchAll(PDO::FETCH_ASSOC);

            // query to get order count grouped by year and month
            $statement =  $this->pdo->prepare(
                "SELECT 
                        DATE_FORMAT(o.ordered_date_time, '%Y-%m-%d') AS ordered_year_month,
                        COUNT(o.order_no) AS order_count
                        FROM `order` o
                        GROUP BY ordered_year_month
                        ORDER BY ordered_year_month;");
            $statement->execute();
            $orderCountData =  $statement->fetchAll(PDO::FETCH_ASSOC);
            return [
                'revenueData' => $revenueData,
                'orderCountData' => $orderCountData
            ];
        } catch (PDOException | Exception $e) {
            return "Failed to get order revenue data : " . $e->getMessage();
        }
    }


}