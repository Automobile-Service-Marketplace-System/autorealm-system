<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Brand;
use app\models\Customer;
use app\models\Vehicle;
use app\models\Model;

class VehiclesController
{
    public function getVehiclesPage(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member" || $req->session->get("user_role") === "admin")) {
            
            //for pagination
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            //for search and filtering
            $searchTermRegNo = $query["reg"] ?? null;
            $searchTermCustomer = $query["cus"] ?? null;
            $vehicleType = isset($query["type"]) ? ($query["type"] == "" ? "all" : $query["type"]) : "all";


            //create new object from vehicle and get all vehicles
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehicles(
                count: $limit, 
                page: $page, 
                searchTermRegNo: $searchTermRegNo,
                searchTermCustomer: $searchTermCustomer,
                vehicleType: $vehicleType
            );
            
            //create model and brand objects
            $modelModel = new Model();
            $brandModel = new Brand();

            //render page
            if ($req->session->get("user_role") === "office_staff_member") {
                return $res->render(view: "office-staff-dashboard-vehicles-page", layout: "office-staff-dashboard",
                    pageParams: [
                        "vehicles" => $vehicles,
                        "total"=>$vehicles['total'],
                        "limit"=>$limit,
                        "page"=>$page,
                        "models" => $modelModel->getMOdels(),
                        "brands" => $brandModel->getBrands()],
                    layoutParams: [
                        'title' => 'Vehicles',
                        'pageMainHeading' => 'Vehicles',
                        'officeStaffId' => $req->session->get('user_id')
                    ]);
            }

            //check authentication for admin
            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "office-staff-dashboard-vehicles-page", layout: "admin-dashboard",
                    pageParams: ["vehicles" => $vehicles],
                    layoutParams: [
                        'title' => 'Vehicles',
                        'pageMainHeading' => 'Vehicles',
                        'employeeId' => $req->session->get('user_id')
                    ]);
            }

        }

        //if unauthorized
        return $res->redirect(path: "/login");
    }

    public function getVehiclesByCustomer(Request $req, Response $res): string
    {
        //check authentication for office staff
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            //get the query
            $query = $req->query();

            //create vehicle object
            $vehicleModel = new Vehicle();

            //create Model object and call the method for get vehicle methods
            $modelModel = new Model();
            $rawModels = $modelModel->getVehicleModels();
            $models = [];

            //fill models array 
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }

            //create Brand object and call the method for get vehicle brands
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getVehicleBrands();
            $brands = [];

            
            //fill brands array 
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            //method for get the vehicles using customer id
            $vehicles = $vehicleModel->getVehiclesByID(customer_id: (int)$query["id"]);
            if (is_string($vehicles)) {
                return $res->render(view: "office-staff-dashboard-get-vehicle-by-customer", layout: "office-staff-dashboard",
                    pageParams: [
                        'error' => $vehicles,
                        'brands' => $brands,
                        'models' => $models
                    ],
                    layoutParams: [
                        'title' => 'Vehicles',
                        'pageMainHeading' => 'Vehicles',
                        'officeStaffId' => $req->session->get('user_id')
                    ]);
            }

            //create customer object and call the method for get customer using id
            $customerModel = new Customer();
            $customer = $customerModel->getCustomerByID((int)$query["id"]);

            //render page 
            return $res->render(view: "office-staff-dashboard-get-vehicle-by-customer", layout: "office-staff-dashboard",
                pageParams: [
                    "vehicles" => $vehicles, 
                    'customer' => $customer,  
                    'brands' => $brands,
                    'models' => $models],
                layoutParams: [
                    'title' => 'Vehicles',
                    'pageMainHeading' => 'Vehicles',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }
        //if unauthorized
        return $res->redirect(path: "/login");
    }

    /**
     * @throws \JsonException
     */
    public function getVehiclesByCustomerAsJSON(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            
            //get the query 
            $query = $req->query();

            //create new object from vehicle and get vehicle names
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehicleNamesByID(customer_id: (int)$query["id"]);
            
            //if an error
            if (is_string($vehicles)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: ["error" => $vehicles]);
            }

            //if no vehicle
            if (empty($vehicles)) {
                $res->setStatusCode(code: 404);
                return $res->json(data: ["error" => "No vehicles found"]);
            }

            //if successful
            $res->setStatusCode(code: 200);
            return $res->json(data: $vehicles);
        }

        //if unauthorized
        $res->setStatusCode(code: 401);
        return $res->json(data: ["error" => "Unauthorized"]);
    }

    public function getCustomerVehiclePage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get('user_id');
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehiclesByID($customerId);


            return $res->render(view: "customer-dashboard-vehicles", layout: "customer-dashboard",
                pageParams: ["vehicles" => $vehicles],
                layoutParams: [
                    'title' => 'Vehicles',
                    'pageMainHeading' => 'My Vehicles',
                    'customerId' => $customerId
                ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getAddVehiclePage(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            //get query
            $query = $req->query();
            
            //create new object from vehicle and get vehicles
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehiclesByID((int)$query["id"]);

            //create new object from model and get models
            $modelModel = new Model();
            $rawModels = $modelModel->getVehicleModels();

            $models = [];

            //fill models array
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }

            //create new object from brand and get brands
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getVehicleBrands();

            $brands = [];

            //fill brands array
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            //render page
            return $res->render(view: "office-staff-dashboard-add-vehicle", layout: "office-staff-dashboard",
                pageParams: [
                    "vehicles" => $vehicles,
                    'models' => $models,
                    'brands' => $brands,
                ],
                layoutParams: [
                    'title' => 'Add Vehicle',
                    'pageMainHeading' => 'Add Vehicle',
                    'officeStaffId' => $req->session->get('user_id'),
                ]);
        }

        //if unauthorized
        return $res->redirect(path: "/login");
    }

    public function addVehicle(Request $req, Response $res): string
    {
        //get query
        $query = $req->query();

        //get body
        $body = $req->body();

        //create vehicle object and pass the body to the method
        $vehicle = new Vehicle($body);
        $result = $vehicle->addVehicle(customer_id: $query['id']);


        //if an error
        if (is_array($result)) {

            //create new object from model and get vehicles
            $modelModel = new Model();
            $rawModels = $modelModel->getVehicleModels();

            $models = [];

            //fill models array
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }

            //create new object from brand and get brands
            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getVehicleBrands();

            $brands = [];

            //fill brands array
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            //set error status code
            $res->setStatusCode(code: 400);
            return $res->json([
                "errors" => $result
            ]);
        }

        //if successful
        if ($result) {
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Vehicle added successfully"
            ]);
        }

        //if an error
        return $res->render(view: "500", layout: "plain", pageParams: [
            "error" => "Something went wrong. Please try again later.",
        ]);
    }

    public function updateVehicle(Request $req, Response $res): string
    {
        //check authorization
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            
            //get body
            $body = $req->body();

            //pass body to update vehicle method
            $vehicle = new Vehicle($body);
            $result = $vehicle->updateVehicle();

            //if an error
            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => $result
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
                    "success" => "Vehicle updated successfully"
                ]);
            }

            //if an error
            return $res->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
    }
}
