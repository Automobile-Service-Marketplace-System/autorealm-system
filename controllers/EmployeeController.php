<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Employee;

class EmployeeController
{
    public function getCreateEmployeePage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {
            return $res->render(view: "admin-dashboard-create-employee", layout: "admin-dashboard", layoutParams: [
                'title' => 'Create an employee',
                'pageMainHeading' => 'Create an employee',
                'employeeId'=> $req->session->get("user_id")
            ]);
        }
        return $res->redirect(path: "/employee-login");

    }

    public function getViewEmployeesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {
            return $res->render(view: "admin-dashboard-view-employees", layout: "admin-dashboard", layoutParams: [
                'title' => 'Employees',
                'pageMainHeading' => 'Employees',
                'employeeId'=> $req->session->get("user_id")
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
            return $res->render(view: "admin-dashboard-create-employee", layout: "admin-dashboard", pageParams: [
                'errors' => $result,
                'body' => $body
            ], layoutParams: [
                "title" => "Create an employee",
                'pageMainHeading' => 'Create an employee',
                'employeeId'=> $req->session->get("user_id")
            ]);
        }

        if ($result) {
            return $res->redirect("/admin-dashboard/employees");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }
}
