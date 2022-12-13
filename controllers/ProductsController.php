<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Product;

class ProductsController
{

    public function getProductsPage(Request $req, Response $res) : string {
        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager"){

            $productModel = new Product();
            $products = $productModel->getProducts();


            return $res->render(view: "products-page", layout: "stock-manager-dashboard",pageParams: [
                "products" => $products] , layoutParams: [
                'title' => 'Products',
                'pageMainHeading' => 'Products',
                'employeeId' => $req->session->get("user_id")
            ]);
        }

        return $res->redirect(path: "/employee-login");

    }

    public function getAddProductsPage(Request $req, Response $res) : string {
        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager"){

            return $res->render(view: "stock-manager-add-products", layout: "stock-manager-dashboard" , layoutParams: [
                'title' => 'Add Products',
                'pageMainHeading' => 'Add Products',
                'employeeId' => $req->session->get("user_id")
            ]);
        }

        return $res->redirect(path: "/employee-login");

    }


}