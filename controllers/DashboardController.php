<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;

class DashboardController
{

    public function getCustomerDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "customer") {

            $customerModel = new Customer();
            $customer = $customerModel->getCustomerById($req->session->get("user_id"));
            if ($customer) {
                return $res->render(view: "customer-dashboard-profile", layout: "customer-dashboard", pageParams: [
                    'customer' => $customer

                ], layoutParams: [
                        'title' => 'My Profile',
                        'customer' => $customer,
                        'pageMainHeading' => 'My Profile'
                    ]);
            } else {
                return $res->render(view: "login", layout: "home");
            }

        }

        return $res->render(view: "home", layout: "landing");
    }
}