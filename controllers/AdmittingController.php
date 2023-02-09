<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class AdmittingController{
    public function getCreateAdmittingReportPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-admitting-report", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"getAdmittingReports",
                "pageMainHeading"=>"Create Admitting Report",
                "securityOfficerId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function getAdmittingReportsDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            return $res->render(view: "security-officer-dashboard-view-admitting-reports", layout:"security-officer-dashboard",layoutParams:[
                "title"=>"viewAdmittingReports",
                "pageMainHeading"=>"Admitting Reports",
                "securityOfficerId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }
}