<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Appointment;
use app\models\JobCard;
use app\models\Service;
use app\models\Foreman;
use JsonException;

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

    public function getAllAppointmentsDetails(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "security_officer") {

            $query = $req->query();

            //for search
            $searchTermRegNo = $query['regno'] ?? null;
            $searchTermDate = $query['date'] ?? null;

            //for pagination
            $limit = (isset($query['limit']) && is_numeric($query['limit'])) ? (int)$query['limit']:2;
            $page = (isset($query['page']) && is_numeric($query['page'])) ? (int)$query['page'] : 1;

           $appointmentModel = new Appointment();

           $result = $appointmentModel->getAppointments(
                count: $limit,
                page: $page,
                searchTermRegNo: $searchTermRegNo,
                searchTermDate: $searchTermDate,
           );

            return $res->render(view: "security-officer-dashboard-view-appointment", layout: "security-officer-dashboard", pageParams: [
                "appointments" => $result['appointments'],
                'total' => $result['total'],
                'limit' => $limit,
                'page' => $page], layoutParams: [
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
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            $appointmentModel = new Appointment();
            $appointments = $appointmentModel->getAllAppointments(count: $limit, page: $page);
            $officeUserId = $req->session->get('user_id');

            return $res->render(view: "office-staff-dashboard-appointments-page", layout: "office-staff-dashboard",
                pageParams: [
                    "appointments" => $appointments,
                    "total"=>$appointments['total'],
                    "limit"=>$limit,
                    "page"=>$page
                ],
                layoutParams: [
                    "title" => "Appointments",
                    "pageMainHeading" => "Appointments",
                    'officeStaffId' => $officeUserId
                ]);
        }

        return $res->redirect(path: "/login");
        
    }

    /**
     * @throws JsonException
     */
    public function getForemen(Request $req, Response $res) : string {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $foremanModel = new Foreman();
            $foremen = $foremanModel->getAvailableForemen();
            
            if(is_string($foremen)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            $res->setStatusCode(200);
            return $res->json($foremen);
        }

        $res->setStatusCode(401);
        return $res->json([
            "message" => "You're unauthorized to perform this action"
        ]);
    }

    /**
     * @throws JsonException
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

    public function officeCreateAppointment(Request $req, Response $res): string {
        $body = $req->body();
        $appointment = new Appointment($body);
        $result = $appointment->officeCreateAppointment();

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
                "success" => "Appointment created successfully"
            ]);
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function officeDeleteAppointment(Request $req, Response $res):string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member")) {

            $body= $req->body();
            if(empty($body['appointment_id'])){
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message"=> "Bad Request"
                ]);
            }
            $appointment_id=$body['appointment_id'];
            $appointmentModel=new Appointment();
            $result=$appointmentModel->deleteAppointmentById(id: $appointment_id);


            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            if ($result) {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Appointment deleted successfully"
                ]);

            }
        }

        return $res->redirect(path: "/login");
    }

    public function officeUpdateAppointment(Request $req, Response $res): string {
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
    }
}

