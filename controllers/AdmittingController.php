<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admitting;
use Exception;

class AdmittingController{
    public function getCreateAdmittingReportPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Create admitting report",
                "pageMainHeading"=>"Create Admitting Report",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function getAdmittingReportsDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){

            $admittingReport=new Admitting();
            $admittingReports=$admittingReport->getAdmittingReports();
            
            return $res->render(view: "security-officer-dashboard-view-admitting-reports", layout:"security-officer-dashboard", pageParams:[
                "admittingReports"=>$admittingReports],layoutParams:[
                "title"=>"Admitting Reports",
                "pageMainHeading"=>"Admitting Reports",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function viewAdmittingReportDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            $body=$req->body();
            $query=$req->query();
            $admittingReportModel=new Admitting();
            $admittingReport=$admittingReportModel->getAdmittingReportbyId((int)($query["id"]));
            // var_dump($admittingReport);
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
            $admittingReport=new Admitting($body);
            $employeeId=$req->session->get("user_id");
            $result=$admittingReport->addAdmittingReport($employeeId);
            
            if (is_array($result)) {
                return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard", pageParams: [
                    'errors' => $result,
                    'body' => $body
                ], layoutParams: [
                    "title" => "Create an admitting report",
                    'pageMainHeading' => 'Create an admitting report',
                    'employeeId'=> $req->session->get("user_id")
                ]);
            }


            if (is_int($result)) {
                return $res->redirect("/security-officer-dashboard/admitting-reports/view?id=$result");
            }
            throw new Exception("Internal Server Error");
        }
        return $res->redirect("/login");
    }
}