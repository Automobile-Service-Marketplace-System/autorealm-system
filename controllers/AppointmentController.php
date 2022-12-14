<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class AppointmentController
{
    public function getAppointmentPage(Request $req, Response $res): string
    {
        if($req->$_SESSION)
        return $res->render(view: "security-officer-dashboard-check-qrcode", layout: "security-officer-dashboard", layoutParams: [

            "title" => "Create an employee",
            "pageMainHeading" => "Check QR code"

        ]);
    }

}