<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\ShoppingCart;
use JsonException;

class ShoppingCartController
{

    /**
     * @throws JsonException
     */
    public function getCartPage(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $customerId = $req->session->get("user_id");
            if ($customerId) {
                $cartModel = new ShoppingCart();
                $result = $cartModel->getCartItemsByCustomerId(customerId: $customerId);
                if (is_string($result)) {
                    return $res->render(view: "site-cart", pageParams: [
                        "error" => $result,
                        'cartItems' => [],
                    ], layoutParams: [
                        'customerId' => $customerId,
                        'title' => 'Shopping Cart',
                    ]);
                }

                return $res->render(view: "site-cart", pageParams: [
                    'cartItems' => $result
                ], layoutParams: [
                    'customerId' => $customerId,
                    'title' => 'Shopping Cart',
                ]);

            }

        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }

    /**
     * @throws JsonException
     */
    public function addToCustomerShoppingCart(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $body = $req->body();
            $cartModel = new ShoppingCart();
            $result = $cartModel->addToCart($req->session->get('user_id'), $body['item_code'], $body['amount']);

            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json(['message' => $result]);
            }

            if (is_int($result)) {
                $res->setStatusCode(200);
                return $res->json(['message' => 'Cart updated successfully', 'amount' => $result]);
            }
        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }


    /**
     * @throws JsonException
     */
    public function updateCartItem(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $body = $req->body();
            $cartModel = new ShoppingCart();
            $result = $cartModel->changeCartItemAmount(customerId: $req->session->get('user_id'), itemCode: (int)$body['item_code'], by: (int)$body['by']);
            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json(['message' => $result]);
            }

            if (is_array($result)) {
                $res->setStatusCode(400);
                return $res->json(['message' => $result['error']]);
            }


            $res->setStatusCode(200);
            return $res->json(['message' => 'Item updated in cart', 'amount' => $result]);

        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }

    /**
     * @throws JsonException
     */
    public function deleteCartItem(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $body = $req->body();
            $cartModel = new ShoppingCart();
            $result = $cartModel->deleteItemFromCart(customerId: $req->session->get('user_id'), itemCode: (int)$body['item_code']);
            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json(['message' => $result]);
            }

            if (is_array($result)) {
                $res->setStatusCode(400);
                return $res->json(['message' => $result['error']]);
            }


            $res->setStatusCode(200);
            return $res->json(['message' => 'Item removed from cart']);

        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }

    /**
     * @throws JsonException
     */
    public function getCartCheckoutPage(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $customerId = $req->session->get("user_id");
            if ($customerId) {
                $cartModel = new ShoppingCart();
                $result = $cartModel->getCartItemsByCustomerId(customerId: $customerId);
                if (is_string($result)) {
                    return $res->render(view: "site-cart-checkout-page", layoutParams: [
                        'customerId' => $customerId,
                        'title' => 'Checkout',
                    ]);
                }

                return $res->render(view: "site-cart-checkout-page", layoutParams: [
                    'customerId' => $customerId,
                    'title' => 'Checkout',
                ]);

            }

        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }


    /**
     * @throws JsonException
     */
    public function getProductItemQuantity(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $query = $req->query();
            $itemCode = $query['item_code'] ?? null;

            $customerId = $req->session->get("user_id");
            if (!$itemCode) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }

            $cartModel = new ShoppingCart();
            $amount = $cartModel->getItemQuantity(itemCode: $itemCode, customerId: $customerId);
            $res->setStatusCode(code: 200);
            return $res->json([
                "amount" => max($amount, 0)
            ]);
        }
        $res->setStatusCode(code: 401);
        return $res->json([
            "message" => "You must login!"
        ]);
    }
}