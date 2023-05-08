<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Model;
use app\models\Service;
use JsonException;

class ServicesController
{

    public function getServicesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

            $query = $req->query();

            //for search
            $serachTermName = $query['name'] ?? null;
            $serachTermCode = $query['code'] ?? null;
            $serviceStatus = isset($query['status']) ? ($query['status'] == "" ? "active" : $query['status']) : "active";

            //for pagination
            $limit = (isset($query['limit']) && is_numeric($query['limit'])) ? (int)$query['limit']:5;
            $page = (isset($query['page']) && is_numeric($query['page'])) ? (int)$query['page'] : 1;
            $serviceModel = new Service();

            $result = $serviceModel->getServices(
                count: $limit, 
                page: $page,
                searchTermName : $serachTermName,
                searchTermCode : $serachTermCode,
                options: [
                    'serviceStatus' => $serviceStatus,
                ]
            );

            return $res->render(view: "admin-dashboard-view-services", layout: "admin-dashboard", pageParams: [
                "services" => $result['services'],
                'total'=> $result['total'],
                'page' => $page,
                'limit' => $limit], 
                layoutParams: [
                'title' => 'services',
                'pageMainHeading' => 'Services',
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

    public function UpdateServices(Request $req, Response $res): string
    {
        $body = $req->body();
        $service = new Service($body);
        $result = $service->updateServices();

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
                "success" => "Services updated successfully"
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

    /**
     * @throws JsonException
     */
    public function deleteService(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

            $body = $req->body();
            $service_code = $body['service_code'] ?? null;
            if (!$service_code) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }
            $serviceModel = new Service();
            $result = $serviceModel->deleteServiceById(code: $service_code);
            var_dump($result);

            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error",
                    "error" => $result
                ]);
            } else if (!$result) {
                $res->setStatusCode(code: 404);
                return $res->json([
                    "message" => "Service not found"
                ]);
            } else {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Service deleted successfully"
                ]);
            }
        }
        return $res->redirect(path: "/login");
    }

    /**
     * @throws JsonException
     */
    public function getServiceSelectorServices(Request $req, Response $res): string
    {
        $query = $req->query();
        $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
        $page = isset($query['page']) ? (int)$query['page'] : 1;
        $searchTerm = $query['q'] ?? null;


        $serviceModel = new Service();
        $result = $serviceModel->getServicesForServiceSelector(count: $limit, page: $page, searchTerm: $searchTerm);

        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => "Internal Server Error",
                "error" => $result
            ]);
        }

        $res->setStatusCode(code: 200);
        return $res->json([
            'services' => $result['services'],
            'total' => $result['total'],
            'limit' => $limit,
            'page' => $page,
        ]);
    }
}