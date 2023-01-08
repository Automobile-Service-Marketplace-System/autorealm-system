<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Vehicle;
use app\models\Appointment;

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

    public function getCreateAppointmentPage(Request $req, Response $res)
    {
        {
            if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

                $query = $req->query();
                $appointmentModel = new Appointment();
                $appointment = $appointmentModel->getOwnerInfo((int) $query["id"]);

                return $res->render(view: "office-staff-dashboard-get-appointment-for-customer", layout: "office-staff-dashboard",
                pageParams: ["appointment"=>$appointment],
                layoutParams: [
                    'title' => 'Create an appointment',
                    'pageMainHeading' => 'Create an appointment',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
            }
    
            return $res->redirect(path:"/employee-login");
    
        }
    }

}
