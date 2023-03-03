<?php

use app\core\Application;
use app\controllers\SiteController;

use app\controllers\EmployeeController;
use app\controllers\AuthenticationController;
use app\controllers\CustomersController;
use app\controllers\DashboardController;
use app\controllers\ProductsController;
use app\controllers\JobsController;
use app\controllers\AppointmentsController;
use app\controllers\VehiclesController;
use app\controllers\SuppliersController;
use app\controllers\ServicesController;
use app\controllers\ShoppingCartController;
use app\controllers\OverviewController;
use app\controllers\InvoicesController;
use app\controllers\OrdersController;
use app\controllers\AdmittingController;
use app\controllers\ReviewController;

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
if (!$isInternal) {
    $app->router->get(path: "/", callback: [SiteController::class, 'getHomePage']);
    $app->router->get(path: "/products", callback: [SiteController::class, 'getProductsPage']);
    $app->router->get(path: "/services", callback: [SiteController::class, 'getServicesPage']);
// customer's routes
    $app->router->get(path: "/register", callback: [AuthenticationController::class, 'getCustomerSignupForm']);
    $app->router->post(path: "/register", callback: [AuthenticationController::class, 'registerCustomer']);
    $app->router->get(path: "/verify-email", callback: [AuthenticationController::class, 'getEmailVerificationStatusPage']);
    $app->router->get(path: "/contact-verification", callback: [AuthenticationController::class, 'getCustomerContactVerificationPage']);
    $app->router->get(path: "/login", callback: [AuthenticationController::class, 'getCustomerLoginForm']);
    $app->router->post(path: "/login", callback: [AuthenticationController::class, 'loginCustomer']);
    $app->router->post(path: "/logout", callback: [AuthenticationController::class, 'logoutCustomer']);
    $app->router->get(path: "/cart", callback: [ShoppingCartController::class, 'getCartPage']);
    $app->router->post(path: "/cart/add", callback: [ShoppingCartController::class, 'addToCustomerShoppingCart']);
    $app->router->post(path: "/cart/update", callback: [ShoppingCartController::class, 'updateCartItem']);
    $app->router->post(path: "/cart/delete", callback: [ShoppingCartController::class, 'deleteCartItem']);
    $app->router->get(path: "/dashboard/overview", callback: [OverviewController::class, 'getCustomerOverviewPage']);
    $app->router->get(path: "/dashboard/profile", callback: [DashboardController::class, 'getCustomerDashboardProfile']);
    $app->router->get(path: "/dashboard/vehicles", callback: [VehiclesController::class, 'getCustomerVehiclePage']);
    $app->router->get(path: "/dashboard/records", callback: [ServicesController::class, 'getPastServiceRecordsByVehicleIdCustomerPage']);
    $app->router->get(path: "/dashboard/orders", callback: [OrdersController::class, 'getCustomerDashboardOrdersPage']);
    $app->router->get(path: "/dashboard/appointments", callback: [AppointmentsController::class, 'getAppointmentsPageForCustomer']);
    $app->router->get(path: "/dashboard/services", callback: [ServicesController::class, 'geOngoingServicesForCustomerPage']);

    $app->router->get(path: "/cart/checkout", callback: [ShoppingCartController::class, 'getCartCheckoutPage']);
}

