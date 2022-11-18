<?php

use app\core\Application;
use app\controllers\SiteController;

use app\controllers\EmployeeController;
use app\controllers\AuthenticationController;
use app\controllers\DashboardController;
use app\controllers\ProductsController;


require_once dirname(__DIR__) . '/vendor/autoload.php';


// loading the .env file
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


// Instantiate the application object
$app = new Application(dirname(__DIR__));


// registering the routes


// main routes
$app->router->get("/", [SiteController::class, 'getHomePage']);

// customer's routes
$app->router->get("/register", [AuthenticationController::class, 'getCustomerSignupForm']);
$app->router->post("/register", [AuthenticationController::class, 'registerCustomer']);
$app->router->get("/login", [AuthenticationController::class, 'getCustomerLoginForm']);
$app->router->post("/login", [AuthenticationController::class, 'loginCustomer']);
$app->router->post("/logout", [AuthenticationController::class, 'logoutCustomer']);
$app->router->get("/dashboard/profile", [DashboardController::class, 'getCustomerDashboardProfile']);



// admininstrator routes
$app->router->get("/admin-login", [AuthenticationController::class, "getAdminLoginPage"]);
$app->router->post('/admin-login', [AuthenticationController::class, "loginAdmin"]);
$app->router->get("/admin-dashboard/create-employee", [EmployeeController::class, 'getCreateEmployeePage']);
$app->router->get("/admin-manager-dashboard", [ProductsController::class, 'getProductsPage']);

// stock manager routes
$app->router->get( "/stock-manager-login", [AuthenticationController::class,'getStockManagerLoginPage']);
$app->router->post( "/stock-manager-login", [AuthenticationController::class,'loginStockManager']);
$app->router->get("/stock-manager-dashboard/products", [DashboardController::class, 'getStockManagerDashboardProfile']);

//officestaff-login
$app->router->get("/officestaff-login", [AuthenticationController::class, 'getOfficestaffLoginPage'] );
$app->router->post("/officestaff-login", [AuthenticationController::class, 'loginOfficestaff']);
$app->router->get("/dashboard/profile", [DashboardController::class, 'getOfficestaffDashboardProfile']);


// run the application
$app->run();