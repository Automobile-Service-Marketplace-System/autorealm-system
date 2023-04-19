<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admitting;

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
            return $res->render(view: "security-officer-dashboard-view-admitting-reports", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Admitting Reports",
                "pageMainHeading"=>"Admitting Reports",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }


    public function viewAdmittingReportDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-view-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Admitting Report #23",
                "pageMainHeading"=>"Admitting Report #23",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
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
                    'empoyeeId'=> $req->session->get("user_id")
                ]);
            }
            if ($result) {
                return $res->redirect("/security-officer-dashboard/admitting-reports/view");
            }

            return $res->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
    }
}