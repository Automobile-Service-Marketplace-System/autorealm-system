<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class EmployeeController
{
    public function getCreateEmployeePage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {
            return $res->render(view: "create-employee", layout: "admin-dashboard", layoutParams: [
                'title' => 'Create an employee',
                'pageMainHeading' => 'Create an employee',
                'adminId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/employee-login");

    }

}