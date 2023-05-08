<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;
use Exception;
use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;

class Service
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getServices(
        int|null $count = null,
        int|null $page = 1,
        string $searchTermName = null,
        string $searchTermCode = null,
        array $options = [
            'serviceStatus' => null,
        ]
        ): array|string
    {

        // var_dump($searchTermName);
        // var_dump($searchTermCode);
        // var_dump($options);

        $whereClause = null;
        $conditions = [];

        foreach ($options as $option_key => $option_value){
            if($option_value !== null){
                switch ($option_key){
                    case 'serviceStatus':
                        switch ($option_value){
                            case "active":
                                $conditions[] = "is_discontinued = FALSE";
                                break;
                            case "discontinued":
                                $conditions[] = "is_discontinued = TRUE";
                        }
                    break;
                }
            }
        }

        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        // var_dump($whereClause);
        
        if ($searchTermName !== null) {
            $whereClause = $whereClause ? $whereClause . " AND service_name LIKE :search_term_name" : " WHERE service_name LIKE :search_term_name";
        }

        if ($searchTermCode !== null) {
            $whereClause = $whereClause ? $whereClause . " AND servicecode LIKE :search_term_code" : " WHERE servicecode LIKE :search_term_code";
        }
        // var_dump($whereClause);

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        

        $query = "SELECT 
                servicecode as ID,
                service_name as Name,
                description as Description, 
                (price / 100) as Price
            FROM service $whereClause $limitClause $pageClause";

        $statement = $this->pdo->prepare($query);

        if($searchTermName !== null){
            $statement->bindValue(":search_term_name", "%" . $searchTermName . "%", PDO::PARAM_STR);
        }

        if($searchTermCode !== null){
            $statement->bindValue(":search_term_code", "%" . $searchTermCode . "%", PDO::PARAM_STR);
        }

        try{
            $statement->execute();
            $services = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $statement = $this->pdo->prepare(
                "SELECT COUNT(*) as total FROM service $whereClause"
            );

            if($searchTermName !== null){
                $statement->bindValue(":search_term_name", "%" . $searchTermName . "%", PDO::PARAM_STR);
            }
    
            if($searchTermCode !== null){
                $statement->bindValue(":search_term_code", "%" . $searchTermCode . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $totalServices = $statement->fetch(mode: PDO::FETCH_ASSOC);

            return [
                "services" => $services,
                 "total" => $totalServices['total']
            ];
            
        }
        catch (PDOException $e) {
            var_dump("there is an error");
            return $e->getMessage();
        }

    } 


    public function validateRegisterBody(): array
    {
        $errors = [];
        if (trim($this->body['service_name']) === '') {
            $errors['service_name'] = 'Service name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['service_name'])) {
            $errors['service_name'] = 'Service name must contain only letters.';
        }

        if (trim($this->body['description']) === '') {
            $errors['description'] = 'Description must not be empty.';
        }

        if (($this->body['price'] <= 0)) {
            $errors['price'] = 'Price must not be empty or negative values.';
        }
        return $errors;
    }


    public function addServices(): bool|array|string
    {
        $errors = $this->validateRegisterBody();

        if (empty($errors)) {
            $query = "INSERT INTO service 
                    (
                        price, service_name, description 
                    ) 
                 
                    VALUES 
                    (
                        :price, :service_name, :description
                    )";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":price", $this->body["price"]*100);
            $statement->bindValue(":service_name", $this->body["service_name"]);
            $statement->bindValue(":description", $this->body["description"]);

            try {
                $statement->execute();
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }

        } else {
            return $errors;
        }
    }

    public function updateServices(): bool|array|string
    {
        $errors = $this->validateRegisterBody();
        if (empty($errors)) {
            $query = "UPDATE service SET 
                        price = :price, 
                        service_name = :service_name, 
                        description = :description 
                    WHERE servicecode = :servicecode";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":price", $this->body["price"]);
            $statement->bindValue(":service_name", $this->body["service_name"]);
            $statement->bindValue(":description", $this->body["description"]);
            $statement->bindvalue(":servicecode", $this->body["servicecode"]);

            try {
                $statement->execute();
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }

        } else {
            return $errors;
        }
    }

    public function deleteServiceById(int $code): bool|string
    {
        var_dump($code);
        try {
            $query = "UPDATE service SET is_discontinued = TRUE WHERE servicecode = :code";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":code", $code);
            $statement->execute();
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getServicesForServiceSelector(int|null $count, int|null $page, string|null $searchTerm = null): array|string
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $whereClause = $searchTerm ? " WHERE service_name LIKE :search_term" : "";



        try {
            $query = "SELECT servicecode as Code, service_name as Name, description as Description, (price / 100) as Cost FROM service 
                        $whereClause 
                        ORDER BY servicecode $limitClause $pageClause";

            $statement = $this->pdo->prepare($query);

            if ($searchTerm !== null) {
                $statement->bindValue(":search_term", "%" . $searchTerm . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $services = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $statement = $this->pdo->prepare(
                "SELECT COUNT(*) as total FROM service $whereClause"
            );

            if ($searchTerm !== null) {
                $statement->bindValue(":search_term", "%" . $searchTerm . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $totalServices = $statement->fetch(mode: PDO::FETCH_ASSOC);
            return [
                "services" => $services,
                "total" => $totalServices['total']
            ];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}