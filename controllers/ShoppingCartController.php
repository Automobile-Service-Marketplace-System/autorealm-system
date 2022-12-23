<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\ShoppingCart;
use JsonException;

class ShoppingCartController
{

    public function getCartPage(Request $req, Response $res): string
    {
        if ($req->session->get('is_authenticated') && $req->session->get('user_role') === "customer") {
            $customerModel = new Customer();
            $customer = $customerModel->getCustomerById($req->session->get("user_id"));

            if ($customer) {
                $cartModel = new ShoppingCart();
                $result = $cartModel->getCartItemsByCustomerId($req->session->get("user_id"));
                if (is_string($result)) {
                    return $res->render(view: "site-cart", layout: "main", pageParams: [
                        "error" => $result,
                        'cartItems' => [],
                    ], layoutParams: [
                        'customer' => $customer,
                        'title' => 'Shopping Cart',
                    ]);
                }

                return $res->render(view: "site-cart", layout: "main", pageParams: [
                    'cartItems' => $result
                ], layoutParams: [
                    'customer' => $customer,
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
            $result = $cartModel->addToCart($req->session->get('user_id'), $body['item_code']);
            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json(['message' => $result]);
            }

            if (is_array($result)) {
                $res->setStatusCode(200);
                return $res->json(['message' => 'Item already in cart!']);
            }

            $res->setStatusCode(201);
            return $res->json(['message' => 'Item added to cart']);

        }
        $res->setStatusCode(401);
        return $res->json(['message' => 'You must login!']);
    }


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

    public function deleteCartItem(Request $req,Response $res) : string {
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
}