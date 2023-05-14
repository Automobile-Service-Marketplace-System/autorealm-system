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

 
    public function getEmployeeCountData(Request $req, Response $res):string{
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin" ) {
            $employeeModel = new Employee;
            $employeeCount = $employeeModel -> getEmployeeCount();
            if(is_string($employeeCount)){
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);               
            }
            $res->setStatusCode(200);
            return $res->json([
                "message" => "Success",
                "data" => $employeeCount
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "Unauthorized"
        ]);
    }

    public function getViewEmployeesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin" ) {

            $query = $req->query();

            //for search
            $searchTermName = $query['name'] ?? null;
            $searchTermId = $query['id'] ?? null;
            $employeeRole = isset($query['role']) ? ($query['role'] == "" ? "all" : $query['role']) : "all";
            $employeeStatus = isset($query['status']) ? ($query['status'] == "" ? "active" : $query['status']) : "active";

            //for pagination
            $limit = (isset($query['limit']) && is_numeric($query['limit'])) ? (int)$query['limit']:6;
            $page = (isset($query['page']) && is_numeric($query['page'])) ? (int)$query['page'] : 1;
            $employeeModel=new Employee();

            $result=$employeeModel->getEmployees(
                count: $limit,
                page: $page,
                searchTermName: $searchTermName,
                searchTermId: $searchTermId,
                options: [
                    'employeeRole' => $employeeRole,
                    'employeeStatus' => $employeeStatus,
                ]
            );

            return $res->render(view: "admin-dashboard-view-employees", layout: "admin-dashboard", pageParams:[
                "employees"=>$result['employees'],
                'total' => $result['total'],
                'limit' => $limit,
                'page' => $page,
            
                //pasing filter option
                'searchTermName' => $searchTermName,
                'searchTermId' => $searchTermId,
                'employeeJobRole' => $employeeRole,
                'employeeStatus' => $employeeStatus
                
                ] , layoutParams: [
                'title' => 'Employees',
                'pageMainHeading' => 'Employees',
                'employeeId'=> $req->session->get("user_id")
            ]);
        }
        return $res->redirect(path: "/login"); 

    }

    public function registerEmployee(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin" ) {
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
        return $res->redirect(path: "/login");
    }

    public function getEditEmployeePage(Request $req, Response $res):string{
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin" ) {
            $body = $req->body();
            $query=$req->query();
            $employeeModel=new Employee();
            $employee=$employeeModel->getEmployeeById((int)$query["employee_id"]);
            return $res->render(view: "admin-dashboard-edit-employees", layout: "admin-dashboard", pageParams: [
                'employee' => $employee,
                'body' => $body
            ],layoutParams: [
                'title' => 'Manage Employees',
                'pageMainHeading' => 'Update employee profile',
                'employeeId'=> $req->session->get("user_id")
            ]); 
        }   
        return $res->redirect(path: "/login");    
    }

    public function editEmployee(Request $req, Response $res):string{
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin" ) {
        
            $body = $req->body();
            $query= $req->query();
            $employeeId = $query["id"] ?? null;
            // var_dump($employeeId);
            $before_job_role=$query['job_role'] ?? null;
            // var_dump(($before_job_role));
            if(!$employeeId){
                return $res->redirect("/employees");
            }
            $employeeModel=new Employee($body);
            // var_dump($body['job_role']);
            $result=$employeeModel->update((int) $employeeId, $body['job_role'], $before_job_role);
            // var_dump($result);
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
        return $res->redirect(path: "/login");
    }

    public function deleteEmployees(Request $req, Response $res):string{
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin"){
            $body=$req->body();
            if (empty($body['employee_id'])) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }

            $ID = $body['employee_id'];
            $employeeModel = new Employee();
            $result = $employeeModel->deleteEmployeeById($ID);


            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            if ($result) {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Employee deleted successfully"
                ]);
            }
        }

        return $res->redirect(path: "/login");
    }
}
