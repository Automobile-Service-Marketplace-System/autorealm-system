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


            return $res->render(view: "services-page", layout: "admin-dashboard", pageParams: [
                "services" => $services], layoutParams: [
                'title' => 'services',
                'pageMainHeading' => 'services',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/employee-login");

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

        return $res->redirect(path: "/employee-login");

    }

    public function AddServices(Request $req, Response $res): string
    {
        $body = $req->body();
        var_dump($body);
        $service = new Service($body);
        $result = $service->addServices();

        if (is_string($result)) {
            var_dump($result);
            return "";
        }

        if (is_array($result)) {
            return $res->render(view: "admin-add-services", layout: "admin-dashboard", pageParams: [
                'errors' => $result
            ], layoutParams: [
                'title' => 'Add Services',
                'pageMainHeading' => 'Add Services',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        if ($result) {
            return $res->redirect(path: "/admin-dashboard/services");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }
}