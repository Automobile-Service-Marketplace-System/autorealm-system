<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Appointment;
use app\models\Service;
use app\utils\DevOnly;

class AppointmentsController
{
    public function getCheckAppointmentPage(Request $req, Response $res): string
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

    public function getSecurityAppointments(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {
//            $appointmentModel = new Appointment();
//            $appointments = $appointmentModel->getAppointments();

            return $res->render(view: "security-officer-dashboard-view-appointment", layout: "security-officer-dashboard", pageParams: [
            ], layoutParams: [
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
            $appointmentModel = new Appointment();
            $appointments = $appointmentModel->getAppointmentsByCustomerID($customerId);

            return $res->render(view: "customer-dashboard-appointments", layout: "customer-dashboard",
                pageParams: [
                    "appointments" => $appointments,
                ],
                layoutParams: [
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
                        'officeStaffId' => $req->session->get('user_id')
                    ]);
            }

            return $res->redirect(path: "/login");

        }
    }

    public function getOfficeAppointmentsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $appointmentModel = new Appointment();
            $appointments = $appointmentModel->getAllAppointments();
            $officeUserId = $req->session->get('user_id');

            return $res->render(view: "office-staff-dashboard-appointments-page", layout: "office-staff-dashboard",
                pageParams: [
                    "appointments" => $appointments
                ],
                layoutParams: [
                    "title" => "Appointments",
                    "pageMainHeading" => "Appointments",
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }

        return $res->redirect(path: "/login");

    }

    /**
     * @throws \JsonException
     */
    public function getTimeSlots(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member" || $req->session->get("user_role") === "customer")) {
            $appointmentModel = new Appointment();
            $date = $req->query()["date"] ?? null;
            $isValidDate = preg_match("/^\\d{4}-\\d{2}-\\d{2}$/", $date);
            if (!$date || !$isValidDate) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "message" => "Bad request"
                ]);
            }
            $result = $appointmentModel->getTimeslotsByDate(date: $date);
            if(is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: [
                    "message" => $result
                ]);
            }
            $res->setStatusCode(code: 200);
            return $res->json($result);
        }

        $res->setStatusCode(code: 401);
        return $res->json(data: [
            "message" => "Unauthorized"
        ]);
    }

    // public function officeCreateAppointment(Request $req, Response $res): string {
    //     $body = $req->body();
    //     var_dump($body)
        // $vehicle = new Appointment($body);
        // $result = $vehicle->updateVehicle();

        // if (is_string($result)) {
        //     $res->setStatusCode(code: 500);
        //     return $res->json([
        //         "message" => $result
        //     ]);
        // }

        // if (is_array($result)) {
        //     $res->setStatusCode(code: 400);
        //     return $res->json([
        //         "errors" => $result
        //     ]);
        // }

        // if ($result) {
        //     $res->setStatusCode(code: 201);
        //     return $res->json([
        //         "success" => "Customer updated successfully"
        //     ]);
        // }

        // return $res->render("500", "error", [
        //     "error" => "Something went wrong. Please try again later."
        // ]);
    // }

    public function officeUpdateAppointment(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $body = $req->body();
            $appointment = new Appointment($body);
            $result = $appointment->officeUpdateAppointment();

            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => $result
                ]);
            }

            if (is_array($result)) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "errors" => $result
                ]);
            }

            if ($result) {
                $res->setStatusCode(code: 201);
                return $res->json([
                    "success" => "Appointment updated successfully"
                ]);
            }

            return $res->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
    }
}

