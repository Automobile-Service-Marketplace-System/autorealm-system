<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Order;

class OrdersController
{
    public function getOrdersPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {
            $orderModel = new Order();
            $orders = $orderModel->getOrders();


            return $res->render(view: "stock-manager-dashboard-view-orders", layout: "stock-manager-dashboard",
                pageParams: ["orders" => $orders],
                layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
        }

        return $res->redirect(path: "/login");
    }


    public function getCustomerDashboardOrdersPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");

            return $res->render(view: "customer-dashboard-orders", layout: "customer-dashboard",
                layoutParams: ['title' => 'My Orders', 'pageMainHeading' => 'My Orders', 'customerId' => $customerId]);
        }
        return $res->redirect(path: "/login");
    }

    public function getOrderDetailsPage(Request $req, Response $res)
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {



            return $res->render(view: "stock-manager-dashboard-view-orders-details", layout: "stock-manager-dashboard",
                pageParams: [],
                layoutParams: ['title' => 'Order Details', 'pageMainHeading' => 'Order Details', 'employeeId' => $req->session->get("user_id")]);
        }

        return $res->redirect(path: "/login");
    }
}