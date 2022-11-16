<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Employee;

class AuthenticationController
{
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
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
                $req->session->set("customer", $result);
                return $res->redirect("/dashboard/overview");
            } else {
                return $res->render("500", "error", [
                    "error" => "Something went wrong. Please try again later."
                ]);
            }
        }

    }

    public function getAdminLoginPage(Request $request, Response $response):string{
        return $response->render(view: "admin-login", layout: "plain");
    }

    public function loginAdmin(Request $request, Response $response):string{
        $body=$request->body();
        $employee=new Employee($body);
        $result=$employee->login();
        if(is_array($result)){
            return $response->render(view: "admin-login", layout: "plain", pageParams: [
                "errors"=>$result
            ]);

        }
        else{
            echo "Successfully logged in";
        }
        return '';
    }


}