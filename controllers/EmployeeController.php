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
        return $res->redirect(path: "/login");

    }

    public function getViewEmployeesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

            $employeeModel=new Employee();
            $employees=$employeeModel->getEmployees();

            return $res->render(view: "admin-dashboard-view-employees", layout: "admin-dashboard", pageParams:[
                "employees"=>$employees], layoutParams: [
                'title' => 'Employees',
                'pageMainHeading' => 'Employees',
                'employeeId'=> $req->session->get("user_id")
            ]);
        }
        return $res->redirect(path: "/login"); 

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
            return $res->redirect("/employees");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function getEditEmployeePage(Request $req, Response $res):string{
        $body = $req->body();
        $query=$req->query();
        var_dump($query);
        $employeeModel=new Employee();
        $employee=$employeeModel->getEmployeeById((int)$query["employee_id"]);
        // var_dump((int)$query["employee_id"]);
        // $GLOBALS['emp_id']=(int)$query["employee_id"];
        return $res->render(view: "admin-dashboard-edit-employees", layout: "admin-dashboard", pageParams: [
            'employee' => $employee,
            'body' => $body
        ],layoutParams: [
            'title' => 'Manage Employees',
            'pageMainHeading' => 'Update employee profile',
            'employeeId'=> $req->session->get("user_id")
        ]);        
    }

    public function editEmployee(Request $req, Response $res):string{
        $body = $req->body();
        $query=$req->query();
        $employee = new Employee($body);
        $result = $employee->update();
        if (is_array($result)) {
            return $res->render(view: "admin-dashboard-edit-employee", layout: "admin-dashboard", pageParams: [
                'errors' => $result,
                'body' => $body
            ], layoutParams: [
                "title" => "Update an employee",
                'pageMainHeading' => 'Update an employee',
                'employeeId'=> $req->session->get("user_id")
            ]);
        }

        if ($result) {
            return $res->redirect("/employees");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }
}
