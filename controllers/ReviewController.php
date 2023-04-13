<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Product;
use app\models\Reviews;

class ReviewController
{
    public function getReviewsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {
//            $reviewModel = new Reviews();
//            $reviews = $reviewModel->getReviews();

            if($req->session->get("user_role") === "stock_manager"){
                return $res->render(view: "stock-manager-dashboard-view-reviews", layout: "stock-manager-dashboard",
                pageParams: [],
                layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
            }

            if($req->session->get("user_role") === "admin"){
                return $res->render(view: "stock-manager-dashboard-view-reviews", layout: "admin-dashboard",
                    pageParams: [],
                    layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
            }

        }

        return $res->redirect(path: "/login");

    }
}