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
                        
                    FROM service"

        )->fetchAll(PDO::FETCH_ASSOC);

    }

    public function validateRegisterBody():array{
        $errors = [];
        if (trim($this->body['service_name']) === '') {
            $errors['service_name'] = 'Service name must not be empty.';
        } else if (!preg_match('/^[\p{L} ]+$/u', $this->body['service_name'])) {
            $errors['service_name'] = 'Service name must contain only letters.';
        }

        if (trim($this->body['description']) === '') {
            $errors['description'] = 'Description must not be empty.';
        } 

        if(($this->body['price']<=0)){
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

}