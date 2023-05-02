<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\JobCard;
use app\models\InspectionCondition;
use app\models\Appointment;
use app\models\Foreman;
use app\models\MaintenanceInspectionReport;
use app\utils\DevOnly;

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

//            if ($req->session->get("user_role") === "admin") {
//                return $res->render(view: "foreman-dashboard-jobs", layout: "admin-dashboard", pageParams: [
//                    'jobs' => $jobCards,
//                ], layoutParams: [
//                    'title' => 'Assigned Jobs',
//                    'pageMainHeading' => 'Assigned Jobs',
//                    'employeeId' => $req->session->get("user_id"),
//                ]);
//            }

        }
        return $res->redirect(path: "/login");
    }

    public function viewJobPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();

            $jobCardModel = new JobCard();
            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $query["id"]);


            $inspectionReportModel = new MaintenanceInspectionReport();
            $inspectionReport = $inspectionReportModel->getJobCardInspectionReportStatus(jobId: $query["id"]);

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
            if (!$inspectionReport) {
                $suggestions = [];
            }
            return $res->render(view: "foreman-dashboard-view-job", layout: "foreman-dashboard", pageParams: [
                'jobId' => $query['id'],
                'suggestions' => $suggestions,
                'vehicleDetails' => $result,
                'inspectionReport' => $inspectionReport ? $inspectionReport : null,
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
            $jobId = $query["job_id"] ?? null;
            if (!$jobId) {
                return $res->redirect(path: "/jobs");
            }
            $conditionModel = new InspectionCondition();
            $conditions = $conditionModel->getConditions();


            $inspectionReportModel = new MaintenanceInspectionReport();
            $preparedConditions = $inspectionReportModel->getSavedConditions(body: $conditions, jobId: $jobId);
//            DevOnly::prettyEcho($result);
            $jobCardModel = new JobCard();
            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $jobId);

            return $res->render(view: "foreman-dashboard-inspection-reports-create", layout: "foreman-dashboard", pageParams: [
                "conditionsOfCategories" => $preparedConditions,
                "vehicleDetails" => $result,
                "jobId" => $jobId
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
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            $jobId = $query["job_id"] ?? null;
            if (!$jobId) {
                return "The form was not submitted properly";
            }
            $reportModel = new MaintenanceInspectionReport();
            $result = $reportModel->saveInspectionReport(jobId: $jobId, body: $req->body(), isDraft: false);
            if (is_string($result)) {
                return $result;
            }
            $res->setStatusCode(code: 201);
            return $res->redirect(path: "/jobs/view?id=$jobId");

        }
        return $res->redirect(path: "/login");
    }

    /**
     * @throws \JsonException
     */
    public function createInspectionReportDraft(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            $jobId = $query["job_id"] ?? null;
            if (!$jobId) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => "Job ID is required"
                ]);
            }
            $reportModel = new MaintenanceInspectionReport();
            $result = $reportModel->saveInspectionReport(jobId: $jobId, body: $req->body());
            if (is_string($result)) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => $result
                ]);
            }
            $res->setStatusCode(code: 201);
            return $res->json(data: [
                "success" => $result,
                "message" => "Draft saved successfully",
            ]);

        }
        return $res->redirect(path: "/login");
    }

    public function getCreateJobCardPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $appointmentModel = new Appointment();
            $appointmentInfo = $appointmentModel->getAppointmentInfo((int)$query["id"]);
            $foremanModel = new Foreman();
            $foremanInfo = $foremanModel->getForemanAvailability();

            return $res->render(view: "office-staff-dashboard-create-jobcard-page", layout: "office-staff-dashboard",
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

        return $res->redirect(path: "/login");

    }

    public function createJobCard(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $body = $req->body();
            $jobCardModel = new JobCard($body);
            $result = $jobCardModel->createJobCard();

            if ($result) {
                return $res->redirect(path: "/jobs");
            }
    
            return $res->render(view:"500", layout:"plain", pageParams:[
                "error" => "Something went wrong. Please try again later.",
            ]);

        }

    }

    public function getListOfJobsPage(Request $req, Response $res): string
    {
        $userRole = $req->session->get("user_role");
        if (($userRole === "foreman" || $userRole === "admin" || $userRole === "technician") && $req->session->get("is_authenticated")) {

            if ($req->session->get("user_role") === "foreman") {
                return $res->render(view: "foreman-dashboard-all-jobs", layout: "foreman-dashboard", layoutParams: [
                    'title' => 'All Jobs',
                    'pageMainHeading' => 'All Jobs',
                    'foremanId' => $req->session->get("user_id"),
                ]);
            }

            if ($req->session->get("user_role") === "technician") {
                return $res->render(view: "foreman-dashboard-all-jobs", layout: "technician-dashboard", layoutParams: [
                    'title' => 'All Jobs',
                    'pageMainHeading' => 'All Jobs',
                    'technicianId' => $req->session->get("user_id"),
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

    public function getAssignedJobOverviewPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {
            return $res->render(view: "technician-dashboard-assigned", layout: "technician-dashboard", layoutParams: [
                'title' => 'Current Job',
                'pageMainHeading' => "You are working on, ",
                'technicianId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getAllJobsPage(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;
            $jobCardModel = new JobCard();
            $jobCards = $jobCardModel->getAllJobs(count: $limit, page: $page);

            return $res->render(view: "office-staff-dashboard-all-jobs-page", layout: "office-staff-dashboard",
                pageParams: [
                    "jobCards"=>$jobCards,
                    "total"=>$jobCards['total'],
                    "limit"=>$limit,
                    "page"=>$page
                ],  
                layoutParams: [
                    'title' => 'Jobs',
                    'pageMainHeading' => 'Jobs',
                    'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/login");
    }
}