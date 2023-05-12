<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\JobCard;
use app\models\InspectionCondition;

//use app\models\Appointment;
//use app\models\Foreman;
use app\models\MaintenanceInspectionReport;
use app\models\Technician;
use app\utils\DevOnly;
use Exception;

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

    public function getJobsInProgressPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();

            $jobCardModel = new JobCard();
            $isInProgressJob = $jobCardModel->isInProgress(jobId: $query["id"]);
            if (!$isInProgressJob) {
                return $res->redirect(path: "/jobs/view?id={$query['id']}");
            }

            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $query["id"]);

            $jobDetails = $jobCardModel->getProductsServicesTechniciansInJob(jobId: $query["id"]);
            if (is_string($jobDetails)) {
                return "Internal Server Error";
            }
            return $res->render(view: "foreman-dashboard-view-in-progress-job", layout: "foreman-dashboard", pageParams: [
                'jobId' => $query['id'],
                'vehicleDetails' => $result,
                'products' => $jobDetails["products"],
                'services' => $jobDetails["services"],
                'technicians' => $jobDetails["technicians"],
                'all' => $jobDetails["service_status"]['all'],
                'done' => $jobDetails["service_status"]['done'],
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
                'title' => "Report for job #{$query['job_id']}",
                'pageMainHeading' => "Report for job #{$query['job_id']}",
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }


    public function getInspectionReportForJobPage(Request $req, Response $res): string
    {
        if (
            $req->session->get("is_authenticated")
            &&
            (
                $req->session->get("user_role") === "foreman"
                ||
                $req->session->get("user_role") === "technician"
                ||
                $req->session->get("user_role") === "admin"
            )
        ) {
            $query = $req->query();
            $jobId = $query["job_id"] ?? null;
            if (!$jobId) {
                return $res->redirect(path: "all-jobs/view?jobId=$jobId");
            }


            $layout = match ($req->session->get("user_role")) {
                "technician" => "technician-dashboard",
                "admin" => "admin-dashboard",
                default => "foreman-dashboard"
            };

            $userId = $req->session->get("user_id");


            $conditionModel = new InspectionCondition();
            $conditions = $conditionModel->getConditions();


            $inspectionReportModel = new MaintenanceInspectionReport();
            $preparedConditions = $inspectionReportModel->getSavedConditions(body: $conditions, jobId: $jobId);
//            DevOnly::prettyEcho($result);
//            $jobCardModel = new JobCard();
//            $result = $jobCardModel->getVehicleDetailsByJobId(jobId: $jobId);

            return $res->render(view: "employee-dashboard-inspection-report-for-job", layout: $layout, pageParams: [
                "conditionsOfCategories" => $preparedConditions,
                "jobId" => $jobId
            ], layoutParams: [
                'title' => "Inspection report for job #$jobId",
                'pageMainHeading' => "Inspection report for job #$jobId",
                'foremanId' => $userId,
                'technicianId' => $userId,
                'employeeId' => $userId
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

//    public function getCreateJobCardPage(Request $req, Response $res): string
//    {
//        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
//            $query = $req->query();
//            $appointmentModel = new Appointment();
//            $appointmentInfo = $appointmentModel->getAppointmentInfo((int)$query["id"]);
//            $foremanModel = new Foreman();
//            $foremanInfo = $foremanModel->getAvailableForemen();
//
//            return $res->render(view: "office-staff-dashboard-create-jobcard-page", layout: "office-staff-dashboard",
//                pageParams: [
//                    "appointmentInfo" => $appointmentInfo,
//                    "foremanAvailability" => $foremanInfo
//                ],
//                layoutParams: [
//                    "title" => "Job Card",
//                    "pageMainHeading" => "Create a Job card",
//                    'officeStaffId' => $req->session->get('user_id')
//                ]);
//        }
//
//        return $res->redirect(path: "/login");
//
//    }

    public function createJobCard(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $body = $req->body();
            $jobCard = new JobCard($body);
            $result = $jobCard->officeCreateJobCard();

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
                    "success" => "JobCard created successfully"
                ]);
            }

            return $res->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);

        }
        return $res->redirect(path: "/login");

    }

    /**
     * @throws Exception
     */
    public function getListOfJobsPage(Request $req, Response $res): string
    {
        $userRole = $req->session->get("user_role");
        if ($req->session->get("is_authenticated") && ($userRole === "foreman" || $userRole === "admin" || $userRole === "technician")) {

            $userId = $req->session->get("user_id");

            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 10;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            //for search and filtering
            $searchTermCustomer = $query["customer_name"] ?? null;
            $searchTermVehicleRegNo = $query["vehicle_reg_no"] ?? null;
            $searchTermForemanName = $query["foreman_name"] ?? null;
            $jobDate = $query["date"] ?? null;


            $layout = match ($userRole) {
                "admin" => "admin-dashboard",
                "technician" => "technician-dashboard",
                default => "foreman-dashboard"
            };

            $jobCarModel = new JobCard();
            $listOfJobs = $jobCarModel->getAllJobsForForemanTechnicianAndAdmin(
                count: $limit,
                page: $page,
                searchTermCustomer: $searchTermCustomer,
                searchTermVehicleRegNo: $searchTermVehicleRegNo,
                searchTermForemanName: $searchTermForemanName,
                options: [
                    "job_date" => $jobDate
                ]
            );


            if (!$listOfJobs || is_string($listOfJobs)) {
                throw new Exception("Something went wrong");
            }


            return $res->render(view: "employee-dashboard-all-jobs", layout: $layout, pageParams: [
                'jobs' => $listOfJobs['jobs'],
                'total' => $listOfJobs['total'],
                'limit' => $limit,
                'page' => $page,
                'searchTermCustomer' => $searchTermCustomer,
                'searchTermVehicleRegNo' => $searchTermVehicleRegNo,
                'searchTermForemanName' => $searchTermForemanName,
                'jobDate' => $jobDate
            ], layoutParams: [
                'title' => 'All Jobs',
                'pageMainHeading' => 'All Jobs',
                'foremanId' => $userId,
                'technicianId' => $userId,
                'employeeId' => $userId
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getAssignedJobOverviewPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {

            $userId = $req->session->get("user_id");
            $jobCardModel = new JobCard();
            $jobId = $jobCardModel->getJobIdByTechnicianId(technicianId: $userId);

            if (!$jobId || is_string($jobId)) {
                return $res->render(view: "technician-dashboard-assigned", layout: "technician-dashboard", layoutParams: [
                    'title' => 'Current Job',
                    'technicianId' => $req->session->get("user_id"),
                ]);
            }

            $vehicleDetails = $jobCardModel->getVehicleDetailsByJobId(jobId: $jobId);
            if (is_string($vehicleDetails)) {
                return "Internal Server Error";
            }

            $jobDetails = $jobCardModel->getAssignedJobServiceAndVehicleDetails(jobId: $jobId);
            if (is_string($jobDetails)) {
                return "Internal Server Error";
            }
            return $res->render(view: "technician-dashboard-assigned", layout: "technician-dashboard", pageParams: [
                "vehicleDetails" => $vehicleDetails,
                "jobDetails" => $jobDetails,
                "jobId" => $jobId,
            ], layoutParams: [
                'title' => 'Current Job',
                'pageMainHeading' => "You are working on, ",
                'technicianId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }


    public function getJobDetailsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {

            $userId = $req->session->get("user_id");
            $query = $req->query();
            $jobCardModel = new JobCard();
//            $jobId = $jobCardModel->getJobIdByTechnicianId(technicianId: $userId);
            $jobId = $query['jobId'] ? (int)$query['jobId'] : null;

            if (!$jobId) {
                return $res->render(view: "technician-dashboard-assigned", layout: "technician-dashboard", layoutParams: [
                    'title' => 'Current Job',
                    'technicianId' => $req->session->get("user_id"),
                ]);
            }

            $vehicleDetails = $jobCardModel->getVehicleDetailsByJobId(jobId: $jobId);
            if (is_string($vehicleDetails)) {
                return "Internal Server Error";
            }

            $jobDetails = $jobCardModel->getProductsServicesTechniciansInJob(jobId: $jobId);
            if (is_string($jobDetails)) {
                return "Internal Server Error";
            }
            return $res->render(view: "employee-dashboard-view-job", layout: "technician-dashboard", pageParams: [
                "vehicleDetails" => $vehicleDetails,
//                "jobDetails" => $jobDetails,
                "products" => $jobDetails['products'],
                "services" => $jobDetails['services'],
                "technicians" => $jobDetails['technicians'],
                "jobId" => $jobId,
            ], layoutParams: [
                'title' => "Job #$jobId",
                'pageMainHeading' => "View job #$jobId",
                'technicianId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getAllJobsPage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;
            $jobCardModel = new JobCard();
            $jobCards = $jobCardModel->getAllJobs(count: $limit, page: $page);

            return $res->render(view: "office-staff-dashboard-all-jobs-page", layout: "office-staff-dashboard",
                pageParams: [
                    "jobCards" => $jobCards,
                    "total" => $jobCards['total'],
                    "limit" => $limit,
                    "page" => $page
                ],
                layoutParams: [
                    'title' => 'Jobs',
                    'pageMainHeading' => 'Jobs',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }
        return $res->redirect(path: "/login");
    }

    /**
     * @throws \JsonException
     */
    public function startJob(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            DevOnly::prettyEcho($req->body());
            $body = $req->body();
            $query = $req->query();
            $jobId = $query["id"] ?? null;
            $productIds = $body["products"] ?? null;
            $serviceCodes = $body["services"] ?? null;
            $technicianIds = $body["technicians"] ?? null;
            if (!$jobId || !$productIds || !$serviceCodes || !$technicianIds) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => "Job ID, Product IDs, Service Codes and Technician IDs are required"
                ]);
            }
            $jobCardModel = new JobCard();
            $result = $jobCardModel->startJob(jobId: $jobId, productIds: $productIds, serviceCodes: $serviceCodes, technicianIds: $technicianIds);
            if (is_string($result)) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => $result
                ]);
            }
            $res->setStatusCode(code: 204);
            return $res->json(data: [
                "success" => true,
                "message" => "Job started successfully"
            ]);
        }
        return $res->redirect(path: "/login");
    }


    /**
     * @throws \JsonException
     */
    public function getAvailableTechniciansForJob(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $technicianModel = new Technician();
            $technicians = $technicianModel->getCurrentlyAvailableTechnicians();
            if (is_string($technicians)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: [
                    "success" => false,
                    "message" => $technicians
                ]);
            }
            $res->setStatusCode(code: 200);
            return $res->json(data: [
                "success" => true,
                "message" => "Available technicians fetched successfully",
                "data" => $technicians
            ]);
        }
        $res->setStatusCode(code: 401);
        return $res->json(data: [
            "success" => false,
            "message" => "You are not authorized to access this resource"
        ]);
    }


    /**
     * @throws \JsonException
     */
    public function changeJobServiceStatus(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "technician") {
            $body = $req->body();
            $jobId = $body["jobId"] ?? null;
            $serviceCode = $body["serviceCode"] ?? null;
            $status = $body["status"] ?? null;
            if (!$jobId || !$serviceCode || $status === null) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => "Job ID, Service Code and Status are required"
                ]);
            }
            $jobCardModel = new JobCard();
            $result = $jobCardModel->changeJobServiceStatus(jobId: $jobId, serviceCode: $serviceCode, status: $status, technicianId: $req->session->get("user_id"));
            if (is_string($result) || !$result) {
                $res->setStatusCode(code: 400);
                return $res->json(data: [
                    "success" => false,
                    "message" => $result
                ]);
            }
            $res->setStatusCode(code: 200);
            return $res->json(data: [
                "success" => true,
                "message" => "Job service status changed successfully",
                "data" => $result
            ]);
        }
        $res->setStatusCode(code: 401);
        return $res->json(data: [
            "success" => false,
            "message" => "You are not authorized to access this resource"
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function getJobSelectorJobs(Request $req, Response $res): string
    {

        $query = $req->query();
        $limit = isset($query['limit']) ? (int)$query['limit'] : 10;
        $page = isset($query['page']) ? (int)$query['page'] : 1;

        //for search and filtering
        $searchTermCustomer = $query["customer_name"] ?? null;
        $searchTermVehicleRegNo = $query["vehicle_reg_no"] ?? null;
        $searchTermForemanName = $query["foreman_name"] ?? null;
        $jobDate = $query["job_date"] ?? null;

        $jobCarModel = new JobCard();
        $listOfJobs = $jobCarModel->getJobDetailsForSelector(
            count: $limit,
            page: $page,
            searchTermCustomer: $searchTermCustomer,
            searchTermVehicleRegNo: $searchTermVehicleRegNo,
            searchTermForemanName: $searchTermForemanName,
            options: [
                "job_date" => $jobDate
            ]
        );


        if (!$listOfJobs || is_string($listOfJobs)) {
            $res->setStatusCode(code: 500);
            return $res->json(data: [
                "success" => false,
                "message" => $listOfJobs
            ]);
        }


        $res->setStatusCode(code: 200);
        return $res->json([
            'jobs' => $listOfJobs['jobs'],
            'total' => $listOfJobs['total'],
            'limit' => $limit,
            'page' => $page,
            'searchTermCustomer' => $searchTermCustomer,
            'searchTermVehicleRegNo' => $searchTermVehicleRegNo,
            'searchTermForemanName' => $searchTermForemanName,
            'jobDate' => $jobDate
        ]);
    }
}