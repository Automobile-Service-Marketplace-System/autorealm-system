<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Foreman;

class JobsController
{

    public function getJobsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            return $res->render(view: "foreman-dashboard-jobs", layout: "foreman-dashboard", layoutParams: [
                'title' => 'Assigned Jobs',
                'pageMainHeading' => 'Assigned Jobs',
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/employee-login");
    }

    public function viewJobPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            return $res->render(view: "foreman-dashboard-view-job", layout: "foreman-dashboard", pageParams: [
                'jobId' => $query['id'],
            ], layoutParams: [
                'title' => "Job #{$query['id']}",
                'pageMainHeading' => "Job #{$query['id']}",
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/employee-login");
    }


    public function getCreateInspectionReportPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "foreman") {
            $query = $req->query();
            return $res->render(view: "foreman-dashboard-inspection-reports-create", layout: "foreman-dashboard", layoutParams: [
                'title' => "Maintenance Inspection report for job #{$query['job_id']}",
                'pageMainHeading' => "Maintenance Inspection report for job #{$query['job_id']}",
                'foremanId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/employee-login");
    }
}