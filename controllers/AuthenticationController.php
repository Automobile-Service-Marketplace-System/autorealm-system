<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Stockmanager;

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
//        echo "<pre>";
//        var_dump($body);
//        echo "</pre>";

        $stockManager= New Stockmanager($body);

        $result=$stockManager->login();
        if(is_array($result)) {
            return $res->render(view: "stockmanager-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);
        }



    }
}