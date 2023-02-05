<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Vehicle;
use app\models\Appointment;
use app\models\Service;

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

        return $res->redirect(path:"/login");

    }

    public function getCreateAppointmentPage(Request $req, Response $res)
    {
        {
            if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

                $query = $req->query();
                $appointmentModel = new Appointment();
                $appointment = $appointmentModel->getOwnerInfo((int) $query["id"]);

                $modelService= new Service();
                $rawServices = $modelService->getServices();
                $services = [];
                foreach ($rawServices as $rawService) {
                    $services[$rawService['ID']] = $rawService['Name'];
                }

                return $res->render(view: "office-staff-dashboard-get-appointment-for-customer", layout: "office-staff-dashboard",
                pageParams: [
                    "appointment"=>$appointment,
                    "service"=>$services],
                layoutParams: [
                    'title' => 'Create an appointment',
                    'pageMainHeading' => 'Create an appointment',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
            }
    
            return $res->redirect(path:"/employee-login");
    
        }
    }

    public function getAppointmentsPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $appointmenteModel = new Appointment();
            $appointments = $appointmenteModel->getAppointments();

            return $res->render(view:"office-staff-dashboard-appointments-page", layout:"office-staff-dashboard",
            pageParams:[
                "appointments"=>$appointments
            ],
            layoutParams:[
                "title" => "Appointments",
                "pageMainHeading" => "Appointments",
                'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path:"/employee-login");

    }

    public function getCreateJobCardPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req -> query();
            $appointmenteModel = new Appointment();
            $appointmentInfo = $appointmenteModel->getAppointmentInfo((int) $query["id"]);

            return $res->render(view:"office-staff-dashboard-jobcard-page", layout:"office-staff-dashboard",
            pageParams:[
                "appointmentInfo"=>$appointmentInfo
            ],
            layoutParams:[
                "title" => "Job Card",
                "pageMainHeading" => "Create a JobCard",
                'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path:"/employee-login");

    }


    public function getAppointmentDetails(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="security_officer"){
            $appointmentModel=new Appointment();
            $appointments=$appointmentModel->getAppointments();

            return $res->render(view: "security-officer-dashboard-view-appointment",layout:"security-officer-dashboard",pageParams:[
                    "appointments"=>$appointments],layoutParams:[
                    "title"=>'Appointments',
                    'pageMainHeading'=>'Appointments',
                    'securityOfficerId'=>$req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path:"/login");
    }
}
