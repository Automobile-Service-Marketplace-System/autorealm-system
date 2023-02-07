<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admin;
use app\models\Customer;
use app\models\Product;

class SiteController
{

    public function getHomePage(Request $req, Response $res): string
    {
        $productModel = new Product();
        $result = $productModel->getProductsForHomePage(count: 12, page: null);
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");

            if ($customerId) {
                return $res->render(view: "site-home", layout: "landing", pageParams: [
                    'products' => $result['products'],
                    "is_authenticated" => $req->session->get("is_authenticated"),
                ], layoutParams: [
                    'customerId' => $customerId,
                ]);
            }

            return $res->render(view: "site-home", layout: "landing", pageParams: [
                'products' => $result['products'],
                "is_authenticated" => false,
            ], layoutParams: [
                'customerId' => null,
            ]);
        }

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") !== "customer") {
            return $res->redirect(path: "/login");
        }

        return $res->render(view: "site-home", layout: "landing", pageParams: [
            'products' => $result['products'],
            "is_authenticated" => false,
        ], layoutParams: [
            'customerId' => null,
        ]);
    }

    public function getProductsPage(Request $req, Response $res): string
    {
        $query = $req->query();
        $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
        $page = isset($query['page']) ? (int)$query['page'] : 1;
        $productModel = new Product();
        $result = $productModel->getProductsForHomePage(count: $limit, page: $page);
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            if ($customerId) {
                return $res->render(view: "site-products", pageParams: [
                    'products' => $result['products'],
                    'total' => $result['total'],
                    'limit' => $limit,
                    'page' => $page,
                    "is_authenticated" => $req->session->get("is_authenticated"),
                ], layoutParams: [
                    'customerId' => $customerId,
                    'title' => 'Products',
                ]);
            }

            if ($req->session->get("is_authenticated") && $req->session->get("user_role") !== "customer") {
                return $res->redirect(path: "/login");
            }

            return $res->render(view: "site-products", pageParams: [
                'products' => $result['products'],
                'total' => $result['total'],
                'limit' => $limit,
                'page' => $page,
                "is_authenticated" => false,
            ], layoutParams: [
                'title' => 'Products',
                'customerId' => null,
            ]);
        }

        return $res->render(view: "site-products", pageParams: [
            'products' => $result['products'],
            'total' => $result['total'],
            'limit' => $limit,
            'page' => $page,
            "is_authenticated" => false,
        ], layoutParams: [
            'title' => 'Products',
            'customerId' => null,
        ]);
    }
}