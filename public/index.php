<?php

use app\core\Application;
use app\controllers\SiteController;

use app\controllers\EmployeeController;
use app\controllers\AuthenticationController;
use app\controllers\CustomersController;
use app\controllers\DashboardController;
use app\controllers\ProductsController;

use app\utils\DevOnly;

use Dotenv\Dotenv;



require_once dirname(__DIR__) . '/vendor/autoload.php';


// loading the .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

DevOnly::printToBrowserConsole(password_hash("aq1sw2de3fr4", PASSWORD_DEFAULT));
DevOnly::printToBrowserConsole($_COOKIE);



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


// definitive employee routes
$app->router->get("/employee-login", [AuthenticationController::class, 'getEmployeeLoginPage']);
$app->router->post("/employee-login", [AuthenticationController::class, 'loginEmployee']);

// foreman routes
$app->router->get("/foreman-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
$app->router->get("/foreman-dashboard/profile", [DashboardController::class, 'getForemanDashboardProfile']);

// technician routes
$app->router->get("/technician-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
$app->router->get("/technician-dashboard/profile", [DashboardController::class, 'getTechnicianDashboardProfile']);


// administrator routes
$app->router->get("/admin-login", [AuthenticationController::class, "getAdminLoginPage"]);
$app->router->post('/admin-login', [AuthenticationController::class, "loginAdmin"]);
$app->router->get("/admin-dashboard/create-employee", [EmployeeController::class, 'getCreateEmployeePage']);
$app->router->post('/admin-dashboard/create-employee',[EmployeeController::class,'AddEmployee']);
$app->router->get("/admin-dashboard", [ProductsController::class, 'getProductsPage']);

// stock manager routes
$app->router->get( "/stock-manager-login", [AuthenticationController::class,'getStockManagerLoginPage']);
$app->router->post( "/stock-manager-login", [AuthenticationController::class,'loginStockManager']);
$app->router->get("/stock-manager-dashboard/profile", [DashboardController::class, 'getStockManagerDashboardProfile']);
$app->router->get("/stock-manager-dashboard/products", [ProductsController::class, 'getProductsPage']);


// office staff routes
$app->router->get("/office-staff-login", [AuthenticationController::class, 'getOfficeStaffLoginPage'] );
$app->router->post("/office-staff-login", [AuthenticationController::class, 'loginOfficeStaff']);
$app->router->get("/office-staff-dashboard/overview", [DashboardController::class,'getOfficeStaffDashboardOverview']);
$app->router->get("/office-staff-dashboard/profile", [DashboardController::class, 'getOfficeStaffDashboardProfile']);
$app->router->get("/office-staff-dashboard/customers", [CustomersController::class, 'officeStaffgetCustomersPage']);
$app->router->get("/office-staff-dashboard/customers/add", [CustomersController::class, 'officeStaffAddCustomerPage']);
$app->router->post("/office-staff-dashboard/customers/add", [CustomersController::class, 'officeStaffAddCustomer']);

//security officer roots
$app->router->get( "/security-officer-login", [AuthenticationController::class,'getSecurityOfficerLoginPage']);
$app->router->post( "/security-officer-login", [AuthenticationController::class,'loginSecurityOfficer']);

// run the application
$app->run();