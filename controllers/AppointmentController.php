<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class AppointmentController
{
    public function getAppointmentPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            return $res->render(view:"security-officer-dashboard-check-qrcode", layout:"security-officer-dashboard", layoutParams:[
                "title" => "Check QR code",
                "pageMainHeading" => "Check QR code",
                "securityOfficerId" => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path:"/employee-login");

    }

}
