<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Model;
use app\models\Service;

class ServicesController
{

    public function getServicesPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

             $serviceModel = new Service();
             $services = $serviceModel->getServices();


            return $res->render(view: "services-page", layout: "admin-dashboard", pageParams: [
                "services" => $services], layoutParams: [
                'title' => 'services',
                'pageMainHeading' => 'services',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/employee-login");

    }

    // public function getAddProductsPage(Request $req, Response $res): string
    // {
    //     if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "admin") {

    //         $modelModel = new Model();
    //         $rawModels = $modelModel->getModels();
    //         $models = [];
    //         foreach ($rawModels as $rawModel) {
    //             $models[$rawModel['model_id']] = $rawModel['model_name'];
    //         }

    //         $modelBrand = new Brand();
    //         $rawBrands = $modelBrand->getBrands();
    //         $brands = [];
    //         foreach ($rawBrands as $rawBrand) {
    //             $brands[$rawBrand['brand_id']] =  $rawBrand['brand_name'];
    //         }

    //         $modelCategory = new Category();
    //         $rawCategories = $modelCategory->getCategories();
    //         $categories = [];
    //         foreach ($rawCategories as $rawCategory) {
    //             $categories[$rawCategory['category_id']] =  $rawCategory['name'];
    //         }

    //         $modelSupplier = new Supplier();
    //         $rawSuppliers = $modelSupplier->getSuppliers();
    //         $suppliers = [];
    //         foreach ($rawSuppliers as $rawSupplier) {
    //             $suppliers[$rawSupplier['supplier_id']] =  $rawSupplier['name'];
    //         }

    //         return $res->render(view: "stock-manager-add-products", layout: "stock-manager-dashboard", pageParams: [
    //             'models' => $models,
    //             'brands' => $brands,
    //             'categories' => $categories,
    //             'suppliers' => $suppliers
    //         ], layoutParams: [
    //             'title' => 'Add Products',
    //             'pageMainHeading' => 'Add Products',
    //             'employeeId' => $req->session->get("user_id"),
    //         ]);
    //     }

    //     return $res->redirect(path: "/employee-login");

    // }

}