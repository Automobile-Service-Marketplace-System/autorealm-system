<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Invoice;
use app\utils\DevOnly;

class InvoicesController
{
    public function getInvoicesPage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $query = $req->query();
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;

            $invoiceModel = new Invoice();
            $invoices = $invoiceModel->getInvoices(count: $limit, page: $page);

            return $res->render(view: "office-staff-dashboard-invoices-page", layout: "office-staff-dashboard",
                pageParams: [
                    "invoices" => $invoices,
                    "total" => $invoices['total'],
                    "limit" => $limit,
                    "page" => $page],
                layoutParams: [
                    'title' => 'Invoices',
                    'pageMainHeading' => 'Invoices',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }

        return $res->redirect(path: "/login");
    }

    public function getCreateInvoicePage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $limit = isset($query['limit']) ? (int)$query['limit'] : 8;
            $page = isset($query['page']) ? (int)$query['page'] : 1;
            $invoiceModel = new Invoice();
            $invoices = $invoiceModel->getInvoices(count: $limit, page: $page);

            return $res->render(view: "office-staff-dashboard-generate-invoice-page", layout: "office-staff-dashboard",
                pageParams: [''],
                layoutParams: [
                    'title' => 'Generate Invoices',
                    'officeStaffId' => $req->session->get('user_id')
                ]);
        }

        return $res->redirect(path: "/login");
    }

    public function createInvoice(Request $req, Response $res)
    {
        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "office_staff_member") {
            $body = $req->body();
            DevOnly::prettyEcho($body);

            $invoiceModel = new Invoice($body);
            $invoiceModel->createInvoice(employeeId: $req->session->get("user_id"));
        }
    }
}
