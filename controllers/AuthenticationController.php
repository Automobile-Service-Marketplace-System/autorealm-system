<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class AuthenticationController
{
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
        return $res->render("customer-signup");
    }


    public function registerCustomer(Request $req, Response $res) : string {
        $body = $req->body();
        echo $body['f_name'];

        return "Registering customer";
    }
}