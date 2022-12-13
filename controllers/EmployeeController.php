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

    public function registerEmployee(Request $req, Response $res): string
    {
        $body = $req->body();
        $employee = new Employee($body);
        $result = $employee->register();

        if (is_array($result)) {
            return $res->render(view: "employee-signup", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        }

        if ($result) {
            return $res->redirect("/login?success=1");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }
}