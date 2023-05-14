<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Order;
use app\models\Customer;
use JsonException;

class OrdersController
{
    public function getOrdersPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            //for pagination
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit']:150;
            $page = isset($query['page']) ? (int)$query['page']:1;

            //for search and filtering
            $searchTermCustomer = $query["cus"] ?? null;
            $searchTermOrder = $query["id"] ?? null;
            $orderStatus = isset($query["status"]) ? ($query["status"] == "" ? "all" : $query["status"]) : "all";
            $orderDate = isset($query["date"]) ? ($query["date"] == "" ? "all" : $query["date"]) : "all";


            $orderModel = new Order();
            $result = $orderModel->getOrders(
                count: $limit,
                page: $page,
                searchTermCustomer: $searchTermCustomer,
                searchTermOrder: $searchTermOrder,
                options: [
                    'status' => $orderStatus,
                    'order_date' => $orderDate,

                ],
            );

            if ($req->session->get("user_role") === "stock_manager") {
                return $res->render(view: "stock-manager-dashboard-view-orders", layout: "stock-manager-dashboard",
                    pageParams: [
                        "orders" => $result['orders'],
                        'total' => $result['total'],
                        'limit' => $limit,
                        'page' => $page,
                        //passing filter options
                        'searchTermCustomer' => $searchTermCustomer,
                        'searchTermOrder' => $searchTermOrder,
                        'orderStatus' => $orderStatus,
                        'orderDate' => $orderDate,
                    ],
                    layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
            }

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "stock-manager-dashboard-view-orders", layout: "admin-dashboard",
                    pageParams: ["orders" => $result['orders'],
                        'total' => $result['total'],
                        'limit' => $limit,
                        'page' => $page,
                    ],
                    layoutParams: ['title' => 'Orders', 'pageMainHeading' => 'Orders', 'employeeId' => $req->session->get("user_id")]);
            }

        }

        return $res->redirect(path: "/login");
    }


    public function getCustomerDashboardOrdersPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");

            //for pagination
            $query = $req->query();
            $page = $query["page"] ?? 1;
            $limit = $query["limit"] ?? 4;
            $status = $query['status'] ?? "All";


            $orderModel = new Order();
            $result = $orderModel->getOrdersForCustomer(customerId: $customerId, page: (int)$page, limit: (int)$limit, status: $status);

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
            //print_r($orderDetails);

            return $res->render(view: "stock-manager-dashboard-view-orders-details", layout: "stock-manager-dashboard",
                pageParams: [
                    "orderDetails" => $orderDetails
                ],
                layoutParams: [
                    'title' => "Order Details #{$query["id"]}",
                    'pageMainHeading' => "Order Details #{$query["id"]}",
                    'employeeId' => $req->session->get("user_id")]);
        }

        return $res->redirect(path: "/login");
    }

    /**
     * @throws JsonException
     */
    public function updateOrderStatus(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            $empId = $req->session->get("user_id");

            $body = $req->body();
            $order_no = $body["order_no"] ?? null;
            if (!$body["order_no"]) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request"
                ]);
            }
            $orderNo = $body["order_no"];
            $mode = $body["mode"];
            $status = $body["status"];
            $orderModel = new Order();
            $result = $orderModel->updateOrderStatus(
                orderNo: $orderNo,
                mode: $mode,
                status: $status,
                employeeId: $empId

            );

            if (is_array($result)) {
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message" => "Bad Request",
                    "errors" => $result
                ]);
            }

            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error here",
                    "error" => $result
                ]);
            }
            if ($result) {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Status Updated successfully"
                ]);

            }
        }

        return $res->redirect(path: "/login");
    }


}