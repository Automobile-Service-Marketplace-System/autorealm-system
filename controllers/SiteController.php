<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;

class SiteController
{

    public function getHomePage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "customer") {
            $customerModel = new Customer();
            $customer = $customerModel->getCustomerById($req->session->get("user_id"));
            if ($customer) {
                return $res->render(view: "home", layout: "landing", layoutParams: [
                    'customer' => $customer,
                ]);
            } else {
                return $res->render(view: "home", layout: "landing");
            }
        }

        return $res->render(view: "home", layout: "landing");
    }
}