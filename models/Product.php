<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO;
use PDOException;
use Exception;

use app\core\Request;
use app\core\Response;
use app\utils\FSUploader;


class Product
{
    private PDO $pdo;
    private array $body;


    public function __construct(array $body = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $body;
    }

    public function getProducts(int|null $count = null, int|null $page = 1): array|string
    {
        //if there are no parameters, set empty string
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $query = "SELECT 
    
                        p.item_code as ID, 
                        p.name as Name, 
                        c.name as Category,
                        c.category_id as CategoryID,
                        m.model_name as Model,
                        m.model_id as ModelID,
                        b.brand_name as Brand,
                        b.brand_id as BrandID,
                        ROUND(p.price/100, 2) as 'Price (LKR)', 
                        p.image as Image,
                        p.description as Description,
                        p.quantity as Quantity,
                        p.product_type as Type
                        

                    FROM product p 
                        
                        INNER JOIN model m on p.model_id = m.model_id 
                        INNER JOIN brand b on p.brand_id = b.brand_id 
                        INNER JOIN category c on p.category_id = c.category_id
                     
                    WHERE p.is_discontinued = FALSE
                    ORDER BY p.item_code $limitClause $pageClause";

        $result = $this->pdo->prepare($query);
        try {
            $result->execute();

            $totalProducts = $this->pdo->query(
                "SELECT COUNT(*) as total FROM product WHERE is_discontinued = FALSE"
            )->fetch(PDO::FETCH_ASSOC);
            return [
              "products" => $result->fetchAll(PDO::FETCH_ASSOC),
              "total" => $totalProducts['total']
            ];
        } catch (PDOException $e) {
            return $e->getMessage();
        }



    }

    public function getProductsForHomePage(int|null $count = null, int|null $page = 1): array
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $products = $this->pdo->query(
            "SELECT 
                        p.item_code as ID, 
                        p.name as Name, 
                        c.name as Category,
                        m.model_name as Model,
                        b.brand_name as Brand,
                        ROUND(p.price/100, 2) as 'Price (LKR)', 
                        p.quantity as Quantity,
                        p.image as Image

                    FROM product p 
                        
                        INNER JOIN model m on p.model_id = m.model_id 
                        INNER JOIN brand b on p.brand_id = b.brand_id 
                        INNER JOIN category c on p.category_id = c.category_id
            
                    WHERE  p.quantity > 0 ORDER BY p.item_code $limitClause $pageClause"

        )->fetchAll(PDO::FETCH_ASSOC);

