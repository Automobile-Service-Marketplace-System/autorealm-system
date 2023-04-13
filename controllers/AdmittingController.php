<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\core\Admitting;

class AdmittingController{
    public function getCreateAdmittingReportPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Create admitting report",
                "pageMainHeading"=>"Create Admitting Report",
                "securityOfficerId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function getAdmittingReportsDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-view-admitting-reports", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Admitting Reports",
                "pageMainHeading"=>"Admitting Reports",
                "securityOfficerId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }


    public function viewAdmittingReportDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-view-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"Admitting Report #23",
                "pageMainHeading"=>"Admitting Report #23",
                "securityOfficerId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function addAdmittingReportPage(Request $req, Response $res):string{
        $body=$req->body(); 
        $admittingReport=new Admitting($body);
        $result=$admittingReport->addAdmittingReport();


    }
}