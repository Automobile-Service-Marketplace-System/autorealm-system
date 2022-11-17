<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Stockmanager;
use app\models\Employee;

class AuthenticationController
{
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "customer") {
            return $res->redirect("/dashboard/profile");
        }
        return $res->render("customer-signup", layoutParams: [
            "title" => "Register",
        ]);
    }


    public function registerCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->register();

        if (is_array($result)) {
            return $res->render(view: "customer-signup", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        } else {
            if ($result) {
                return $res->redirect("/login?success=1");
            } else {
                return $res->render("500", "error", [
                    "error" => "Something went wrong. Please try again later."
                ]);
            }
        }
    }


    public function getCustomerLoginForm(Request $req, Response $res): string
    {
        return $res->render(view: "customer-login", layoutParams: [
            'title' => 'Login'
        ]);
    }

    public function loginCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->login();
        if (is_array($result)) {
            return $res->render(view: "customer-login", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        } else {

            if ($result) {
                // only reaches here if the customer's login attempt is successful
                $req->session->set("is_authenticated", true); // $_SESSION['is_authenticated'] = true;
                $req->session->set("user_id", $result->customer_id); // `$_SESSION['user_id'] = $result->customer_id;
                $req->session->set("user_role", "customer"); // $_SESSION['user_role'] = "customer";
                return $res->redirect(path: "/dashboard/profile"); // header("Location: /dashboard/profile");
            } else {
                return $res->render("500", "error", [
                    "error" => "Something went wrong. Please try again later."
                ]);
            }
        }

    }


    public function getStockmanagerLoginPage(Request $req, Response $res): string
    {
        return $res->render(view: "stockmanager-login", layout: "plain", layoutParams: [
            'title' => 'Stock manager Login'
        ])
            ;
    }

    public function stockmanagerLogin(Request $req, Response $res): string
    {
        $body= $req->body();

        $stockManager= New Stockmanager($body);

        $result=$stockManager->login();
        if(is_array($result)) {
            return $res->render(view: "stockmanager-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);
        } else {

            if ($result) {

                $req->session->set("is_authenticated", true);
                $req->session->set("user_id", $result->employee_id);
                $req->session->set("user_role", "stock_manager");
                return $res->redirect(path: "/stock_manager/profile");
            } else {
                return $res->render("500", "error", [
                    "error" => "Something went wrong. Please try again later."
                ]);
            }
        }



    }

    public function logoutCustomer(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") == "customer") {
            $req->session->destroy();
            return $res->redirect(path: "/");
        }
    }
    public function getAdminLoginPage(Request $request, Response $response): string
    {

        return $response->render(view: "admin-login", layout: "plain");
    }

    public function loginAdmin(Request $request, Response $response): string
    {
        $body = $request->body();
        $employee = new Employee($body);
        $result = $employee->login();
        if (is_array($result)) {
            return $response->render(view: "admin-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);

        } else {
            echo "Successfully logged in";
        }
        return '';
    }


}