<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Appointment;
use app\models\JobCard;
use app\models\Service;
use app\models\Foreman;
use app\utils\DevOnly;
use app\utils\EmailClient;
use app\utils\EmailTemplates;
use app\utils\FSUploader;
use app\utils\S3Uploader;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Exception;
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
            $limit = (isset($query['limit']) && is_numeric($query['limit'])) ? (int)$query['limit'] : 2;
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
                'page' => $page,

                //pasing filter options 
                'searchTermRegNo' => $searchTermRegNo,
                'searchTermDate' => $searchTermDate

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
            //check authentication
            if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

                //get the query
                $query = $req->query();

                //create appointment object and get the owner details
                $appointmentModel = new Appointment();
                $appointment = $appointmentModel->getOwnerInfo((int)$query["id"]);

                //create service object and get the service details
                $modelService = new Service();
                $rawServices = $modelService->getServices();

                $services = [];

                //fill the service array
                foreach ($rawServices as $rawService) {
                    $services[$rawService['ID']] = $rawService['Name'];
                }

                //render create appointment page
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

            //if unauthorized
            return $res->redirect(path: "/login");

        }
    }

    public function getOfficeAppointmentsPage(Request $req, Response $res): string
    {
        //check authorization
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            
            //get the query
            $query = $req->query();

            //for pagination
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            //for searching
            $searchTermRegNo = $query["reg"] ?? null;
            $searchTermCustomer = $query["cus"] ?? null;

            //get all appointments 
            $appointmentModel = new Appointment();
            $appointments = $appointmentModel->getAllAppointments(
                count: $limit, 
                page: $page,
                searchTermRegNo: $searchTermRegNo,
                searchTermCustomer: $searchTermCustomer
            );

            //get user id
            $officeUserId = $req->session->get('user_id');

            //render appointment page
            return $res->render(view: "office-staff-dashboard-appointments-page", layout: "office-staff-dashboard",
                pageParams: [
                    "appointments" => $appointments,
                    "total" => $appointments['total'],
                    "limit" => $limit,
                    "page" => $page,
                    "searchTermRegNo" => $searchTermRegNo,
                    "searchTermCustomer" => $searchTermCustomer
                ],
                layoutParams: [
                    "title" => "Appointments",
                    "pageMainHeading" => "Appointments",
                    'officeStaffId' => $officeUserId
                ]);
        }

        //if unauthorized
        return $res->redirect(path: "/login");

    }

    /**
     * @throws JsonException
     */
    public function getForemen(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            
            //get all foremen details
            $foremanModel = new Foreman();
            $foremen = $foremanModel->getAvailableForemen();

            //if an error
            if (is_string($foremen)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }

            //if successful
            $res->setStatusCode(200);
            return $res->json($foremen);
        }

        //if unauthorized
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
        //check authentication
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member" || $req->session->get("user_role") === "customer")) {
            
            //create object from appointment
            $appointmentModel = new Appointment();

            //get the query data
            $date = $req->query()["date"] ?? null;

            //check the validate format
            $isValidDate = preg_match("/^\\d{4}-\\d{2}-\\d{2}$/", $date);

            //set status code
            if (!$date || !$isValidDate) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "message" => "Bad request"
                ]);
            }

            //request available time slots
            $result = $appointmentModel->getTimeslotsByDate(date: $date);

            //if an error
            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: [
                    "message" => $result
                ]);
            }

            //if successful
            $res->setStatusCode(code: 200);
            return $res->json($result);
        }

        //if unauthorized
        $res->setStatusCode(code: 401);
        return $res->json(data: [
            "message" => "Unauthorized"
        ]);
    }

    /**
     * @throws JsonException
     */
    public function officeCreateAppointment(Request $req, Response $res): string
    {
        //get the submitted data
        $body = $req->body();

        //send data to the appointment model
        $appointment = new Appointment($body);
        $result = $appointment->officeCreateAppointment();

        //if an error
        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => $result
            ]);
        }

        //set qr code
        if (is_array($result)) {
            $options = new QROptions(
                [
                    'eccLevel' => QRCode::ECC_L,
                    'outputType' => QRCode::OUTPUT_IMAGE_JPG,
                    'version' => 5,
                ]
            );

            $qrcode = (new QRCode($options))->render(json_encode([
                "date" => $body['date'],
                "timeslot" => $result['timeslot'],
                "registrationNumber" => $body["vehicle_reg_no"]
            ]));

            try {

                $qrCodeURL = S3Uploader::saveDataURLFile(dataURL: $qrcode, innerDir: "appointments/qr-codes");

                $emailHtmlContent = EmailTemplates::appointmentConfirmationTemplate(imageUrl: $qrCodeURL, date: $body['date'], timeslot: $result['timeslot']);
//                echo "$emailHtmlContent";
                $sendToEmail = $result['email'];
                $sendToName = $result['name'];

                EmailClient::sendEmail(
                    receiverEmail: $sendToEmail,
                    receiverName: $sendToName,
                    subject: "Appointment Confirmation",
                    htmlContent: $emailHtmlContent,
                    templateLess: true
                );

            } catch (Exception $e) {
                var_dump($e->getMessage());
            }

            //if successful
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Appointment created successfully"
            ]);
        }

        //if an error
        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function officeDeleteAppointment(Request $req, Response $res): string
    {
        //check authentication
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "office_staff_member")) {

            //get the submitted data
            $body = $req->body();

            //check body has appointment_id
            if (empty($body['appointment_id'])) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }

            $appointment_id = $body['appointment_id'];

            //call delete appointment method with selected appointment_id
            $appointmentModel = new Appointment();
            $result = $appointmentModel->deleteAppointmentById(id: $appointment_id);

            //if an error
            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }

            //if successful
            if ($result) {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Appointment deleted successfully"
                ]);

            }
        }

        //if unauthorized
        return $res->redirect(path: "/login");
    }
}

