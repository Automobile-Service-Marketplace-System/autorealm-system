<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Officestaff;

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
                return $res->redirect(path: "/login");
            }

        }

        return $res->redirect(path: "/login");
    }

    public function getOfficestaffDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "office_staff_member") {

            $officestaffModel = new Officestaff();
            $officestaff = $officestaffModel->getOfficestaffById($req->session->get("user_id"));
            if ($officestaff) {
                return $res->render(view: "officestaff-dashboard-profile", layout: "officestaff-dashboard", pageParams: [
                    'officestaff' => $officestaff

                ], layoutParams: [
                    'title' => 'My Profile',
                    'officestaff' => $officestaff,
                    'pageMainHeading' => 'My Profile'
                ]);
            } else {
                return $res->redirect(path: "/login");
            }

        }

        return $res->redirect(path: "/login");
    }
}