<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Invoice;
use app\models\Order;
use app\models\Product;
use JsonException;

class AnalyticsController
{
    public function getAnalyticsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated")) {
            $view = match ($req->session->get("user_role")) {
                "admin" => "admin-dashboard-analytics",
                "stock_manager" => "stock-manager-dashboard-analytics",
                "foreman" => "foreman-dashboard-analytics",
                "office_staff_member" => "office-staff-dashboard-analytics",
                "technician" => "technician-dashboard-analytics",
                "security_officer" => "security-officer-dashboard-analytics",
                default => "login",
            };

            $layout = match ($req->session->get("user_role")) {
                "admin" => "admin-dashboard",
                "stock_manager" => "stock-manager-dashboard",
                "foreman" => "foreman-dashboard",
                "office_staff_member" => "office-staff-dashboard",
                "technician" => "technician-dashboard",
                "security_officer" => "security-officer-dashboard",
                default => "login",
            };

            return $res->render(view: $view, layout: $layout, layoutParams: [
                'title' => 'Analytics',
                'pageMainHeading' => 'Analytics',
                'employeeId' => $req->session->get('user_id'),
            ]);
        }
        return $res->redirect(path: "/login");
    }


    /**
     * @throws JsonException
     */

    public function getInvoiceRevenue(Request $req, Response $res):string{
        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin"){
            $invoiceModel = new Invoice();
            // var_dump($invoiceModel);
            $revenueData = $invoiceModel -> getInvoiceRevenueData();
            if(is_string($revenueData)){
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);               
            }
            $res->setStatusCode(200);
            return $res->json([
                "message" => "Success",
                "data" => $revenueData
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "Unauthorized"
        ]);
    }

    // public function getSummaryDetails(Request $req, Response $res):string{
    //     if($req->session->get("is_authenticated") && ($req->session->get("user_role")==="admin")){
    //         $productModel = new Product();
    //         $summaryDetails = $productModel->getSummaryDetails();
    //         if (is_string($summaryDetails)) {
    //             $res->setStatusCode(500);
    //             return $res->json([
    //                 "message" => "Internal Server Error"
    //             ]);
    //         }
    //         $res->setStatusCode(200);
    //         return $res->json([
    //             "message" => "Success",
    //             "data" => $summaryDetails
    //         ]);
    //     }
    //     $res->setStatusCode(401);
    //     return $res->json([
    //         "message" => "Unauthorized"
    //     ]);
    // }

    public function getOrderRevenue(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {
            $orderModel = new Order();
            $revenueData = $orderModel->getOrderRevenueData();
            if (is_string($revenueData)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            $res->setStatusCode(200);
            return $res->json([
                "message" => "Success",
                "data" => $revenueData
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "Unauthorized"
        ]);

    }

    /**
     * @throws JsonException
     */
    public function getOrderQuantityDetails(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {
            $orderModel = new Order();
            $quantityData = $orderModel->getOrderQuantityData();
            if (is_string($quantityData)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            $res->setStatusCode(200);
            return $res->json([
                "message" => "Success",
                "data" => $quantityData
            ]);


        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "Unauthorized"
        ]);

    }

    /**
     * @throws JsonException
     */
    public function getProductQuantityDetails(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {
            $orderModel = new Order();
            $quantityData = $orderModel->getProductQuantityData();

            if (is_string($quantityData)) {
                $res->setStatusCode(500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }

            $res->setStatusCode(200);

            return $res->json([
                "message" => "Success",
                "data" => $quantityData
            ]);
        }
        $res->setStatusCode(401);
        return $res->json([
            "message" => "Unauthorized"
        ]);
    }
}