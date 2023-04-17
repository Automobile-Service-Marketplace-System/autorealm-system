<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Supplier;
use JsonException;

class SuppliersController
{
    public function getSuppliersPage(Request $req, Response $res): string
    {

        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            $supplierModel = new Supplier();
            $suppliers = $supplierModel->getSuppliersList();


            if ($req->session->get("user_role") === "stock_manager") {
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

            if ($req->session->get("user_role") === "admin") {
                return $res->render(view: "stock-manager-dashboard-view-suppliers", layout: "admin-dashboard",
                    pageParams: [
                        'suppliers' => $suppliers
                    ],
                    layoutParams: [
                        'title' => 'Suppliers',
                        'pageMainHeading' => 'Suppliers',
                        'employeeId' => $req->session->get('user_id')
                    ]);
            }


        }

        return $res->redirect(path: "/login");
    }

    //update supplier details
    public function updateSuppliers(Request $req, Response $res): string
    {
        $body = $req->body();
        $supplier = new Supplier($body);
        $result = $supplier->updateSupplier();

        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => $result
            ]);
        }

        if (is_array($result)) {
            $res->setStatusCode(code: 400);
            return $res->json([
                "errors" => $result
            ]);
        }

        if ($result) {
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Supplier updated successfully"
            ]);
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    /**
     * @throws JsonException
     */
    public function deleteSuppliers(Request $req, Response $res):string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            $body= $req->body();
            if(empty($body['supplier_id'])){
                $res->setStatusCode(code: 400);
                return $res->json([
                    "message"=> "Bad Request"
                ]);
            }
            $supplier_id=$body['supplier_id'];
            $supplierModel=new Supplier();
            $result=$supplierModel->deleteSupplierById(id: $supplier_id);


            if (is_string($result)) {
                $res->setStatusCode(code: 500);
                return $res->json([
                    "message" => "Internal Server Error"
                ]);
            }
            if ($result) {
                $res->setStatusCode(code: 204);
                return $res->json([
                    "message" => "Product deleted successfully"
                ]);

            }
        }

        return $res->redirect(path: "/login");
    }
}