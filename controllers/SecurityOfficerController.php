<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\SecurityOfficer;

class SecurityOfficerController
{
    public function getSecurityOfficerLoginPage(Request $request, Response $response):string{
        return $response->render(view: "security-officer-login", layout: "plain");
    }

    public function loginSecurityOfficer(Request $request, Response $response):string{
        $body=$request->body();
        $employee=new SecurityOfficer($body);
        $result=$employee->login();
        if(is_array($result)){
            return $response->render(view: "security-officer-login", layout: "plain", pageParams: [
                "errors"=>$result,
                'body'=>$body
            ]);

        }
        else{
            if($result){
                $request->session->set("is-authenticated",true); //$_SESSION["is-authenticated"] = true
                $request->session->set("user_id",$result->employee_id);
                $request->session->set("user_role","security-officer");
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