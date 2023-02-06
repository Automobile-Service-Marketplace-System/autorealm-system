<?php

use app\core\Application;
use app\controllers\SiteController;

use app\controllers\EmployeeController;
use app\controllers\AuthenticationController;
use app\controllers\CustomersController;
use app\controllers\DashboardController;
use app\controllers\ProductsController;
use app\controllers\JobsController;
use app\controllers\AppointmentController;
use app\controllers\VehiclesController;
use app\controllers\SuppliersController;
use app\controllers\ServicesController;
use app\controllers\ShoppingCartController;
use app\controllers\OverviewController;
use app\controllers\InvoicesController;
use Dotenv\Dotenv;


require_once dirname(__DIR__) . '/vendor/autoload.php';


// loading the .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$h = $_SERVER['HTTP_HOST'];
$hSegments = explode(".", $h);

$isInternal = false;

if (count($hSegments) === 4) {
    $isInternal = true;
} else if (count($hSegments) === 3 && $hSegments[0] === "dashboard") {
    $isInternal = true;
}
//
//echo "<pre>";
//var_dump($isInternal);
//echo "</pre>";
//exit();
// Instantiate the application object
$app = new Application(dirname(__DIR__));


// registering the routes


// main routes
if(!$isInternal) {
    $app->router->get("/", [SiteController::class, 'getHomePage']);
    $app->router->get("/products", [SiteController::class, 'getProductsPage']);

// customer's routes
    $app->router->get("/register", [AuthenticationController::class, 'getCustomerSignupForm']);
    $app->router->post("/register", [AuthenticationController::class, 'registerCustomer']);
    $app->router->get("/login", [AuthenticationController::class, 'getCustomerLoginForm']);
    $app->router->post("/login", [AuthenticationController::class, 'loginCustomer']);
    $app->router->post("/logout", [AuthenticationController::class, 'logoutCustomer']);
    $app->router->get("/dashboard/profile", [DashboardController::class, 'getCustomerDashboardProfile']);
    $app->router->get("/cart", [ShoppingCartController::class, 'getCartPage']);
    $app->router->post("/cart/add", [ShoppingCartController::class, 'addToCustomerShoppingCart']);
    $app->router->post("/cart/update", [ShoppingCartController::class, 'updateCartItem']);
    $app->router->post("/cart/delete", [ShoppingCartController::class, 'deleteCartItem']);

}

if($isInternal) {

// definitive employee routes
    $app->router->get("/login", [AuthenticationController::class, 'getEmployeeLoginPage']);
    $app->router->post("/login", [AuthenticationController::class, 'loginEmployee']);
    $app->router->post("/logout", [AuthenticationController::class, 'logoutEmployee']);

// foreman routes
    $app->router->get("/foreman-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
    $app->router->get("/foreman-dashboard/profile", [DashboardController::class, 'getForemanDashboardProfile']);
    $app->router->get("/jobs", [JobsController::class, 'getJobsPage']);
    $app->router->get("/jobs/view", [JobsController::class, 'viewJobPage']);
    $app->router->get("/inspection-reports/create", [JobsController::class, 'getCreateInspectionReportPage']);
    $app->router->post("/inspection-reports/create", [JobsController::class, 'createInspectionReport']);
// technician routes

    $app->router->get("/technician-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
    $app->router->get("/technician-dashboard/profile", [DashboardController::class, 'getTechnicianDashboardProfile']);


// administrator routes
    $app->router->get("/admin-login", [AuthenticationController::class, "getAdminLoginPage"]);
    $app->router->post('/admin-login', [AuthenticationController::class, "loginAdmin"]);
    $app->router->get("/employees", [EmployeeController::class, 'getViewEmployeesPage']);
    $app->router->get("/employees/add", [EmployeeController::class, 'getCreateEmployeePage']);
    $app->router->post("/employees/add", [EmployeeController::class, 'registerEmployee']);
    $app->router->get("/admin-dashboard/profile", [DashboardController::class, 'getAdminDashboardProfile']);
    $app->router->get("/services", [ServicesController::class, 'getServicesPage']);
    $app->router->get("/services/add-services", [ServicesController::class, 'getAddServicesPage']);
    $app->router->post("/services/add", [ServicesController::class, 'AddServices']);
    $app->router->get("/overview",[OverviewController::class,'getOverviewPage']);

// stock manager routes
    $app->router->get("/stock-manager-login", [AuthenticationController::class, 'getStockManagerLoginPage']);
    $app->router->post("/stock-manager-login", [AuthenticationController::class, 'loginStockManager']);
    $app->router->get("/stock-manager-dashboard/profile", [DashboardController::class, 'getStockManagerDashboardProfile']);
    $app->router->get("/stock-manager-dashboard/products", [ProductsController::class, 'getProductsPage']);
    $app->router->get("/stock-manager-dashboard/products/add-products", [ProductsController::class, 'getAddProductsPage']);
    $app->router->post("/stock-manager-dashboard/products/add-products", [ProductsController::class, 'AddProducts']);
    $app->router->get("/stock-manager-dashboard/suppliers", [SuppliersController::class, 'getSuppliersPage']);
    $app->router->post("/stock-manager-dashboard/suppliers/add", [ProductsController::class, 'addSuppliers']);

//office staff routes
    $app->router->get("/office-staff-login", [AuthenticationController::class, 'getOfficeStaffLoginPage']);
    $app->router->post("/office-staff-login", [AuthenticationController::class, 'loginOfficeStaff']);
    $app->router->get("/office-staff-dashboard/overview", [DashboardController::class, 'getOfficeStaffDashboardOverview']);
    $app->router->get("/office-staff-dashboard/profile", [DashboardController::class, 'getOfficeStaffDashboardProfile']);
    $app->router->get("/customers", [CustomersController::class, 'getCustomersPage']);
    $app->router->get("/customers/add", [CustomersController::class, 'getAddCustomerPage']);
    $app->router->post("/customers/add", [CustomersController::class, 'addCustomer']);
    $app->router->get("/vehicles", [VehiclesController::class, 'getVehiclesPage']);
    $app->router->get("/vehicles/by-customer", [VehiclesController::class, 'getVehiclesByCustomer']);
    $app->router->get("/vehicles/add/by-customer", [VehiclesController::class, 'getAddVehiclePage']);
    $app->router->post("/vehicles/add/by-customer", [VehiclesController::class, 'addVehicle']);
    $app->router->get("/invoices", [InvoicesController::class, 'getInvoicesPage']);


//security officer roots
    $app->router->get("/security-officer-login", [AuthenticationController::class, 'getSecurityOfficerLoginPage']);
    $app->router->post("/security-officer-login", [AuthenticationController::class, 'loginSecurityOfficer']);
    $app->router->get("/security-officer-dashboard/profile", [DashboardController::class, 'getSecurityOfficerDashboardProfile']);
    $app->router->get("/security-officer-dashboard/check-appointment", [AppointmentController::class, 'getAppointmentPage']);

}

// run the application
$app->run();