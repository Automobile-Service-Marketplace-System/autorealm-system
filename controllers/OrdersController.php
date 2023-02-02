<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class OrdersController
{
    public function getOrdersPage(Request $req, Response $res):string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {
//            $orderModel = new Order();
//            $orders = $orderModel->getOrders();


            return $res->render(view: "stock-manager-dashboard-view-orders", layout: "stock-manager-dashboard",
                pageParams: [],
                layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
        }

        return $res->redirect(path: "/login");
    }
}