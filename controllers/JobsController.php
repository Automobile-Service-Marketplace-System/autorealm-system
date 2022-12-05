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
            $foremanModel = new Foreman();
            $foreman = $foremanModel->getForemanById($req->session->get("user_id"));
            return $res->render(view: "foreman-dashboard-jobs", layout: "foreman-dashboard", layoutParams: [
                'title' => 'Assigned Jobs',
                'pageMainHeading' => 'Assigned Jobs',
                'foreman' => $foreman
            ]);
        }
        return $res->redirect(path: "/employee-login");
    }
}