<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Product;
use app\models\Model;
use app\models\Brand;
use app\models\Category;
use app\models\Supplier;
use app\models\Vehicle;

class ProductsController
{

    public function getProductsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && ($req->session->get("user_role") === "stock_manager" || $req->session->get("user_role") === "admin")) {

            $productModel = new Product();
            $brandModel = new Brand();
            $categoryModel = new Category();
            $modelModel = new Model();
            $products = $productModel->getProducts();

            if($req->session->get("user_role") === "stock_manager"){
                return $res->render(view: "stock-manager-dashboard-view-products", layout: "stock-manager-dashboard", pageParams: [
                    "products" => $products,
                    "brands" => $brandModel->getBrands(),
                    "categories" => $categoryModel->getCategories(),
                    "models" => $modelModel->getModels(),
                ], layoutParams: [
                    'title' => 'Products',
                    'pageMainHeading' => 'Products',
                    'employeeId' => $req->session->get("user_id"),
                ]);
            }

            if($req->session->get("user_role") === "admin"){
                return $res->render(view: "stock-manager-dashboard-view-products", layout: "admin-dashboard", pageParams: [
                    "products" => $products,
                    "brands" => $brandModel->getBrands(),

                    "categories" => $categoryModel->getCategories(),
                    "models" => $modelModel->getModels(),
                ], layoutParams: [
                    'title' => 'Products',
                    'pageMainHeading' => 'Products',
                    'employeeId' => $req->session->get("user_id"),
                ]);
            }

        }

        return $res->redirect(path: "/login");

    }

    public function getAddProductsPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {

            $modelModel = new Model();
            $rawModels = $modelModel->getModels();
            $models = [];
            foreach ($rawModels as $rawModel) {
                $models[$rawModel['model_id']] = $rawModel['model_name'];
            }

            $modelBrand = new Brand();
            $rawBrands = $modelBrand->getBrands();
            $brands = [];
            foreach ($rawBrands as $rawBrand) {
                $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
            }

            $modelCategory = new Category();
            $rawCategories = $modelCategory->getCategories();
            $categories = [];
            foreach ($rawCategories as $rawCategory) {
                $categories[$rawCategory['category_id']] = $rawCategory['name'];
            }

            $modelSupplier = new Supplier();
            $rawSuppliers = $modelSupplier->getSuppliers();
            $suppliers = [];
            foreach ($rawSuppliers as $rawSupplier) {
                $suppliers[$rawSupplier['supplier_id']] = $rawSupplier['name'];
            }

            return $res->render(view: "stock-manager-dashboard-add-products", layout: "stock-manager-dashboard", pageParams: [
                'models' => $models,
                'brands' => $brands,
                'categories' => $categories,
                'suppliers' => $suppliers
            ], layoutParams: [
                'title' => 'Add Products',
                'pageMainHeading' => 'Add Products',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        return $res->redirect(path: "/login");

    }

    public function AddProducts(Request $req, Response $res): string
    {
        $body = $req->Body();
        $product = new Product($body);
        $result = $product->addProducts();

        if (is_string($result)) {
            var_dump($result);
            return "";
        }

        //For dropdowns when an error occurs
        $modelModel = new Model();
        $rawModels = $modelModel->getModels();
        $models = [];
        foreach ($rawModels as $rawModel) {
            $models[$rawModel['model_id']] = $rawModel['model_name'];
        }

        $modelBrand = new Brand();
        $rawBrands = $modelBrand->getBrands();
        $brands = [];
        foreach ($rawBrands as $rawBrand) {
            $brands[$rawBrand['brand_id']] = $rawBrand['brand_name'];
        }

        $modelCategory = new Category();
        $rawCategories = $modelCategory->getCategories();
        $categories = [];
        foreach ($rawCategories as $rawCategory) {
            $categories[$rawCategory['category_id']] = $rawCategory['name'];
        }

        $modelSupplier = new Supplier();
        $rawSuppliers = $modelSupplier->getSuppliers();
        $suppliers = [];
        foreach ($rawSuppliers as $rawSupplier) {
            $suppliers[$rawSupplier['supplier_id']] = $rawSupplier['name'];
        }


        if (is_array($result)) {
            return $res->render(view: "stock-manager-dashboard-add-products", layout: "stock-manager-dashboard", pageParams: [
                'models' => $models,
                'brands' => $brands,
                'categories' => $categories,
                'suppliers' => $suppliers,
                'errors' => $result,
                'body' => $body
            ], layoutParams: [
                'title' => 'Add Products',
                'pageMainHeading' => 'Add Products',
                'employeeId' => $req->session->get("user_id"),
            ]);
        }

        if ($result) {
            return $res->redirect(path: "/stock-manager-dashboard/products");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);

    }

    public function addSuppliers(Request $req, Response $res): string{
        $query = $req->query();
        $body = $req->body();
        $supplier = new Supplier($body);
        $result = $supplier->addSuppliers();

        if(is_array($result)) {
            $res->setStatusCode(code: 400);
            return $res->json([
                "errors" => $result
            ]);
        }

        if(is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "errors" => [
                    "error" => "Internal Server Error"
                ]
            ]);
        }

        if ($result) {
            $res->setStatusCode(code: 201);
            return $res->json([
                "success" => "Supplier added successfully"
            ]);
        }

    }


    //to update the product
    public function updateProducts(Request $req, Response $res): string
    {
        $body = $req->body();
        $product = new Product($body);
        $result = $product->updateProduct();

        if (is_string($result)) {
            $res->setStatusCode(code: 500);
            return $res->json([
                "message" => "Internal Server Error"
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
                "success" => "Product updated successfully"
            ]);
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

}