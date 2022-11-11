<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;

class AuthenticationController
{
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
        return $res->render("customer-signup");
    }


    public function registerCustomer(Request $req, Response $res) : string {
        $body = $req->body();


        $customer = new Customer($body);
        $errors = $customer->validateRegisterBody();

        if(empty($errors)) {
            $result = $customer->register();
            if($result) {
                $res->render("home");
            } else {
                $res->render("customer-signup", "main", [
                    "errors" => $errors
                ]);
            }
        } else {
            return $res->render(view:"customer-signup", pageParams: [
                'errors' => $errors
            ]);
        }

        return "Registering customer";
    }
}