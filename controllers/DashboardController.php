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

    public function getOfficeStaffDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "office_staff_member") {

            $officeStaffModel = new Officestaff();
            $officeStaff = $officeStaffModel->getOfficeStaffById($req->session->get("user_id"));
            if ($officeStaff) {
                return $res->render(view: "office-staff-dashboard-profile", layout: "office-staff-dashboard", pageParams: [
                    'officeStaff' => $officeStaff
                ], layoutParams: [
                    'title' => 'My Profile',
                    'officeStaff' => $officeStaff,
                    'pageMainHeading' => 'My Profile'
                ]);
            } else {
                return $res->redirect(path: "/office-staff-login");
            }

        }

        return $res->redirect(path: "/office-staff-login");
    }
}