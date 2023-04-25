<?php

namespace app\models;

use app\core\Database;
use PDO, Exception;
use PDOException;

class ShoppingCart
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }

    public function addToCart(int $customerId, int $itemCode, int $amount): bool|string|array|int
    {
        try {
            $query = "SELECT * FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // if cart does not exist, create one
            if (empty($cart)) {
                $query = "INSERT INTO cart (customer_id) VALUES (:customer_id)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['customer_id' => $customerId]);
                $cartId = $this->pdo->lastInsertId();
            } else {
                $cartId = $cart[0]['cart_id'];
            }

            $query = "SELECT * FROM cart_has_product WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cartId, 'item_code' => $itemCode]);
            $cartHasProduct = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // if item is already in cart, update quantity
            if (!empty($cartHasProduct)) {
                $query = "UPDATE cart_has_product SET quantity = quantity + :quantity WHERE cart_id = :cart_id AND item_code = :item_code";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['cart_id' => $cartId, 'item_code' => $itemCode, 'quantity' => $amount]);
                // return the new quantity
                return $cartHasProduct[0]['quantity'] + $amount;
            }
            $query = "INSERT INTO cart_has_product (cart_id, item_code, quantity) VALUES  (:cart_id, :item_code, :quantity)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cartId, 'item_code' => $itemCode, 'quantity' => $amount]);
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCartItemsByCustomerId(int $customerId): array|string
    {
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return [];
            }
            $query = "SELECT * FROM cart_has_product WHERE cart_id = :cart_id ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id']]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItems)) {
                return [];
            }
            $cartItemsWithProductDetails = [];
            foreach ($cartItems as $cartItem) {
                $query = "SELECT * FROM product WHERE item_code = :item_code";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['item_code' => $cartItem['item_code']]);
                $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (empty($product)) {
                    return "Product not found";
                }
                $cartItemsWithProductDetails[] = [
                    "name" => $product[0]['name'],
                    "image" => $product[0]['image'],
                    "price" => $product[0]['price'],
                    "amount" => $cartItem['quantity'],
                    "availableAmount" => $product[0]['quantity'],
                    "item_code" => $cartItem['item_code']
                ];

            }
            return $cartItemsWithProductDetails;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function changeCartItemAmount(int $customerId, int $itemCode, int $by = 1): int|string|array
    {
        // check if the cart exists
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return ["error" => "Cart not found"];
            }
            // check if the item is in the cart
            $query = "SELECT * FROM cart_has_product WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id'], 'item_code' => $itemCode]);
            $cartItem = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItem)) {
                return ["error" => "Item not in cart"];
            }
            // check if the item is available
            $query = "SELECT quantity FROM product WHERE item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['item_code' => $itemCode]);
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($product)) {
                return ["error" => "Product not found"];
            }

            $newAmount = $cartItem[0]['quantity'] + $by;
            // update amount
            $query = "UPDATE cart_has_product SET quantity = :quantity WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['quantity' => $newAmount, 'cart_id' => $cart[0]['cart_id'], 'item_code' => $itemCode]);


            // get the new amount
            $query = "SELECT quantity FROM cart_has_product WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id'], 'item_code' => $itemCode]);
            $cartItem = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItem)) {
                return ["error" => "Item not in cart"];
            }
            return (int)$cartItem[0]['quantity'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function deleteItemFromCart(int $customerId, int $itemCode): array|bool|string
    {
        // check if the cart exists
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return ["error" => "Cart not found"];
            }
            // check if the item is in the cart
            $query = "SELECT * FROM cart_has_product WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id'], 'item_code' => $itemCode]);
            $cartItem = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItem)) {
                return ["error" => "Item not in cart"];
            }
            // delete item from cart
            $query = "DELETE FROM cart_has_product WHERE cart_id = :cart_id AND item_code = :item_code";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id'], 'item_code' => $itemCode]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCartItemCount(int $customerId): int|array
    {
        // check if the cart exists
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return ["error" => "Cart not found"];
            }
            // get the amount of items in the cart
            $query = "SELECT COUNT(*) FROM cart_has_product WHERE cart_id = :cart_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id']]);
            $cartItemCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItemCount)) {
                return ["error" => "Cart not found"];
            }
            return (int)$cartItemCount[0]['COUNT(*)'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function calculateCartTotalCost(int $customerId): float|int|string
    {
        // check if the cart exists
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customerId]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return "Cart not found";
            }
            // get the amount of items in the cart
            $query = "SELECT * FROM cart_has_product WHERE cart_id = :cart_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id']]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cartItems)) {
                return "Cart not found";
            }
            $totalCost = 0;
            foreach ($cartItems as $cartItem) {
                $query = "SELECT * FROM product WHERE item_code = :item_code";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':item_code', $cartItem['item_code'], PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetchObject();
                if (!is_object($product)) {
                    return "Product not found";
                }
                if ($product->quantity < $cartItem['quantity']) {
                    return "Not enough items in stock for item: " . $product->name;
                }
                $totalCost += $product->price * $cartItem['quantity'];
            }
            return $totalCost;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function clearCart(int $customer_id): array|string
    {
        // check if the cart exists
        try {
            $query = "SELECT cart_id FROM cart WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['customer_id' => $customer_id]);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($cart)) {
                return "Cart not found";
            }
            // delete all items from the cart
            $query = "DELETE FROM cart_has_product WHERE cart_id = :cart_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['cart_id' => $cart[0]['cart_id']]);
            return [
                "message" => "Cart cleared"
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function getItemQuantity(int $itemCode, int $customerId): int
    {
        try {
            $sql = "SELECT quantity FROM product WHERE item_code = :item_code";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":item_code", $itemCode);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $totalProductQuantity = $result['quantity'] ?? 0;


            $sql = "SELECT quantity FROM cart_has_product WHERE item_code = :item_code AND cart_id = (SELECT cart_id FROM cart WHERE customer_id = :customer_id)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":item_code", $itemCode);
            $statement->bindValue(":customer_id", $customerId);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $totalCartQuantity = $result['quantity'] ?? 0;
            return $totalProductQuantity - $totalCartQuantity;

        } catch (PDOException $e) {
            return 0;
        }
    }

}