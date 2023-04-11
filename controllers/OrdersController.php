<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Order;
use app\models\Customer;

class OrdersController
{
    public function getOrdersPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {
            $orderModel = new Order();
            $orders = $orderModel->getOrders();
//            echo "<pre>";
//            print_r($orders);
//            echo "</pre>";

            if ($req->session->get("user_role") === "stock_manager") {
                return $res->render(view: "stock-manager-dashboard-view-orders", layout: "stock-manager-dashboard",
                    pageParams: ["orders" => $orders],
                    layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "stock-manager-dashboard-view-orders", layout: "admin-dashboard",
                    pageParams: ["orders" => $orders],
                    layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
            }

        }

        return $res->redirect(path: "/login");
    }


    public function getCustomerDashboardOrdersPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");


            $query = $req->query();
            $page = $query["page"] ?? 1;
            $limit = $query["limit"] ?? 4;
            $status = $query["status"] ?? "Not Prepared";

            $orderModel = new Order();
            $result = $orderModel->getOrdersForCustomer(customerId: $customerId, page: (int) $page, limit: (int) $limit, status: $status);

            return $res->render(
                view: "customer-dashboard-orders",
                layout: "customer-dashboard",
                pageParams: [
                    'orders' => $result['orders'] ?? [],
                    'total' => $result['total'] ?? 0,
                    'page' => $page,
                    'limit' => $limit,
                    'status' => $status,
                ],
                layoutParams: [
                    'title' => 'My Orders',
                    'pageMainHeading' => 'My Orders',
                    'customerId' => $customerId
                ]);
        }
        return $res->redirect(path: "/login");
    }

    public function getOrderById(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {

            $query = $req->query(); //to take the query parameters from the url
            //var_dump($query);
            $orderModel = new Order();
            $orderDetails = $orderModel->getOrderById($query["id"]);

            print_r($orderDetails);



            return $res->render(view: "stock-manager-dashboard-view-orders-details", layout: "stock-manager-dashboard",
                pageParams: [],
                layoutParams: ['title' => 'Order Details', 'pageMainHeading' => 'Order Details', 'employeeId' => $req->session->get("user_id")]);
        }

        return $res->redirect(path: "/login");
    }


}