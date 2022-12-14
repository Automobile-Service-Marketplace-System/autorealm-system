<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Brand;
use app\models\Vehicle;
use app\models\Model;


class VehiclesController
{
    public function officeStaffgetVehiclesPage(Request $req, Response $res) : string {

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

}
