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

    public function getOrders(): array
    {
        return $this->pdo->query(
            "SELECT 
                          DISTINCT(o.order_no) as ID,
                          o.status as Status,
                          CONCAT(c.f_name,' ',c.l_name) as 'Customer Name',
                          c.address as 'Shipping Address',
                          SUM(h.price_at_order * h.quantity) as 'Payment Amount',
                          o.created_at as 'Order Date'
                     FROM `order` o
                          INNER JOIN customer c on o.customer_id = c.customer_id
                          INNER JOIN orderhasproduct h on o.order_no = h.order_no
                          
                     GROUP BY o.order_no, o.created_at
                     ORDER BY o.created_at DESC "


        )->fetchAll(PDO::FETCH_ASSOC);
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
}