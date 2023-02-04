<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use Exception;

use app\core\Request;
use app\core\Response;

class Order
{
    private PDO $pdo;
    private array $body;

    public function __construct(array $body=[])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getOrders(): array{
        return $this->pdo->query(
            "SELECT 
                          o.order_no as ID,
                          o.status as Status,
                          o.ordered_date_time as 'Order Date',
                          CONCAT(c.f_name,' ',c.l_name) as 'Customer Name',
                          c.address as 'Shipping Address',
                          h.price_at_order as 'Payment Amount'
                     FROM `order` o
                          INNER JOIN customer c on o.customer_id = c.customer_id
                          INNER JOIN orderhasproduct h on o.order_no = h.order_no
                          
                     
                     ORDER BY o.order_no"
                    
                
            
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}