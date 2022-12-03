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
                'pageMainHeading' => 'Products'
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }


}