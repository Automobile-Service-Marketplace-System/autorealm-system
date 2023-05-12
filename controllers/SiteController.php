<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admin;
use app\models\Brand;
use app\models\Category;
use app\models\Customer;
use app\models\Product;
use app\models\Reviews;
use app\utils\DevOnly;

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

        $searchTerm = $query['q'] ?? null;
        $minPrice = isset($query['min']) ? ($query['min'] == "" ? null : (int)$query['min'] * 100) : null;
        $maxPrice = isset($query['max']) ? ($query['max'] == "" ? null : (int)$query['max'] * 100) : null;

        $categoryName = isset($query['category']) ? ($query['category'] == "" ? "all" : $query['category']) : "all";
        $brandName = isset($query['brand']) ? ($query['brand'] == "" ? "all" : $query['brand']) : "all";
        $productType = isset($query['product']) ? ($query['type'] == "" ? "all" : $query['type']) : "all";

        $productModel = new Product();
        $brandModel = new Brand();
        $categoryModel = new Category();

        $result = $productModel->getProductsForHomePage(
            count: $limit,
            page: $page,
            searchTerm: $searchTerm,
            minPrice: $minPrice,
            maxPrice: $maxPrice,
            options: [
                'category_name' => $categoryName,
                'brand_name' => $brandName,
                'product_type' => $productType,
                'status' => 'active',
                'availability' => 'in_stock',

            ]

        );


        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            if ($customerId) {
                return $res->render(view: "site-products", pageParams: [
                    "brands" => $brandModel->getBrands(),
                    "categories" => $categoryModel->getCategories(),
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

    public function getServicesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            if ($customerId) {
                return $res->render(view: "site-services", pageParams: [
                    "is_authenticated" => $req->session->get("is_authenticated"),
                ], layoutParams: [
                    'customerId' => $customerId,
                    'title' => 'Our Services',
                ]);
            }

            return $res->render(view: "site-services", pageParams: [
                "is_authenticated" => false,
            ], layoutParams: [
                'title' => 'Our Services',
                'customerId' => null,
            ]);
        }

        return $res->render(view: "site-services", pageParams: [
            "is_authenticated" => false,
        ], layoutParams: [
            'title' => 'Our Services',
            'customerId' => null,
        ]);
    }

    public function getViewProductPage(Request $req, Response $res): string
    {
        $query = $req->query();
        $itemCode = $query['id'];
        $productModel = new Product();
        $product = $productModel->getProductByItemCode(itemCode: $itemCode);
        if (is_string($product)) {
            return "Internal Server Error";
        }
        $relatedProducts = $productModel->getRelatedProducts(categoryId: $product['CategoryId'], itemCode: $itemCode);
        if (is_string($relatedProducts)) {
            $relatedProducts = null;
        }


        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");


            $reviewModel = new Reviews();

            $existingReview = $reviewModel->getReview(customerId: $customerId, itemCode: $itemCode);
            $alreadyReviewed = (bool)$existingReview;

            return $res->render(view: "site-view-one-product", pageParams: [
                'relatedProducts' => $relatedProducts,
                'product' => $product,
                "is_authenticated" => $req->session->get("is_authenticated"),
                'alreadyReviewed' => $alreadyReviewed,
                'customerId' => $customerId,
            ], layoutParams: [
                'customerId' => $customerId,
                'title' => $product ? $product['Name'] : 'Product not found',
            ]);

        }

        return $res->render(view: "site-view-one-product", pageParams: [
            'relatedProducts' => $relatedProducts,
            'product' => $product,
            "is_authenticated" => false,
            'alreadyReviewed' => false,
            'customerId' => null,
        ], layoutParams: [
            'title' => $product ? $product['Name'] : 'Product not found',
            'customerId' => null,
        ]);
    }
}