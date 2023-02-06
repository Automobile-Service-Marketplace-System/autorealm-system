<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Invoice;

class InvoicesController
{
    public function getInvoicesPage(Request $req, Response $res) : string {

        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $invoiceModel = new Invoice();
            $invoices = $invoiceModel->getInvoices();

            return $res->render(view: "office-staff-dashboard-invoices-page", layout: "office-staff-dashboard",
                pageParams: ["invoices"=>$invoices], 
                layoutParams: [
                    'title' => 'Invoices',
                    'pageMainHeading' => 'Invoices',
                    'officeStaffId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/login");
    }
}
