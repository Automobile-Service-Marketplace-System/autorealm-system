<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Appointment;

class AppointmentsController
{
    public function getAppointmentPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            return $res->render(view: "security-officer-dashboard-check-qrcode", layout: "security-officer-dashboard", layoutParams: [
                "title" => "Check QR code",
                "pageMainHeading" => "Check QR code",
                "securityOfficerId" => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/login");

    }

    public function getAppointmentDetails(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
            $appointmentModel = new Appointment();
            $appointments = $appointmentModel->getAppointments();

            return $res->render(view: "security-officer-dashboard-view-appointment", layout: "security-officer-dashboard", pageParams: [
                "appointments" => $appointments], layoutParams: [
                "title" => 'Appointments',
                'pageMainHeading' => 'Appointments',
                'securityOfficerId' => $req->session->get("user_id"),
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
}