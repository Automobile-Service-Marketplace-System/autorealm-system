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
use app\models\Securityofficer;

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
                    'customerId' => $req->session->get('user_id'),
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
                    'pageMainHeading' => 'My Profile',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
            }

            return $res->redirect(path: "/login");

        }

        return $res->redirect(path: "/login");
    }

    public function getStockManagerDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {

            $stockManagerModel = new Stockmanager();
            $stockManager = $stockManagerModel->getStockManagerById($req->session->get("user_id"));
            if ($stockManager) {
                return $res->render(view: "stock-manager-dashboard-profile", layout: "stock-manager-dashboard", pageParams: [
                    'stockManager' => $stockManager

                ], layoutParams: [
                    'title' => 'My Profile',
                    'stockManager' => $stockManager,
                    'pageMainHeading' => 'My Profile',
                    'employeeId' => $req->session->get("user_id")
                ]);
            }
            return "";
        }
        return "";
    }

    public function getOfficeStaffDashboardOverview(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            return $res->render(view: "office-staff-dashboard-overview", layout: "office-staff-dashboard", layoutParams: [
                'title' => 'Overview',
                'pageMainHeading' => 'Overview',
                'officeStaffId' => $req->session->get('user_id')
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getTechnicianDashboardOverview(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {
            return $res->render(view: "office-staff-dashboard-overview", layout: "technician-dashboard", layoutParams: [
                'title' => 'Overview',
                'pageMainHeading' => 'Overview',
                'technicianId' => $req->session->get('user_id')
            ]);
        }
        return $res->redirect(path: "/login");
    }


    public function getForemanDashboardOverview(Request $req, Response $res): string
    {
        return $res->render(view: "office-staff-dashboard-overview", layout: "foreman-dashboard", layoutParams: [
            'title' => 'Overview',
            'pageMainHeading' => 'Overview',
            'foremanId' => $req->session->get('user_id')
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
                    'foremanId' => $req->session->get("user_id"),
                    'pageMainHeading' => 'Profile'
                ]);
            }
            return $res->redirect(path: "/login");
        }
        return $res->redirect(path: "/login");
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
                    'technicianId' => $req->session->get("user_id"),
                    'pageMainHeading' => 'Profile'
                ]);
            }

            return $res->redirect(path: "/login");

        }
        return $res->redirect(path: "/login");
    }

    public function getAdminDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "admin") {
            $adminModel = new Admin();
            $admin = $adminModel->getAdminById($req->session->get("user_id"));
            if ($admin) {
                return $res->render(view: "admin-dashboard-profile", layout: "admin-dashboard", pageParams: [
                    'admin' => $admin
                ], layoutParams: [
                    'title' => 'Profile',
                    'admin' => $admin,
                    'pageMainHeading' => 'Profile',
                    'employeeId' => $req->session->get("user_id")
                ]);
            }

            return $res->redirect(path: "/login");

        }
        return $res->redirect(path: "/login");
    }

    public function getSecurityOfficerDashboardProfile(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            $securityOfficerModel = new SecurityOfficer();
            $securityOfficer = $securityOfficerModel->getSecurityOfficerById($req->session->get("user_id"));
            if ($securityOfficer) {
                return $res->render(view: "security-officer-dashboard-profile", layout: "security-officer-dashboard", pageParams: [
                    'securityOfficer' => $securityOfficer
                ], layoutParams: [
                    'title' => 'Profile',
                    'security-officer' => $securityOfficer,
                    'pageMainHeading' => 'Profile',
                    'securityOfficerId' => $req->session->get("user_id"),
                ]);
            }

            return $res->redirect(path: "/login");

        }
        return $res->redirect(path: "/login");
    }

}