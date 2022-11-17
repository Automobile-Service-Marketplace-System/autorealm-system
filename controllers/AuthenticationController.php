<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Officestaff;

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

    public function getOfficestaffLoginPage(Request $req, Response $res):string
    {
        return $res->render(view: "officestaff-login", layout: "plain");
    }

    public function loginOfficestaff(Request $req, Response $res): string
    {
        $body = $req->body();
        $officestaff = new Officestaff($body);
        $result = $officestaff ->login();
        if(is_array($result)){
            return $res->render(view: "officestaff-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);
        } else {
            if($result) {
                // reaches when office staff successful logged in
                $req->session->set("is_authenticated", true);
                $req->session->set("user_id", $result->employee_id);
                $req->session->set("user_role", "office_staff_member");
                return $res->redirect(path: "/dashboard/profile");
            } {
                return $res->render("500", "error", [
                    "error" => "Something went wrong. Please try again later."
                ]);
            }
        }
    }
}