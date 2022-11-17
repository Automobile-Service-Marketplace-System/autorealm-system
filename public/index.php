<?php

use app\core\Application;
use app\controllers\AuthenticationController;
use app\controllers\SiteController;
use app\controllers\EmployeeController;
use app\controllers\AdminController;
use app\controllers\SecurityOfficerController;

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
$app->router->get("/admin-login", [AdminController::class, "getAdminLoginPage"]);
$app->router->post('/admin-login', [AdminController::class, "loginAdmin"]);
$app->router->get("/employee-register", [EmployeeController::class, 'getEmployeeSignupForm']);
$app->router->get("/security-officer-login",[SecurityOfficerController::class, 'getSecurityOfficerLoginPage']);
$app->router->post("/security-officer-login",[SecurityOfficerController::class, 'loginSecurityOfficer']);


// run the application
$app->run();

