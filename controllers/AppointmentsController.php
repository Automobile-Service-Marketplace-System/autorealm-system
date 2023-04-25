<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Appointment;
use app\models\Service;

class AppointmentsController
{
    public function getCheckAppointmentPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            return $res->render(view: "security-officer-dashboard-check-qrcode", layout: "security-officer-dashboard", layoutParams: [
                "title" => "Check QR code",
                "pageMainHeading" => "Check QR code",
                "employeeId" => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/login");

    }

    public function getSecurityAppointments(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
//            $appointmentModel = new Appointment();
//            $appointments = $appointmentModel->getAppointments();

            return $res->render(view: "security-officer-dashboard-view-appointment", layout: "security-officer-dashboard", pageParams: [
               ], layoutParams: [
                "title" => 'Appointments',
                'pageMainHeading' => 'Appointments',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getAppointmentsPageForCustomer(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");

            return $res->render(view: "customer-dashboard-appointments", layout: "customer-dashboard", layoutParams: [
                "title" => 'My Appointments',
                'pageMainHeading' => 'My Appointments',
                'customerId' => $customerId,
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getCreateAppointmentPage(Request $req, Response $res): string
    {
        {
            if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

                $query = $req->query();
                $appointmentModel = new Appointment();
                $appointment = $appointmentModel->getOwnerInfo((int)$query["id"]);

                $modelService = new Service();
                $rawServices = $modelService->getServices();
                $services = [];
                foreach ($rawServices as $rawService) {
                    $services[$rawService['ID']] = $rawService['Name'];
                }

                return $res->render(view: "office-staff-dashboard-create-appointment", layout: "office-staff-dashboard",
                    pageParams: [
                        "appointment" => $appointment,
                        "services" => $services],
                    layoutParams: [
                        'title' => 'Create an appointment',
                        'pageMainHeading' => 'Create an appointment',
                        'employeeId' => $req->session->get('user_id')
                    ]);
            }

            return $res->redirect(path: "/employee-login");

        }
    }

    public function getOfficeAppointmentsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $appointmenteModel = new Appointment();
            $appointments = $appointmenteModel->getAllAppointments();

            return $res->render(view: "office-staff-dashboard-appointments-page", layout: "office-staff-dashboard",
                pageParams: [
                    "appointments" => $appointments
                ],
                layoutParams: [
                    "title" => "Appointments",
                    "pageMainHeading" => "Appointments",
                    'employeeId' => $req->session->get('user_id')
                ]);
        }

        return $res->redirect(path: "/employee-login");

    }

}