        $totalProducts = $this->pdo->query(
            "SELECT COUNT(*) as total FROM product WHERE quantity > 0"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            "products" => $products,
            "total" => $totalProducts['total']
        ];
    }



    public function addProducts(): bool|array|string
    {
        $errors = $this->validateAddProducts();
        if (empty($errors)) {
            try {
                $imageUrls = FSUploader::upload(multiple: true, innerDir: "products/");
                $imagesAsJSON = json_encode($imageUrls);
            } catch (Exception $e) {
                $errors["image"] = $e->getMessage();
            }
            if (empty($errors)) {
                $query = "INSERT INTO product 
                    (
                        name, category_id,product_type, brand_id, model_id, description, price, quantity,image
                    ) 
                 
                    VALUES 
                    (
                        :name, :category_id, :product_type, :brand_id, :model_id, :description, :price, :quantity, :image
                    )";
                //for product table
                $statement = $this->pdo->prepare($query);
                $statement->bindValue("name", $this->body["name"]);
                $statement->bindValue(":category_id", $this->body["category_id"]);
                $statement->bindValue(":product_type", $this->body["product_type"]);
                $statement->bindValue(":brand_id", $this->body["brand_id"]);
                $statement->bindValue(":model_id", $this->body["model_id"]);
                $statement->bindValue(":description", $this->body["description"]);
                $statement->bindValue(":price", $this->body["selling_price"] * 100);
                $statement->bindValue(":quantity", $this->body["quantity"]);
                $statement->bindValue(":image", $imagesAsJSON ?? json_encode(["/images/placeholders/product-image-placeholder.jpg", "/images/placeholders/product-image-placeholder.jpg", "/images/placeholders/product-image-placeholder.jpg"]));

                try {
                    $statement->execute();

                    $query = "INSERT INTO stockpurchasereport 
                    (
                       item_code, date_time, supplier_id, unit_price, amount
                    ) 
                 
                    VALUES 
                    (
                      :item_code, :date_time, :supplier_id, :unit_price, :amount 
                    )";

                    $statement = $this->pdo->prepare($query);
                    $statement->bindValue(":item_code", $this->pdo->lastInsertId());
                    $statement->bindValue(":date_time", $this->body["date_time"]);
                    $statement->bindValue(":supplier_id", $this->body["supplier_id"]);
                    $statement->bindValue(":unit_price", $this->body["unit_price"] * 100);
                    $statement->bindValue(":amount", $this->body["quantity"]);

                    try {
                        $statement->execute();
                        return true;
                    } catch (\PDOException $e) {
                        return $e->getMessage();
                    }

                } catch (Exception $e) {
                    return $e->getMessage();
                }

            } else {
                return $errors;
            }

        } else {
            return $errors;
        }

    }


    public function updateProduct(): bool|array|string
    {
        //check for the errors
//        return json_encode($this->body);
        $errors = $this->validateUpdateProductBody();
//        $errors = [];

//        echo json_encode($errors);
//        exit();
//      $errors = [];
        if (empty($errors)) {
            //            try {
//                $imageUrls = FSUploader::upload(multiple: true, innerDir: "products/");
//                $imagesAsJSON = json_encode($imageUrls);
//            } catch (Exception $e) {
//                $errors["image"] = $e->getMessage();
//            }
            if (empty($errors)) {
                $query = "UPDATE product SET 
                    name = :name, 
                    category_id = :category_id, 
                    product_type = :product_type, 
                    brand_id = :brand_id, 
                    model_id = :model_id, 
                    description = :description, 
                    price = :price 
                   
                    WHERE item_code = :item_code";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":name", $this->body["name"]);
                $statement->bindValue(":category_id", $this->body["category_id"]);
                $statement->bindValue(":product_type", $this->body["product_type"]);
                $statement->bindValue(":brand_id", $this->body["brand_id"]);
                $statement->bindValue(":model_id", $this->body["model_id"]);
                $statement->bindValue(":description", $this->body["description"]);
                $statement->bindValue(":price", $this->body["selling_price"] * 100);
                $statement->bindValue(":item_code", $this->body["item_code"]);

                //$statement->bindValue(":image", $imagesAsJSON ?? json_encode(["/images/placeholders/product-image-placeholder.jpg", "/images/placeholders/product-image-placeholder.jpg", "/images/placeholders/product-image-placeholder.jpg"]));
                try {
                    $statement->execute();
                    return true;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return $errors;
            }
        }
        return $errors;
    }

    public function deleteProductById(int $id): bool|string
    {
        try {
            $query = "UPDATE product SET is_discontinued = TRUE WHERE item_code = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error deleting product";
        }
    }

    public function restockProduct(): bool|array|string
    {
//        $errors = [];
        $errors = $this->validateRestock();

        $dateTimeStamp = date("Y-m-d H:i:s");
        if (empty($errors)) {
            $query = "INSERT INTO stockpurchasereport
                       (
                            item_code, date_time, supplier_id, unit_price ,amount
                        )
                        VALUES 
                        (
                            :product_id, :sup_date, :supplier_id, :unit_price, :stock_quantity
                        )";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":product_id", $this->body["product_id"]);
            $statement->bindValue(":sup_date", $this->body["sup_date"]);
            $statement->bindValue(":supplier_id", $this->body["supplier_id"]);
            $statement->bindValue(":unit_price", $this->body["unit_price"] * 100);
            $statement->bindValue(":stock_quantity", $this->body["stock_quantity"]);

            try {
                $statement->execute();

                $query = "UPDATE product SET quantity = quantity + :stock_quantity WHERE item_code = :product_id";
                $statement = $this->pdo->prepare($query);
                $statement->bindValue(":stock_quantity", $this->body["stock_quantity"]);
                $statement->bindValue(":product_id", $this->body["product_id"]);
                $statement->execute();
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $errors;
    }
    /**
     * @param int|null $count
     * @param int|null $page
     * @param array $options
     * @param string|null $searchTerm
     * @return array
     */
    public function getProductsForProductSelector(
        int|null $count = null,
        int|null $page = 1,
        array $options = [
            "category_id" => null,
            "brand_id" => null,
            "model_id" => null,
        ],
        string|null $searchTerm = null
    ): array|string {

        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";
        $whereClause = "";
        $conditions = [];
        $values = [];

        foreach ($options as $option_key => $option_value) {
            if ($option_value) {
                $conditions[] = "p.$option_key = :$option_key";
                $values[] = $option_value;
            }
        }

        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(" AND ", $conditions);
        }

        if ($searchTerm !== null) {
            $whereClause = $whereClause ? $whereClause . " AND p.name LIKE :search_term" : " WHERE p.name LIKE :search_term";
        }

        try {
            $query = "SELECT 
                        p.item_code as ID, 
                        p.name as Name, 
                        c.name as Category,
                        m.model_name as Model,
                        b.brand_name as Brand,
                        ROUND(p.price/100, 2) as 'Price (LKR)', 
                        p.quantity as Quantity,
                        p.image as Image

                    FROM product p 
                        
                        INNER JOIN model m on p.model_id = m.model_id 
                        INNER JOIN brand b on p.brand_id = b.brand_id 
                        INNER JOIN category c on p.category_id = c.category_id
            
                $whereClause ORDER BY p.item_code $limitClause $pageClause";

            $statement = $this->pdo->prepare($query);

            foreach ($options as $option_key => $option_value) {
                if ($option_value) {
                    $statement->bindValue(":$option_key", $option_value);
                }
            }

            if ($searchTerm !== null) {
                $statement->bindValue(":search_term", "%" . $searchTerm . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $products = $statement->fetchAll(mode: PDO::FETCH_ASSOC);

            $statement = $this->pdo->prepare(
                "SELECT COUNT(*) as total FROM product p $whereClause"
            );

            foreach ($options as $option_key => $option_value) {
                if ($option_value) {
                    $statement->bindValue(":$option_key", $option_value);
                }
            }

            if ($searchTerm !== null) {
                $statement->bindValue(":search_term", "%" . $searchTerm . "%", PDO::PARAM_STR);
            }

            $statement->execute();
            $totalProducts = $statement->fetch(mode: PDO::FETCH_ASSOC);
            return [
                "products" => $products,
                "total" => $totalProducts['total']
            ];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    // validations

    private function validateUpdateProductBody(): array
    {
        $errors = [];
        if(trim($this->body["name"] === "")){
            $errors['name'] = 'Name must not be empty';
        }else{
            $query = "SELECT * FROM product WHERE name = :name AND name != :old_name";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":name" , $this->body["name"]);
            $statement->bindValue(":old_name", $this->body["old_name"]);
            $statement->execute();

            $product = $statement->fetch();
            if ($statement->rowCount() > 0) {
                $errors['name'] = "Product name already exists";
            }
        }

        if (trim($this->body['selling_price']) === "") {
            $errors['selling_price'] = "Price must not be empty";
        } else if ($this->body['selling_price'] == 0) {
            $errors['selling_price'] = "Price can not be a zero";
        } else if ($this->body['selling_price'] < 0){
            $errors['selling_price'] = "Price can not be negative";
        }

        return $errors;

    }



    private function validateAddProducts(): array
    {
        $errors = [];

        if (trim($this->body['name']) === "") {
            $errors['name'] = "Product name must not be empty";
        } else {
            $query = "SELECT * FROM product WHERE lower(name) = lower(:name)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":name", $this->body['name']);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $errors['name'] = "Product name already exists";
            }
        }

        if (trim($this->body['selling_price']) === "") {
            $errors['selling_price'] = "Price must not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['selling_price'])) {
            $errors['selling_price'] = "Price can not be a negative number";
        }

        if (trim($this->body['quantity']) === "") {
            $errors['quantity'] = "Quantity not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['quantity'])) {
            $errors['quantity'] = "Quantity must be a positive";
        }

        if (trim($this->body['unit_price']) === "") {
            $errors['unit_price'] = "Price must not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['unit_price'])) {
            $errors['unit_price'] = "Price must be a positive";
        }

        return $errors;
    }

    private function validateRestock(): array
    {
        $errors = [];

        if (trim($this->body['stock_quantity']) === "") {
            $errors['stock_quantity'] = "Quantity not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['stock_quantity'])) {
            $errors['stock_quantity'] = "Quantity must be a positive";
        }

        if(trim($this->body['unit_price']) === "") {
            $errors['unit_price'] = "Price must not be empty";
        }else if($this->body['unit_price'] < 0){
            $errors['unit_price'] = "Price can not be a negative";
        }


        return $errors;
    }
}