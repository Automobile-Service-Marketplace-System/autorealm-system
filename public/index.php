<?php

use app\core\Application;
use app\controllers\SiteController;
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
$app->router->get("/dashboard/profile", [DashboardController::class, 'getCustomerDashboardProfile']);

//officestaff-login
$app->router->get("/officestaff-login", [AuthenticationController::class, 'getOfficestaffLoginPage'] );
$app->router->post("/officestaff-login", [AuthenticationController::class, 'loginOfficestaff']);

// run the application
$app->run();