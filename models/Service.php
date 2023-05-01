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

    public function getServices(): array
    {
        return $this->pdo->query(
            "SELECT 
                        servicecode as ID,
                        service_name as Name,
                        description as Description, 
                        price as Price
                    FROM service WHERE is_discontinued = FALSE"
        )->fetchAll(PDO::FETCH_ASSOC);

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
            $statement->bindValue(":price", $this->body["price"]);
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

    public function getServicesForServiceSelector(int $count, int $page, string|null $searchTerm): array|string
    {

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $whereClause = $searchTerm ? " WHERE service_name LIKE :search_term" : "";

        try {
            $query = "SELECT servicecode as Code, service_name as Name, description as Description FROM service 
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