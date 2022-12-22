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

use Dotenv\Dotenv;



require_once dirname(__DIR__) . '/vendor/autoload.php';


// loading the .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



// Instantiate the application object
$app = new Application(dirname(__DIR__));


// registering the routes


// main routes
$app->router->get("/", [SiteController::class, 'getHomePage']);
$app->router->get("/products", [SiteController::class, 'getProductsPage']);

// customer's routes
$app->router->get("/register", [AuthenticationController::class, 'getCustomerSignupForm']);
$app->router->post("/register", [AuthenticationController::class, 'registerCustomer']);
$app->router->get("/login", [AuthenticationController::class, 'getCustomerLoginForm']);
$app->router->post("/login", [AuthenticationController::class, 'loginCustomer']);
$app->router->post("/logout", [AuthenticationController::class, 'logoutCustomer']);
$app->router->get("/dashboard/profile", [DashboardController::class, 'getCustomerDashboardProfile']);
$app->router->get("/shopping-cart", [ShoppingCartController::class, 'getCartPage']);
$app->router->post("/shopping-cart/add", [ShoppingCartController::class, 'addToCustomerShoppingCart']);

// definitive employee routes
$app->router->get("/employee-login", [AuthenticationController::class, 'getEmployeeLoginPage']);
$app->router->post("/employee-login", [AuthenticationController::class, 'loginEmployee']);
$app->router->post("/employee-logout", [AuthenticationController::class, 'logoutEmployee']);

// foreman routes
$app->router->get("/foreman-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
$app->router->get("/foreman-dashboard/profile", [DashboardController::class, 'getForemanDashboardProfile']);
$app->router->get("/foreman-dashboard/jobs", [JobsController::class, 'getJobsPage']);
$app->router->get("/foreman-dashboard/jobs/view", [JobsController::class, 'viewJobPage']);
$app->router->get("/foreman-dashboard/inspection-reports/create", [JobsController::class, 'getCreateInspectionReportPage']);
$app->router->post("/foreman-dashboard/inspection-reports/create", [JobsController::class, 'createInspectionReport']);
// technician routes

$app->router->get("/technician-dashboard/overview", [DashboardController::class, 'getForemanDashboardOverview']);
$app->router->get("/technician-dashboard/profile", [DashboardController::class, 'getTechnicianDashboardProfile']);


// administrator routes
$app->router->get("/admin-login", [AuthenticationController::class, "getAdminLoginPage"]);
$app->router->post('/admin-login', [AuthenticationController::class, "loginAdmin"]);
$app->router->get("/admin-dashboard/employees", [EmployeeController::class, 'getViewEmployeesPage']);
$app->router->get("/admin-dashboard/employees/add", [EmployeeController::class, 'getCreateEmployeePage']);
$app->router->post("/admin-dashboard/employees/add",[EmployeeController::class,'registerEmployee']);
$app->router->get("/admin-dashboard/profile", [DashboardController::class, 'getAdminDashboardProfile']);
$app->router->get("/admin-dashboard/services", [ServicesController::class, 'getServicesPage']);
$app->router->get("/admin-dashboard/services/add-services", [ServicesController::class, 'getAddServicesPage']);
$app->router->post("/admin-dashboard/services/add", [ServicesController::class, 'AddServices']);

// stock manager routes
$app->router->get( "/stock-manager-login", [AuthenticationController::class,'getStockManagerLoginPage']);
$app->router->post( "/stock-manager-login", [AuthenticationController::class,'loginStockManager']);
$app->router->get("/stock-manager-dashboard/profile", [DashboardController::class, 'getStockManagerDashboardProfile']);
$app->router->get("/stock-manager-dashboard/products", [ProductsController::class, 'getProductsPage']);
$app->router->get("/stock-manager-dashboard/products/add-products", [ProductsController::class, 'getAddProductsPage']);
$app->router->post("/stock-manager-dashboard/products/add-products", [ProductsController::class, 'AddProducts']);
$app->router->get("/stock-manager-dashboard/suppliers", [SuppliersController::class, 'getSuppliersPage']);
$app->router->post("/stock-manager-dashboard/suppliers/add", [ProductsController::class, 'addSuppliers']);

//office staff routes
$app->router->get("/office-staff-login", [AuthenticationController::class, 'getOfficeStaffLoginPage'] );
$app->router->post("/office-staff-login", [AuthenticationController::class, 'loginOfficeStaff']);
$app->router->get("/office-staff-dashboard/overview", [DashboardController::class,'getOfficeStaffDashboardOverview']);
$app->router->get("/office-staff-dashboard/profile", [DashboardController::class, 'getOfficeStaffDashboardProfile']);
$app->router->get("/office-staff-dashboard/customers", [CustomersController::class, 'getCustomersPage']);
$app->router->get("/office-staff-dashboard/customers/add", [CustomersController::class, 'getAddCustomerPage']);
$app->router->post("/office-staff-dashboard/customers/add", [CustomersController::class, 'addCustomer']);
$app->router->get("/office-staff-dashboard/vehicles", [VehiclesController::class, 'getVehiclesPage']);
$app->router->get("/office-staff-dashboard/vehicles/by-customer", [VehiclesController::class, 'getVehiclesByCustomer']);
$app->router->get("/office-staff-dashboard/vehicles/add/by-customer", [VehiclesController::class, 'getAddVehiclePage']);
$app->router->post("/office-staff-dashboard/vehicles/add/by-customer", [VehiclesController::class, 'addVehicle']);


//security officer roots
$app->router->get( "/security-officer-login", [AuthenticationController::class,'getSecurityOfficerLoginPage']);
$app->router->post( "/security-officer-login", [AuthenticationController::class,'loginSecurityOfficer']);
$app->router->get( "/security-officer-dashboard/profile", [DashboardController::class,'getSecurityOfficerDashboardProfile']);
$app->router->get("/security-officer-dashboard/check-appointment", [AppointmentController::class, 'getAppointmentPage']);


// run the application
$app->run();