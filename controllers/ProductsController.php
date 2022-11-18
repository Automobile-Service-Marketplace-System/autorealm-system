<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class ProductsController
{
    public function getProductsPage(Request $req, Response $res) : string {
        return $res->render(view:"products-page", layout: "stock-manager-dashboard", layoutParams: [
            'title' => 'Products',
            'pageMainHeading' => 'Products'
        ]);
    }
}