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

    public function getReviews(
        int|null $count = null,
        int|null $page = 1,
        string|null $searchTermProduct = null,
        array $options = [
            'rating' => null,
            'review_date' => null,
        ]
    ): array|string
    {
        $whereClause = null;
        $conditions = [];
        $dateFrom = null;
        $dateTo = null;

        foreach ($options as $option_key => $option_value){
            if($option_value !== null){
                switch ($option_key){
                    case 'rating':
                        switch ($option_value){
                            case 'all':
                                break;
                            case '1star':
                                $conditions[] = "r.rating = 1";
                                break;
                            case '2star':
                                $conditions[] = "r.rating = 2";
                                break;
                            case '3star':
                                $conditions[] = "r.rating = 3";
                                break;
                            case '4star':
                                $conditions[] = "r.rating = 4";
                                break;
                            case '5star':
                                $conditions[] = "r.rating = 5";
                                break;
                        }
                        break;
                    case 'review_date':
                        switch ($option_value){
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
                            case 'Last90':
                                $dateFrom = date('Y-m-d 00:00:00', strtotime('-89 days'));
                                $dateTo = date('Y-m-d 23:59:59');
                                break;

                        }
                        break;
                }
                break;
            }
        }

        if(isset($dateFrom) && isset($dateTo)){
            $conditions[] = "r.created_at BETWEEN :date_from AND :date_to";
        }


        if(!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        if($searchTermProduct !== null){
            $whereClause = $whereClause ? $whereClause . " AND p.name LIKE :search_term_product" : "WHERE p.name LIKE :search_term_product";
        }

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $query = "SELECT 
                        r.text as Review, 
                        r.rating as Rating, 
                        p.name as Product, 
                        CONCAT(c.f_name, ' ', c.l_name) as 'Customer Name',
                        r.created_at as 'Date Posted'
                    FROM review r                  
                        INNER JOIN product p on r.item_code = p.item_code 
                        INNER JOIN customer c on r.customer_id = c.customer_id  
                        $whereClause
                        ORDER BY r.created_at DESC $limitClause $pageClause";

        $statement = $this->pdo->prepare($query);

        if($searchTermProduct !== null){
            $statement->bindValue(':search_term_product', '%' . $searchTermProduct . '%', PDO::PARAM_STR);
        }

        if(isset($dateFrom) && isset($dateTo)){
            $statement->bindValue(':date_from', $dateFrom);
            $statement->bindValue(':date_to', $dateTo);
        }

        try{
            $statement->execute();
            $reviews = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            return $e->getMessage();
        }
        $totalReviews = $this->pdo->query(
            "SELECT COUNT(*) as total FROM review"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            'reviews' => $reviews,
            'total' => $totalReviews['total']
        ];
    }
}