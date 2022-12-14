<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Supplier;

class SuppliersController
{
    public function getSuppliersPage(Request $req, Response $res): string
    {
        if($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager"){

            $supplierModel = new Supplier();
            $suppliers = $supplierModel->getSuppliersList();

            return $res->render(view: "stock-manager-dashboard-view-suppliers", layout: "stock-manager-dashboard",
                pageParams: [
                'suppliers' => $suppliers
                ],
                layoutParams: [
                'title' => 'Suppliers',
                'pageMainHeading' => 'Suppliers',
                'employeeId' => $req->session->get('user_id')
            ]);
        }

        return $res->redirect(path: "/employee-login");
    }
}