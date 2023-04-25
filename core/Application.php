<?php

/**
 * @package app\core
 */

namespace app\core;

use Exception;
use JsonException;

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
            if ($this->response->isJson) {
                try {
                    echo $this->response->json([
                        "message" => $e->getMessage(),
                        "code" => $e->getCode()
                    ]);
                } catch (JsonException $e) {
                    echo "Internal Server Error";
                }

            }
            $errorCode = $this->getHumanFriendlyErrorCode($e->getCode());
            $errorMessage = $e->getMessage();

            $errorParams = [
                "code" => $errorCode,
                "message" => $errorMessage,
            ];

            $this->response->setStatusCode(is_string($errorCode) ? 500 : $errorCode);

            // get the user role
            $userRole = $this->request->session->get("user_role");


            switch ($userRole) {
                case "customer":
                    echo $this->response->render(view: "_error", pageParams: $errorParams);
                    exit;
                case "admin":
                    echo $this->response->render(view: "_error", layout: "admin-dashboard", pageParams: $errorParams, layoutParams: [
                        'employeeId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                case "foreman":
                    echo $this->response->render(view: "_error", layout: "foreman-dashboard", pageParams: $errorParams, layoutParams: [
                        'foremanId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                case "stock_manager":
                    echo $this->response->render(view: "_error", layout: "stock-manager-dashboard", pageParams: $errorParams, layoutParams: [
                        'employeeId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                case "office_staff_member":
                    echo $this->response->render(view: "_error", layout: "office-staff-dashboard", pageParams: $errorParams, layoutParams: [
                        'officeStaffId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                case "technician":
                    echo $this->response->render(view: "_error", layout: "technician-dashboard", pageParams: $errorParams, layoutParams: [
                        'technicianId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                case "security_officer":
                    echo $this->response->render(view: "_error", layout: "security-officer-dashboard", pageParams: $errorParams, layoutParams: [
                        'securityOfficerId' => $this->request->session->get('user_id'),
                        "pageMainHeading" => "Error"
                    ]);
                    exit;
                default:
                    echo "Error Occurred";
            }
        }
    }

    private function getHumanFriendlyErrorCode(int | string $code): int | string
    {

        $isDev = $_ENV["MODE"] === "development";
        //if $code is common http error code, return $code, otherwise return 500
        if ($isDev) {
            return $code;
        } else {
            if(is_string($code)){
                return 500;
            }
            return $code >= 400 && $code < 600 ? $code : 500;
        }
    }

}