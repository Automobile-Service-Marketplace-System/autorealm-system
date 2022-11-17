<?php

use app\core\Application;
use app\controllers\SiteController;

use app\controllers\EmployeeController;
use app\controllers\AuthenticationController;
use app\controllers\DashboardController;


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
$app->router->get("/admin-login", [AuthenticationController::class, "getAdminLoginPage"]);
$app->router->post('/admin-login', [AuthenticationController::class, "loginAdmin"]);
$app->router->get("/employee-register", [EmployeeController::class, 'getEmployeeSignupForm']);
$app->router->get("/dashboard/profile", [DashboardController::class, 'getCustomerDashboardProfile']);


$app->router->get( "/stockmanager-login", [AuthenticationController::class,'getStockmanagerLoginPage']);
$app->router->post( "/stockmanager-login", [AuthenticationController::class,'stockmanagerLogin']);

// run the application
$app->run();