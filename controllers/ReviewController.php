<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Product;
use app\models\Reviews;
use app\utils\DevOnly;

class ReviewController
{
    public function getReviewsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            $query = $req->query();
//          for pagination
            $limit = isset($query['limit']) ? (int)$query['limit'] : 5;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

//          for searching
            $searchTermProduct = $query["product"] ?? null;
            $reviewRating = isset($query["rating"]) ? ($query["rating"] == "" ? "all" : $query["rating"]) : "all";
            $reviewDate = isset($query["date"]) ? ($query["date"] == "" ? "all" : $query["date"]) : "all";

            $reviewModel = new Reviews();
            $results = $reviewModel->getReviews(
                count: $limit,
                page: $page,
                searchTermProduct: $searchTermProduct,
                options: [
                    'rating' => $reviewRating,
                    'review_date' => $reviewDate,
                ]

            );
            // DevOnly::prettyEcho($reviews);
            if ($req->session->get("user_role") === "stock_manager") {
                return $res->render(view: "stock-manager-dashboard-view-reviews", layout: "stock-manager-dashboard",
                    pageParams: [
                        "reviews" => $results['reviews'],
                        'total' => $results['total'],
                        'limit' => $limit,
                        'page' => $page,
                    ],
                    layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "stock-manager-dashboard-view-reviews", layout: "admin-dashboard",
                    pageParams: [],
                    layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
            }

        }

        return $res->redirect(path: "/login");

    }
}