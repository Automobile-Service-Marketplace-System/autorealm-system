<?php

/**
 * @package app\core
 */

namespace app\core;

use Exception;

class Application
{
    public Router $router; //create a router
    public Request $request; //create a request 
    public Response $response; //create a response
    public static string $rootDir; //create a 

    public function __construct(string $rootDir)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router(request: $this->request, response: $this->response);
        self::$rootDir = $rootDir;
    }


    public function run(): void
    {
        try {
            $result = $this->router->resolve();
            echo $result;
        } catch (Exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            $errorParams = [
                "code" => $errorCode,
                "message" => $errorMessage,
            ];

            $this->response->setStatusCode($errorCode);

            // get the user role
            $userRole = $this->request->session->get("user_role");


            switch ($userRole) {
                case "customer":
                    echo $this->response->render(view: "_error", pageParams: $errorParams);
                    exit;
                case "admin":
                    echo $this->response->render(view: "_error", layout: "admin-dashboard", pageParams: $errorParams);
                    exit;
                case "foreman":
                    echo $this->response->render(view: "_error", layout: "foreman-dashboard", pageParams: $errorParams);
                    exit;
                case "stock_manager":
                    echo $this->response->render(view: "_error", layout: "stock-manager-dashboard", pageParams: $errorParams);
                    exit;
                case "office_staff_member":
                    echo $this->response->render(view: "_error", layout: "office-staff-dashboard", pageParams: $errorParams);
                    exit;
                case "technician":
                    echo $this->response->render(view: "_error", layout: "technician-dashboard", pageParams: $errorParams);
                    exit;
                case "security_officer":
                    echo $this->response->render(view: "_error", layout: "security-officer-dashboard", pageParams: $errorParams);
                    exit;
                    default:
                        echo ""
            }
        }
    }

}