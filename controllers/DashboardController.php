<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admin;
use app\models\Customer;
use app\models\Technician;
use app\models\Foreman;
use app\models\Officestaff;
use app\models\Stockmanager;

class DashboardController
{

    public function getCustomerDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {

            $customerModel = new Customer();
            $customer = $customerModel->getCustomerById($req->session->get("user_id"));
            if ($customer) {
                return $res->render(view: "customer-dashboard-profile", layout: "customer-dashboard", pageParams: [
                    'customer' => $customer,
                ], layoutParams: [
                    'title' => 'My Profile',
                    'customer' => $customer,
                    'pageMainHeading' => 'My Profile'
                ]);
            }

            return $res->redirect(path: "/login");

        }
        return $res->redirect(path: "/login");
    }

    public function getOfficeStaffDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

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
            }

            return $res->redirect(path: "/office-staff-login");

        }

        return $res->redirect(path: "/office-staff-login");
    }

    public function getStockManagerDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "stock_manager") {

            $stockManagerModel = new Stockmanager();
            $stockManager = $stockManagerModel->getStockManagerById($req->session->get("user_id"));
            if ($stockManager) {
                return $res->render(view: "stock-manager-dashboard-profile", layout: "stock-manager-dashboard", pageParams: [
                    'stockmanager' => $stockManager

                ], layoutParams: [
                    'title' => 'My Profile',
                    'stockManager' => $stockManager,
                    'pageMainHeading' => 'My Profile'
                ]);
            } else {
                return $res->redirect(path: "/stock-manager-login");
            }

        }

        return $res->redirect(path: "/stock-manager-login");
    }

    public function getOfficeStaffDashboardOverview(Request $req, Response $res): string
    {
        return $res->render(view: "office-staff-dashboard-overview", layout: "office-staff-dashboard", layoutParams: [
            'title' => 'Overview',
            'pageMainHeading' => 'Overview'
        ]);
    }


    public function getForemanDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $foremanModel = new Foreman();
            $foreman = $foremanModel->getForemanById($req->session->get("user_id"));
            if ($foreman) {
                return $res->render(view: "foreman-dashboard-profile", layout: "foreman-dashboard", pageParams: [
                    'foreman' => $foreman
                ], layoutParams: [
                    'title' => 'Profile',
                    'foreman' => $foreman,
                    'pageMainHeading' => 'Profile'
                ]);
            }

            return $res->redirect(path: "/employee-login");

        }
        return $res->redirect(path: "/employee-login");
    }


    public function getTechnicianDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {
            $technicianModel = new Technician();
            $technician = $technicianModel->getTechnicianById($req->session->get("user_id"));
            if ($technician) {
                return $res->render(view: "technician-dashboard-profile", layout: "technician-dashboard", pageParams: [
                    'technician' => $technician
                ], layoutParams: [
                    'title' => 'Profile',
                    'technician' => $technician,
                    'pageMainHeading' => 'Profile'
                ]);
            }

            return $res->redirect(path: "/employee-login");

        }
        return $res->redirect(path: "/employee-login");
    }


    /**
     * TODO: Complete the method to load stock manager's profile page
     * @param Request $req
     * @param Response $res
     * @return string
     */
    // public function getStockManagerDashboardProfile(Request $req, Response $res): string
    // {
    //     return "WIP, to be completed by Avishka";
    // }
}