<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use Exception;

use app\core\Request;
use app\core\Response;

class Reviews
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getReviews(): array
    {

        return $this->pdo->query(
            "SELECT 
                        
                        r.text as Review, 
                        r.rating as Rating, 
                        p.name as Product, 
                        CONCAT(c.f_name, ' ', c.l_name) as 'Customer Name',
                        r.created_at as 'Date Posted'
                        

                       

                    FROM review r 
                        
                        INNER JOIN product p on r.item_code = p.item_code 
                        INNER JOIN customer c on r.customer_id = c.customer_id


                    ORDER BY r.created_at DESC"

        )->fetchAll(PDO::FETCH_ASSOC);

    }
}