if ($isInternal) {

//    $app->router->get("/");

// definitive employ/ee routes
    $app->router->get(path: "/login", callback: [AuthenticationController::class, 'getEmployeeLoginPage']);
    $app->router->post(path: "/login", callback: [AuthenticationController::class, 'loginEmployee']);
    $app->router->post(path: "/logout", callback: [AuthenticationController::class, 'logoutEmployee']);

// foreman routes
    $app->router->get(path: "/foreman-dashboard/overview", callback: [DashboardController::class, 'getForemanDashboardOverview']);
    $app->router->get(path: "/foreman-dashboard/profile", callback: [DashboardController::class, 'getForemanDashboardProfile']);
    $app->router->get(path: "/jobs", callback: [JobsController::class, 'getJobsPage']);
    $app->router->get(path: "/jobs/view", callback: [JobsController::class, 'viewJobPage']);
    $app->router->get(path: "/all-jobs", callback: [JobsController::class, 'getListOfJobsPage']);
    $app->router->get(path: "/inspection-reports/create", callback: [JobsController::class, 'getCreateInspectionReportPage']);
    $app->router->post(path: "/inspection-reports/create", callback: [JobsController::class, 'createInspectionReport']);
// technician routes

    $app->router->get(path: "/technician-dashboard/overview", callback: [DashboardController::class, 'getTechnicianDashboardOverview']);
    $app->router->get(path: "/technician-dashboard/profile", callback: [DashboardController::class, 'getTechnicianDashboardProfile']);
    $app->router->get(path: "/assigned-job", callback: [JobsController::class, 'getAssignedJobOverviewPage']);

// administrator routes
    $app->router->get(path: "/admin-login", callback: [AuthenticationController::class, "getAdminLoginPage"]);
    $app->router->post(path: '/admin-login', callback: [AuthenticationController::class, "loginAdmin"]);
    $app->router->get(path: "/employees", callback: [EmployeeController::class, 'getViewEmployeesPage']);
    $app->router->get(path: "/employees/add", callback: [EmployeeController::class, 'getCreateEmployeePage']);
    $app->router->post(path: "/employees/add", callback: [EmployeeController::class, 'registerEmployee']);
    $app->router->get(path: "/employees/view", callback: [EmployeeController::class, 'getEditEmployeePage']);
    $app->router->post(path: "/employees/edit", callback: [EmployeeController::class, 'editEmployee']);
    $app->router->get(path: "/admin-dashboard/profile", callback: [DashboardController::class, 'getAdminDashboardProfile']);
    $app->router->get(path: "/services", callback: [ServicesController::class, 'getServicesPage']); // load the service page
    // $app->router->get(path: "/services/add-services", callback: [ServicesController::class, 'getAddServicesPage']);
    $app->router->post(path: "/services/add", callback: [ServicesController::class, 'AddServices']); //add the service to the database
    $app->router->post(path: "/services/update", callback: [ServicesController::class, 'UpdateServices']);
    $app->router->get(path: "/admin-dashboard/overview", callback: [OverviewController::class, 'getOverviewPage']);

// stock manager routes
    $app->router->get(path: "/stock-manager-login", callback: [AuthenticationController::class, 'getStockManagerLoginPage']);
    $app->router->post(path: "/stock-manager-login", callback: [AuthenticationController::class, 'loginStockManager']);
    $app->router->get(path: "/stock-manager-dashboard/profile", callback: [DashboardController::class, 'getStockManagerDashboardProfile']);
    $app->router->get(path: "/stock-manager-dashboard/products", callback: [ProductsController::class, 'getProductsPage']);
    $app->router->get(path: "/stock-manager-dashboard/products/add-products", callback: [ProductsController::class, 'getAddProductsPage']);
    $app->router->post(path: "/stock-manager-dashboard/products/add-products", callback: [ProductsController::class, 'AddProducts']);
    $app->router->get(path: "/stock-manager-dashboard/suppliers", callback: [SuppliersController::class, 'getSuppliersPage']);
    $app->router->post(path: "/stock-manager-dashboard/suppliers/add", callback: [ProductsController::class, 'addSuppliers']);
    $app->router->get(path: "/stock-manager-dashboard/orders", callback: [OrdersController::class, 'getOrdersPage']);
    $app->router->get(path: "/stock-manager-dashboard/orders/view", callback: [OrdersController::class, 'getOrderDetailsPage']);
    $app->router->get(path: "/stock-manager-dashboard/reviews", callback: [ReviewController::class, 'getReviewsPage']);
    $app->router->get(path: "/stock-manager-dashboard/products/update", callback: [ProductsController::class, 'updateProducts']);

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
    $app->router->get("/office-staff-dashboard/appointments/for-vin", [AppointmentsController::class, 'getCreateAppointmentPage']);
    $app->router->get("/appointments", [AppointmentsController::class, 'getOfficeAppointmentsPage']);
    $app->router->get("/office-staff-dashboard/create-jobCard", [JobsController::class, 'getCreateJobCardPage']);
    $app->router->get("/overview", [OverviewController::class, 'getofficeStaffOverviewPage']);
    $app->router->get("/invoices/create", [InvoicesController::class, 'getCreateInvoicePage']);


//security officer roots
    $app->router->get(path: "/security-officer-login", callback: [AuthenticationController::class, 'getSecurityOfficerLoginPage']);
    $app->router->post(path: "/security-officer-login", callback: [AuthenticationController::class, 'loginSecurityOfficer']);
    $app->router->get(path: "/security-officer-dashboard/profile", callback: [DashboardController::class, 'getSecurityOfficerDashboardProfile']);
    $app->router->get(path: "/security-officer-dashboard/check-appointment", callback: [AppointmentsController::class, 'getCheckAppointmentPage']);
    $app->router->get(path: "/security-officer-dashboard/view-appointment", callback: [AppointmentsController::class, 'getSecurityAppointments']);
    $app->router->get(path: "/security-officer-dashboard/admitting-reports/add", callback: [AdmittingController::class, 'getCreateAdmittingReportPage']);
    $app->router->get(path: "/security-officer-dashboard/view-admitting-reports", callback: [AdmittingController::class, 'getAdmittingReportsDetails']);
    $app->router->get(path: "/security-officer-dashboard/admitting-reports/view", callback: [AdmittingController::class, 'viewAdmittingReportDetails']);
}
// run the application
$app->run();