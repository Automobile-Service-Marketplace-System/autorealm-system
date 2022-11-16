<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class EmployeeController
{
    public function getEmployeeSignupForm(Request $req, Response $res): string
    {
        return $res->render("employee-signup", layout: "plain", layoutParams: [
            "title" => "Register",
        ]);
    }
}