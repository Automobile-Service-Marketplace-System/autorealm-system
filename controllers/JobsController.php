<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\JobCard;
use app\models\InspectionCondition;
use app\models\Appointment;
use app\models\Foreman;

class JobsController
{

    public function getJobsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "foreman" || $req->session->get("user_role") === "admin")) {

            $jobCardModel = new JobCard();
            // get all job cards
            $jobCards = $jobCardModel->getAllJobsByForemanID(foremanId: $req->session->get("user_id"));

            if ($req->session->get("user_role") === "foreman") {
                return $res->render(view: "foreman-dashboard-jobs", layout: "foreman-dashboard", pageParams: [
                    'jobs' => $jobCards,
                ], layoutParams: [
                    'title' => 'Assigned Jobs',
                    'pageMainHeading' => 'Assigned Jobs',
                    'foremanId' => $req->session->get("user_id"),
                ]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "foreman-dashboard-jobs", layout: "admin-dashboard", pageParams: [
                    'jobs' => $jobCards,
                ], layoutParams: [
                    'title' => 'Assigned Jobs',
                    'pageMainHeading' => 'Assigned Jobs',
                    'employeeId' => $req->session->get("user_id"),
                ]);
            }

        }
        return $res->redirect(path: "/login");
    }

    public function viewJobPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            $formCreated = isset($query["form_created"]) && $query["form_created"] === "true";

            $jobCardModel = new JobCard();
            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $query["id"]);

            $suggestions = [
                "services" => [
                    "Head Light replacing",
                    "Head Light replacing",
                    "Head Light replacing",
                    "Head Light replacing",
                    "Head Light replacing",

                ],
                "products" => [
                    "Head Lights",
                    "Head Lights",
                    "Head Lights",
                    "Head Lights",
                    "Head Lights",
                ]
            ];
            if (!$formCreated) {
                $suggestions = [];
            }
            return $res->render(view: "foreman-dashboard-view-job", layout: "foreman-dashboard", pageParams: [
                'jobId' => $query['id'],
                'suggestions' => $suggestions,
                'vehicleDetails' => $result,
            ], layoutParams: [
                'title' => "Job #{$query['id']}",
                'pageMainHeading' => "Job #{$query['id']}",
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }


    public function getCreateInspectionReportPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            $conditionModel = new InspectionCondition();
            $conditions = $conditionModel->getConditions();
            $jobCardModel = new JobCard();
            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $query["job_id"]);

            return $res->render(view: "foreman-dashboard-inspection-reports-create", layout: "foreman-dashboard", pageParams: [
                "conditions" => $conditions,
                "vehicleDetails" => $result,
            ], layoutParams: [
                'title' => "Maintenance Inspection report for job #{$query['job_id']}",
                'pageMainHeading' => "Maintenance Inspection report for job #{$query['job_id']}",
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function createInspectionReport(Request $req, Response $res): string
    {
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        echo "hello";
        return "";
    }

    public function getCreateJobCardPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $appointmentModel = new Appointment();
            $appointmentInfo = $appointmentModel->getAppointmentInfo((int)$query["id"]);

            $foremanModel = new Foreman();
            $foremanInfo = $foremanModel->getForemanAvailability();

            return $res->render(view: "office-staff-dashboard-jobcard-page", layout: "office-staff-dashboard",
                pageParams: [
                    "appointmentInfo" => $appointmentInfo,
                    "foremanAvailability" => $foremanInfo
                ],
                layoutParams: [
                    "title" => "Job Card",
                    "pageMainHeading" => "Create a JobCard",
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }

        return $res->redirect(path: "/employee-login");

    }

    public function getListOfJobsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "foreman" || $req->session->get("user_role") === "admin")) {

            if ($req->session->get("user_role") === "foreman") {
                return $res->render(view: "foreman-dashboard-all-jobs", layout: "foreman-dashboard", layoutParams: [
                    'title' => 'All Jobs',
                    'pageMainHeading' => 'All Jobs',
                    'foremanId' => $req->session->get("user_id"),
                ]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "foreman-dashboard-all-jobs", layout: "admin-dashboard", layoutParams: [
                    'title' => 'All Jobs',
                    'pageMainHeading' => 'All Jobs',
                    'employeeId' => $req->session->get("user_id"),
                ]);
            }

        }
        return $res->redirect(path: "/login");
    }
}