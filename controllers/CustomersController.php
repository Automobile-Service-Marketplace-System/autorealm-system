<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Model;


class CustomersController
{
    public function officeStaffgetCustomersPage(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $customerModel = new Customer();
            $customers = $customerModel->getCustomers();

            return $res->render(view: "office-staff-dashboard-customers-page", layout: "office-staff-dashboard",
                pageParams: ["customers"=>$customers], 
                layoutParams: [
                    'title' => 'Customers',
                    'pageMainHeading' => 'Customers',
                    'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }

    public function officeStaffAddCustomerPage(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {

            $customerModel = new Customer();
            $customers = $customerModel->getCustomers();
            $modelModel = new Model();
            $rawModels = $modelModel->getModels();$models = [];
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] =  $rawModel['model_name'];
            }

            return $res->render(view: "office-staff-dashboard-add-customer", layout: "office-staff-dashboard", pageParams: [
                'models'=> $models
            ], layoutParams: [
                'title' => 'Add New Customer',
                'pageMainHeading' => 'Add New Customer',
                'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }

    public function officeStaffAddCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->register();

        $modelModel = new Model();
        $rawModels = $modelModel->getModels();
        $models = [];
        foreach ($rawModels as $rawModel) {
            $models[$rawModel['model_id']] =  $rawModel['model_name'];
        }

        if (is_array($result)) {

            return $res->render(view: "office-staff-dashboard-add-customer", layout: "office-staff-dashboard",
                pageParams: [
                    "customer"=>$customer, 
                    'errors' => $result,
                    'body' => $body,
                    'models' => $models
                ], 
                layoutParams: [
                    'title' => 'Add New Customer',
                    'pageMainHeading' => 'Add New Customer'
                ]);
        }

        if ($result) {
            return $res->redirect("/office-staff-dashboard/customers");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }


    

}
