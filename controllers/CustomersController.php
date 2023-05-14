<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Brand;
use app\models\Customer;
use app\models\Model;
use app\utils\DevOnly;

class CustomersController
{
    public function getCustomersPage(Request $req, Response $res): string
    {
        //for pagination
        $query = $req->query();
        $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
        $page = isset($query['page']) ? (int)$query['page'] : 1;

         //for search and filtering
        $searchTermCustomer = $query["cus"] ?? null;
        $searchTermEmail = $query["email"] ?? null;

        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member" || $req->session->get("user_role") === "admin")) {

            //create new object from model and call the method
            $customerModel = new Customer();
            $customers = $customerModel->getCustomers(
                count: $limit, 
                page: $page,
                searchTermCustomer: $searchTermCustomer,
                searchTermEmail: $searchTermEmail
            );

            //check authentication for office staff
            if($req->session->get("user_role") === "office_staff_member"){
                return $res->render(view:"office-staff-dashboard-customers-page", layout:"office-staff-dashboard",
                    pageParams:[
                        "total"=>$customers['total'],
                        "limit"=>$limit,
                        "page"=>$page,
                        'customers' => $customers,
                        'searchTermCustomer'=> $searchTermCustomer,
                        'searchTermEmail'=> $searchTermEmail
                    ],
                    layoutParams:[
                        'title' => 'Customers',
                        'pageMainHeading' => 'Customers',
                        'officeStaffId' => $req->session->get("user_id")
                    ]);
            }

            //check authentication for admin
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
        //if unauthorized
        return $res->redirect(path:"/login");
    }

    public function getAddCustomerPage(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            //for pagination
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            //create new object from customer and call the method
            $customerModel = new Customer();
            $customers = $customerModel->getCustomers(count: $limit, page: $page);

            //create new object from model and call the method
            $modelModel = new Model();
            $rawModels = $modelModel->getVehicleModels();
            $models = [];

            //fill model array
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }
//            DevOnly::prettyEcho($rawModels, $models);

            //create new object from brand and call the method
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getVehicleBrands();
            $brands = [];

            //fill brand array
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }
//            DevOnly::prettyEcho($rawBrands, $brands);


            //render page
            return $res->render(view:"office-staff-dashboard-add-customer", layout:"office-staff-dashboard", pageParams:[
                'models' => $models,
                'brands' => $brands,

            ], layoutParams:[
                'title' => 'Add New Customer',
                'pageMainHeading' => 'Add New Customer',
                'officeStaffId' => $req->session->get('user_id'),
            ]);
        }

        //if unauthorized
        return $res->redirect(path:"/login");
    }

    public function addCustomer(Request $req, Response $res): string
    {
        //get the data from the body and call the customer add method
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->registerWithVehicle();

        if (is_array($result)) {

            //create new object from model and call the method
            $modelModel = new Model();
            $rawModels = $modelModel->getVehicleModels();

            $models = [];

            //fill the model array
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }
    
            //create new object from brand and call the method
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getVehicleBrands();

            $brands = [];

            //fill the  brand array
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            //render page
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

        //if successfully added
        if ($result) {
            return $res->redirect("/customers");
        }

        //if an error 
        return $res->render(view:"500", layout:"plain", pageParams:[
            "error" => "Something went wrong. Please try again later.",
        ]);
    }

    public function updateCustomer(Request $req, Response $res): string
    {
        //get the data from the body and call the customer add method for updating
        $body = $req->body();
        $service = new Customer($body);
        $result = $service->updateCustomer();

        //if an error
        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => "Internal Server Error"
            ]);
        }

        //if an error
        if (is_array($result)) {
            $res->setStatusCode(code: 400);
            return $res->json([
                "errors" => $result
            ]);
        }

        //if successful
        if ($result) {
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Customer updated successfully"
            ]);
        }

        //if an error
        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

}
