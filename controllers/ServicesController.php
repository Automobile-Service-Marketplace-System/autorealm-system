<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Model;
use app\models\Service;

class ServicesController
{

    public function getServicesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

            $serviceModel = new Service();
            $services = $serviceModel->getServices();


            return $res->render(view: "admin-dashboard-view-services", layout: "admin-dashboard", pageParams: [
                "services" => $services], layoutParams: [
                'title' => 'services',
                'pageMainHeading' => 'services',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/login");

    }

    public function getAddServicesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

            return $res->render(view: "admin-add-services", layout: "admin-dashboard", pageParams: [

            ], layoutParams: [
                'title' => 'Add Services',
                'pageMainHeading' => 'Add Services',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/login");

    }

    public function AddServices(Request $req, Response $res): string
    {
        $body = $req->body();
        $service = new Service($body);
        $result = $service->addServices();

        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => "Internal Server Error"
            ]);
        }

        if (is_array($result)) {
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

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function getPastServiceRecordsByVehicleIdCustomerPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $query = $req->query();
            $vehicleId = $query["vehicle_id"];
            $customerId = $req->session->get("user_id");

            return $res->render(view: "customer-dashboard-records", layout: "customer-dashboard", pageParams: [
                "vehicleId" => $vehicleId
            ], layoutParams: [
                "title" => "Service History",
                "pageMainHeading" => "Service History",
                "customerId" => $customerId
            ]);
        }
    }


    public function geOngoingServicesForCustomerPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");

            return $res->render(view: "customer-dashboard-services", layout: "customer-dashboard", layoutParams: [
                "title" => "Ongoing Services / Repairs",
                "pageMainHeading" => "Ongoing Services / Repairs",
                "customerId" => $customerId
            ]);
        }
    }
}