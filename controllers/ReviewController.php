<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Product;
use app\models\Reviews;
use app\utils\DevOnly;
use JsonException;

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

                        //for search
                        'searchTermProduct' => $searchTermProduct,
                        'reviewRating' => $reviewRating,
                        'reviewDate' => $reviewDate,
                    ],
                    layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "stock-manager-dashboard-view-reviews", layout: "admin-dashboard",
                pageParams: [
                    "reviews" => $results['reviews'],
                    'total' => $results['total'],
                    'limit' => $limit,
                    'page' => $page,

                    //for search
                    'searchTermProduct' => $searchTermProduct,
                    'reviewRating' => $reviewRating,
                    'reviewDate' => $reviewDate,
                ],
                layoutParams: ['title' => 'Reviews', 'pageMainHeading' => 'Reviews', 'employeeId' => $req->session->get("user_id")]);
        }

        }

        return $res->redirect(path: "/login");

    }

    /**
     * @throws JsonException
     */
    public function createReview(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            $body = $req->body();
            if (!isset($body['rating']) || !isset($body['text']) || !isset($body['item_code'])) {
                $res->setStatusCode(400);
                return $res->json([
                    "message" => "Invalid request body",
                ]);
            }

            $reviewModel = new Reviews($body);

            $existingReview = $reviewModel->getReview(customerId: $customerId, itemCode: $body['item_code']);
            if (is_string($existingReview)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => $existingReview,
                ]);
            }
            if ($existingReview) {
                $res->setStatusCode(400);
                return $res->json([
                    "message" => "You have already reviewed this product",
                ]);
            }

            $result = $reviewModel->addReview(customerId: $customerId);

            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => $result,
                ]);
            }

            $res->setStatusCode(201);
            return $res->json([
                "message" => "Review added successfully",
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "You are not authorized to perform this action",
        ]);
    }


    /**
     * @throws JsonException
     */
    public function getReviewsForProductPage(Request $req, Response $res): string
    {

        $query = $req->query();
//          for pagination
        $limit = isset($query['limit']) ? (int)$query['limit'] : 2;
        $page = isset($query['page']) ? (int)$query['page'] : 1;


        $reviewModel = new Reviews();
        $reviews = $reviewModel->getReviewsForProduct(
            itemCode: $query['item_code'],
            count: $limit,
            page: $page,
        );

        if (is_string($reviews)) {
            $res->setStatusCode(500);
            return $res->json([
                "message" => $reviews,
            ]);
        }

        $res->setStatusCode(200);
        return $res->json([
            "reviews" => $reviews,
            "total" => $reviewModel->getTotalReviewsForProduct(itemCode: $query['item_code']),
            "page" => $page,
        ]);
    }

    /**
     * @throws JsonException
     */
    public function deleteReview(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            $itemCode = $req->query()['item_code'];
            $reviewModel = new Reviews();
            $result = $reviewModel->deleteReviewOfProductByCustomerId(customerId: $customerId, itemCode: $itemCode);

            if (is_string($result)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => $result,
                ]);
            }

            if (!$result) {
                $res->setStatusCode(404);
                return $res->json([
                    "message" => "Review not found",
                ]);
            }

            $res->setStatusCode(200);
            return $res->json([
                "message" => "Review deleted successfully",
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "You are not authorized to perform this action",
        ]);
    }
}