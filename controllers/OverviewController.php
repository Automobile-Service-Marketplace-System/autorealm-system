<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class OverviewController{
    public function getOverviewPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="admin"){
            return $res->render(view:"admin-dashboard-overview", layout:"admin-dashboard",layoutParams:[
                "title"=>"Overview",
                "pageMainHeading"=>"Overview",
                "employeeId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }

    public function getofficeStaffOverviewPage(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="office_staff_member"){
            return $res->render(view:"officeSatff-dashboard-overview", layout:"office-staff-dashboard",layoutParams:[
                "title"=>"Overview",
                "pageMainHeading"=>"Overview",
                "officeStaffId"=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }
}