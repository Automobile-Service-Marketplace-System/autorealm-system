<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admitting;
use Exception;

class AdmittingController{
    public function getCreateAdmittingReportPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            $query= $req->query();
            $regNo = $query['reg_no'] ?? null;
            return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Create admitting report",
                "pageMainHeading"=>"Create Admitting Report",
                "employeeId"=>$req->session->get("user_id"),
            ], pageParams:[
                "reg_no" => $regNo
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function getAdmittingReportsDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){

            $query = $req->query();

            //for pagination
            $limit = (isset($query['limit']) && is_numeric($query['limit'])) ? (int)$query['limit'] : 4;
            $page = (isset($query['page']) && is_numeric($query['page'])) ? (int)$query['page'] : 1;

            //for search
            $searchTermRegNo = $query['regNo'] ?? null;
            $AdmittingDate = isset($query['admitting_date']) ? ($query['admitting_date'] == "" ? "all" : $query['admitting_date']) : "all";
            $AdmittingApprove = isset($query['approve']) ? ($query['approve'] == "" ? "not_approved" : $query['approve']) : "not_approved";

            $admittingReport=new Admitting();

            $results=$admittingReport->getAdmittingReports(
                count: $limit,
                page: $page,    
                searchTermRegNo: $searchTermRegNo,
                options: [
                    'admitting_date' => $AdmittingDate,
                    'approve' => $AdmittingApprove,
                ]
            );
            
            return $res->render(view: "security-officer-dashboard-view-admitting-reports", layout:"security-officer-dashboard", pageParams:[
                "admittingReports"=> $results['admittingReports'],
                'total' => $results['total'],
                'limit' => $limit,
                'page' => $page,
            
                //pasing filter option
                'searchTermRegNo' => $searchTermRegNo,
                'admitting_date' => $AdmittingDate,
                'approve' => $AdmittingApprove
                
                ],layoutParams:[
                "title"=>"Admitting Reports",
                "pageMainHeading"=>"Admitting Reports",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function approveAdmittingReportPage(Request $req, Response $res):string{
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            $body=$req->body();
            var_dump($body['report_no']);
            if (empty($body['report_no'])) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }

            $ID = $body['report_no'];
            $admittingModel = new Admitting();
            $result = $admittingModel->approveReport($ID);


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
    public function viewAdmittingReportDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            // $body=$req->body();
            $query=$req->query();
            $admittingReportModel=new Admitting();
            $admittingReport=$admittingReportModel->getAdmittingReportbyId((int)($query["id"]));
            return $res->render(view: "security-officer-dashboard-view-admitting-report-details", layout:"security-officer-dashboard", pageParams:[
                "admittingReport"=>$admittingReport], 
                layoutParams:[
                "title"=>"Admitting Reports",
                "pageMainHeading"=>"Admitting Report",
                "employeeId"=>$req->session->get("user_id"),
            ]);            
        }
    }

    public function addAdmittingReportPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            $body=$req->body(); 
            $query= $req->query();
            $regNo = $query['reg_no'] ?? null;
            $admittingReport=new Admitting($body);
            $employeeId=$req->session->get("user_id");
            $result=$admittingReport->addAdmittingReport($employeeId);
            // var_dump($result);
            // exit();
            
            if (is_array($result)) {
                return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard", pageParams: [
                    'errors' => $result,
                    'body' => $body,
                    'reg_no' => $regNo
                ], layoutParams: [
                    "title" => "Create an admitting report",
                    'pageMainHeading' => 'Create an admitting report',
                    'employeeId'=> $req->session->get("user_id")
                ]);
            }

            if (is_int($result)) {
                // return $res->redirect("/security-officer-dashboard/admitting-reports/view?id=$result");
                return $res->redirect("/security-officer-dashboard/view-admitting-reports");
            }
            throw new Exception("Internal Server Error");
        }
        return $res->redirect("/login");
    }
}