<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class EmployeeController
{
    public function getCreateEmployeePage(Request $req, Response $res): string
    {
        return $res->render("create-employee", layout: "admin-dashboard", layoutParams: [
            "title" => "Create an employee",
        ]);
    }

}