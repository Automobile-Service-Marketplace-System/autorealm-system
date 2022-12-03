<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Admin;

class AdminController
{
    public function getAdminLoginPage(Request $request, Response $response):string{
        return $response->render(view: "admin-login", layout: "plain");
    }

    public function loginAdmin(Request $request, Response $response):string{
        $body=$request->body();
        $employee=new Admin($body);
        $result=$employee->login();
        if(is_array($result)){
            return $response->render(view: "admin-login", layout: "plain", pageParams: [
                "errors"=>$result,
                'body'=>$body
            ]);

        }
        else{
            if($result){
                $request->session->set("is-authenticated",true); //$_SESSION["is-authenticated"] = true
                $request->session->set("user_id",$result->employee_id);
                $request->session->set("user_role","admin");
                return $response->redirect(path:"/dashboard/profile");
            }
            else{
                return $response->render("500","error",[
                    "error"=>"Something went wrong. Please try again later."
                ]);
            }
        }
    }
}