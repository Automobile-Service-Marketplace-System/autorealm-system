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
    public function getVehiclesPage(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehicles();

            return $res->render(view: "office-staff-dashboard-vehicles-page", layout: "office-staff-dashboard",
                pageParams: ["vehicles"=>$vehicles], 
                layoutParams: [
                    'title' => 'Vehicles',
                    'pageMainHeading' => 'Vehicles',
                    'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }

    public function getVehiclesByCustomer(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehicleByID((int) $query["id"]);
            $customerModel = new Customer();
            $customer = $customerModel->getCustomerByID((int) $query["id"]);

            return $res->render(view: "office-staff-dashboard-get-vehicle-by-customer", layout: "office-staff-dashboard",
                pageParams: ["vehicles"=>$vehicles, 'customer' => $customer],
                layoutParams: [
                    'title' => 'Vehicles',
                    'pageMainHeading' => 'Vehicles',
                    'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }

    public function getAddVehiclePage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $query = $req->query();
            $vehicleModel = new Vehicle();
            $vehicles = $vehicleModel->getVehicleByID((int) $query["id"]);

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

            return $res->render(view:"office-staff-dashboard-add-vehicle", layout:"office-staff-dashboard",
                pageParams:[
                    "vehicles"=>$vehicles,
                    'models' => $models,
                    'brands' => $brands,
                ],
                layoutParams:[
                    'title' => 'Add Vehicle',
                    'pageMainHeading' => 'Add Vehicle',
                    'officeStaffId' => $req->session->get('user_id'),
                ]);
        }

        return $res->redirect(path:"/employee-login");
    }

    public function addVehicle(Request $req, Response $res): string
    {
        $query = $req->query();
        $body = $req->body();
        $vehicle = new Vehicle($body);
        $result = $vehicle->addVehicle(customer_id: $query['id']);

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
            $res->setStatusCode(code: 400);
            return $res->json([
                "errors" => $result
            ]);
        }

        if ($result) {
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Vehicle added successfully"
            ]);
        }

        return $res->render(view:"500", layout:"plain", pageParams:[
            "error" => "Something went wrong. Please try again later.",
        ]);
    }


}
