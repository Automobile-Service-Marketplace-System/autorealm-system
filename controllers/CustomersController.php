<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Brand;
use app\models\Customer;
use app\models\Model;

class CustomersController
{
    public function getCustomersPage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member" || $req->session->get("user_role") === "admin")) {

            $customerModel = new Customer();
            $customers = $customerModel->getCustomers();

            if($req->session->get("user_role") === "office_staff_member"){
                return $res->render(view:"office-staff-dashboard-customers-page", layout:"office-staff-dashboard",
                    pageParams:["customers" => $customers],
                    layoutParams:[
                        'title' => 'Customers',
                        'pageMainHeading' => 'Customers',
                        'officeStaffId' => $req->session->get('user_id'),
                ]);
            }

            if($req->session->get("user_role") === "admin"){
                return $res->render(view:"office-staff-dashboard-customers-page", layout:"admin-dashboard",
                    pageParams:["customers" => $customers],
                    layoutParams:[
                        'title' => 'Customers',
                        'pageMainHeading' => 'Customers',
                        'employeeId' => $req->session->get('user_id'),
                ]);
            }
        }

        return $res->redirect(path:"/login");
    }

    public function getAddCustomerPage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $customerModel = new Customer();
            $customers = $customerModel->getCustomers();

            $modelModel = new Model();
            $rawModels = $modelModel->getModels();
            $models = [];
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }

            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getBrands();
            $brands = [];
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            return $res->render(view:"office-staff-dashboard-add-customer", layout:"office-staff-dashboard", pageParams:[
                'models' => $models,
                'brands' => $brands,

            ], layoutParams:[
                'title' => 'Add New Customer',
                'pageMainHeading' => 'Add New Customer',
                'officeStaffId' => $req->session->get('user_id'),
            ]);
        }

        return $res->redirect(path:"/login");
    }

    public function addCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->registerWithVehicle();

        if (is_array($result)) {

            $modelModel = new Model();
            $rawModels = $modelModel->getModels();
            $models = [];
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }
    
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getBrands();
            $brands = [];
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }


            return $res->render(view:"office-staff-dashboard-add-customer", layout:"office-staff-dashboard",
                pageParams:[
                    "customer" => $customer,
                    'errors' => $result,
                    'body' => $body,
                    'models' => $models,
                    'brands' => $brands,
                ],
                layoutParams:[
                    'title' => 'Add New Customer',
                    'pageMainHeading' => 'Add New Customer',
                    'officeStaffId' => $req->session->get("user_id")
                ]);
        }

        if ($result) {
            return $res->redirect("/customers");
        }

        return $res->render(view:"500", layout:"plain", pageParams:[
            "error" => "Something went wrong. Please try again later.",
        ]);
    }

}
