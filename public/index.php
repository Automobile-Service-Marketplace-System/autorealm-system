<?php

use app\controllers\AnalyticsController;
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
use app\controllers\PaymentsController;

use Dotenv\Dotenv;


require_once dirname(__DIR__) . '/vendor/autoload.php';

// loading the .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$h = $_SERVER['HTTP_HOST'];
$hSegments = explode(".", $h);

$isInternal = false;


// if first hSegment is dashboard, then it is internal
if ($hSegments[0] === "dashboard") {
    $isInternal = true;
}


// Instantiate the application object
$app = new Application(dirname(__DIR__));


// registering the routes


// main routes
if (!$isInternal) {

    $app->router->get(path: "/", callback: [SiteController::class, 'getHomePage']);

    $app->router->get(path: "/products", callback: [SiteController::class, 'getProductsPage']);
    $app->router->get(path: "/products/view", callback: [SiteController::class, 'getViewProductPage']);

    $app->router->post(path: "/reviews", callback: [ReviewController::class, 'createReview']);
    $app->router->get(path: "/reviews", callback: [ReviewController::class, 'getReviewsForProductPage']);
    $app->router->post(path: "/reviews/delete", callback: [ReviewController::class, 'deleteReview']);

    $app->router->get(path: "/services", callback: [SiteController::class, 'getServicesPage']);
// customer's routes
    $app->router->get(path: "/register", callback: [AuthenticationController::class, 'getCustomerSignupForm']);
    $app->router->post(path: "/register", callback: [AuthenticationController::class, 'registerCustomer']);
    $app->router->get(path: "/register/verify", callback: [AuthenticationController::class, 'getCustomerContactVerificationPage']);
    $app->router->post(path: "/register/verify", callback: [AuthenticationController::class, 'verifyCustomerContactDetails']);
    $app->router->post(path: "/register/verify/retry", callback: [AuthenticationController::class, 'sendVerificationCodesAgain']);
    $app->router->get(path: "/login", callback: [AuthenticationController::class, 'getCustomerLoginForm']);
    $app->router->post(path: "/login", callback: [AuthenticationController::class, 'loginCustomer']);
    $app->router->post(path: "/logout", callback: [AuthenticationController::class, 'logoutCustomer']);
    $app->router->get(path: "/cart", callback: [ShoppingCartController::class, 'getCartPage']);
    $app->router->get(path: "/cart/item-quantity", callback: [ShoppingCartController::class, 'getProductItemQuantity']);
    $app->router->post(path: "/cart/add", callback: [ShoppingCartController::class, 'addToCustomerShoppingCart']);
    $app->router->post(path: "/cart/update", callback: [ShoppingCartController::class, 'updateCartItem']);
    $app->router->post(path: "/cart/delete", callback: [ShoppingCartController::class, 'deleteCartItem']);


    //  checkout routes
    $app->router->get(path: "/cart/checkout", callback: [PaymentsController::class, 'getCheckoutPage']);
    $app->router->post(path: "/cart/checkout", callback: [PaymentsController::class, 'checkoutProductAndChargeCustomer']);
    $app->router->get(path: "/cart/checkout/success", callback: [PaymentsController::class, 'getCheckoutSuccessPage']);


    // get payment verifications
    $app->router->post(path: "/payments/verify", callback: [PaymentsController::class, 'verifyPayments']);

    $app->router->get(path: "/dashboard/overview", callback: [OverviewController::class, 'getCustomerOverviewPage']);
    $app->router->get(path: "/dashboard/profile", callback: [DashboardController::class, 'getCustomerDashboardProfile']);
    $app->router->get(path: "/dashboard/vehicles", callback: [VehiclesController::class, 'getCustomerVehiclePage']);
    $app->router->get(path: "/dashboard/records", callback: [ServicesController::class, 'getPastServiceRecordsByVehicleIdCustomerPage']);
    $app->router->get(path: "/dashboard/orders", callback: [OrdersController::class, 'getCustomerDashboardOrdersPage']);
    $app->router->get(path: "/dashboard/appointments", callback: [AppointmentsController::class, 'getAppointmentsPageForCustomer']);
    $app->router->get(path: "/dashboard/services", callback: [ServicesController::class, 'geOngoingServicesForCustomerPage']);
    $app->router->get(path: "/vehicles/for-appointment", callback: [VehiclesController::class, 'getVehicleNameListForCustomer']);
    $app->router->get(path: "/holidays", callback: [AppointmentsController::class, 'getHolidays']);
    $app->router->get(path: "/appointments/timeslots", callback: [AppointmentsController::class, 'getTimeSlots']);
    $app->router->post(path: "/appointments/create-by-customer", callback:[AppointmentsController::class, 'createAppointmentByCustomer']);

//    $app->router->get(path: "/cart/checkout", callback: [ShoppingCartController::class, 'getCartCheckoutPage']);
}

if ($isInternal) {

    $app->router->get("/", callback: [DashboardController::class, 'getDashboardIndexPage']);

// definitive employee routes
    $app->router->get(path: "/login", callback: [AuthenticationController::class, 'getEmployeeLoginPage']);
    $app->router->post(path: "/login", callback: [AuthenticationController::class, 'loginEmployee']);
    $app->router->post(path: "/logout", callback: [AuthenticationController::class, 'logoutEmployee']);
    $app->router->get(path: "/products/categories-brands-models", callback: [ProductsController::class, 'getCategoriesBrandsModels']);
    $app->router->get(path: "/products/for-selector", callback: [ProductsController::class, 'getProductSelectorProducts']);
    $app->router->get(path: "/services/for-selector", callback: [ServicesController::class, 'getServiceSelectorServices']);
    $app->router->get(path: "/jobs/for-selector", callback: [JobsController::class, 'getJobSelectorJobs']);
    $app->router->get(path: "/overview", callback: [OverviewController::class, 'getOverviewPage']);

    $app->router->get(path: "/analytics", callback: [AnalyticsController::class, 'getAnalyticsPage']);
    $app->router->get(path: '/analytics/order-revenue', callback: [AnalyticsController::class, 'getOrderRevenue']);
    $app->router->get(path: '/analytics/invoice-revenue', callback: [AnalyticsController::class, 'getInvoiceRevenue']);
    // $app->router->get(path: '/analytics/summary-table', callback: [AnalyticsController::class, 'getSummaryDetails']);
    $app->router->get(path: '/analytics/order-quantity', callback: [AnalyticsController::class, 'getOrderQuantityDetails']);
    $app->router->get(path: '/analytics/product-quantity', callback: [AnalyticsController::class, 'getProductQuantityDetails']);
    $app->router->get(path: "/all-jobs/view", callback: [JobsController::class, 'getJobDetailsPage']);
    $app->router->get(path: "/inspection-reports/view", callback: [JobsController::class, 'getInspectionReportForJobPage']);
    $app->router->get(path: "/jobs/customer-info", callback: [JobsController::class, 'getCustomerDetailsForJob']);
    $app->router->get(path: "/jobs/product-info", callback: [JobsController::class, 'getProductsForJob']);
    $app->router->get(path: "/jobs/service-info", callback: [JobsController::class, 'getServicesForJob']);
    $app->router->get(path: "/holidays", callback: [AppointmentsController::class, 'getHolidays']);

// foreman routes
    // $app->router->get(path: "/foreman-dashboard/overview", callback: [DashboardController::class, 'getForemanDashboardOverview']);
    $app->router->get(path: "/foreman-dashboard/profile", callback: [DashboardController::class, 'getForemanDashboardProfile']);
    $app->router->get(path: "/jobs", callback: [JobsController::class, 'getJobsPage']);
    $app->router->post(path: "/jobs/start", callback: [JobsController::class, 'startJob']);
    $app->router->get(path: "/jobs/view", callback: [JobsController::class, 'viewJobPage']);
    $app->router->get(path: "/jobs/in-progress/view", callback: [JobsController::class, 'getJobsInProgressPage']);
    $app->router->get(path: "/all-jobs", callback: [JobsController::class, 'getListOfJobsPage']);
    $app->router->get(path: "/inspection-reports/create", callback: [JobsController::class, 'getCreateInspectionReportPage']);
    $app->router->post(path: "/inspection-reports/create", callback: [JobsController::class, 'createInspectionReport']);
    $app->router->post(path: "/inspection-reports/create-draft", callback: [JobsController::class, 'createInspectionReportDraft']);
    $app->router->get(path: "/technicians", callback: [JobsController::class, 'getAvailableTechniciansForJob']);

// technician routes

    // $app->router->get(path: "/technician-dashboard/overview", callback: [DashboardController::class, 'getTechnicianDashboardOverview']);
    $app->router->get(path: "/technician-dashboard/profile", callback: [DashboardController::class, 'getTechnicianDashboardProfile']);
    $app->router->get(path: "/assigned-job", callback: [JobsController::class, 'getAssignedJobOverviewPage']);
    $app->router->post(path: "/assigned-job/services/set-status", callback: [JobsController::class, 'changeJobServiceStatus']);

// administrator routes
    $app->router->get(path: "/admin-login", callback: [AuthenticationController::class, "getAdminLoginPage"]);
    $app->router->post(path: '/admin-login', callback: [AuthenticationController::class, "loginAdmin"]);
    $app->router->get(path: "/employees", callback: [EmployeeController::class, 'getViewEmployeesPage']);
    $app->router->get(path: "/employees/add", callback: [EmployeeController::class, 'getCreateEmployeePage']);
    $app->router->post(path: "/employees/add", callback: [EmployeeController::class, 'registerEmployee']);
    $app->router->get(path: "/employees/view", callback: [EmployeeController::class, 'getEditEmployeePage']);
    $app->router->post(path: "/employees/delete", callback: [EmployeeController::class, 'deleteEmployees']);

    $app->router->post(path: "/employees/edit", callback: [EmployeeController::class, 'editEmployee']);
    // $app->router->post(path: "/employees/edit", callback: [EmployeeController::class, 'editEmployee']);
    $app->router->get(path: "/admin-dashboard/profile", callback: [DashboardController::class, 'getAdminDashboardProfile']);
    $app->router->get(path: "/services", callback: [ServicesController::class, 'getServicesPage']); // load the service page
    // $app->router->get(path: "/services/add-services", callback: [ServicesController::class, 'getAddServicesPage']);
    $app->router->post(path: "/services/add", callback: [ServicesController::class, 'AddServices']); //add the service to the database
    $app->router->post(path: "/services/update", callback: [ServicesController::class, 'UpdateServices']);
    $app->router->post(path: "/services/delete", callback: [ServicesController::class, 'deleteService']);
    $app->router->get(path: "/overview/employee-count" , callback: [EmployeeController::class, 'getEmployeeCountData']);
    $app->router->get(path: "/overview/customer-count" , callback: [OverviewController::class, 'getCustomerCount']);
    // $app->router->get(path: "/overview/foreman-jobs" , callback: [OverviewController::class, 'getForemanJobs']);    
    // $app->router->get(path: "/admin-dashboard/overview", callback: [OverviewController::class, 'getOverviewPage']);

// stock manager routes
    $app->router->get(path: "/stock-manager-login", callback: [AuthenticationController::class, 'getStockManagerLoginPage']);
    $app->router->post(path: "/stock-manager-login", callback: [AuthenticationController::class, 'loginStockManager']);

    $app->router->get(path: "/profile", callback: [DashboardController::class, 'getStockManagerDashboardProfile']);
    $app->router->get(path: "/products", callback: [ProductsController::class, 'getProductsPage']);
    $app->router->get(path: "/products/add", callback: [ProductsController::class, 'getAddProductsPage']);
    $app->router->post(path: "/products/add", callback: [ProductsController::class, 'AddProducts']);
    $app->router->post(path: "/products/delete", callback: [ProductsController::class, 'deleteProduct']);
    $app->router->post(path: "/products/update", callback: [ProductsController::class, 'updateProducts']);
    $app->router->post(path: "/products/restock", callback: [ProductsController::class, 'restockProducts']);
    $app->router->get(path: "/suppliers", callback: [SuppliersController::class, 'getSuppliersPage']);
    $app->router->post(path: "/suppliers/add", callback: [SuppliersController::class, 'addSuppliers']);
    $app->router->post(path: "/supplier/update", callback: [SuppliersController::class, 'updateSuppliers']);
    $app->router->post(path: "/suppliers/delete", callback: [SuppliersController::class, 'deleteSuppliers']);
    $app->router->get(path: "/suppliers/options-json", callback: [SuppliersController::class, 'getSuppliersAsJSON']);
    $app->router->get(path: "/orders", callback: [OrdersController::class, 'getOrdersPage']);
    $app->router->get(path: "/orders/view", callback: [OrdersController::class, 'getOrderById']);
    $app->router->post(path: "/orders/set-status", callback: [OrdersController::class, 'updateOrderStatus']);
    $app->router->get(path: "/reviews", callback: [ReviewController::class, 'getReviewsPage']);
    $app->router->post(path: "/products/add-brands", callback: [ProductsController::class, 'addBrand']);
    $app->router->get(path: "/product/brands-options-json", callback: [ProductsController::class, 'getBrandsAsJSON']);
    $app->router->post(path: "/products/add-model", callback: [ProductsController::class, 'addModel']);

//office staff routes
    $app->router->get(path: "/office-staff-login", callback: [AuthenticationController::class, 'getOfficeStaffLoginPage']);
    $app->router->post(path: "/office-staff-login", callback: [AuthenticationController::class, 'loginOfficeStaff']);
    // $app->router->get(path: "/overview", callback: [DashboardController::class, 'getOfficeStaffDashboardOverview']);
    $app->router->get(path: "/profile", callback: [DashboardController::class, 'getOfficeStaffDashboardProfile']);
    $app->router->get(path: "/customers", callback: [CustomersController::class, 'getCustomersPage']);
    $app->router->get(path: "/customers/add", callback: [CustomersController::class, 'getAddCustomerPage']);
    $app->router->post(path: "/customers/add", callback: [CustomersController::class, 'addCustomer']);
    $app->router->get(path: "/vehicles", callback: [VehiclesController::class, 'getVehiclesPage']);
    $app->router->get(path: "/vehicles/by-customer", callback: [VehiclesController::class, 'getVehiclesByCustomer']);
    $app->router->get(path: "/vehicles/by-customer-json", callback: [VehiclesController::class, 'getVehiclesByCustomerAsJSON']);
    $app->router->get(path: "/vehicles/add/by-customer", callback: [VehiclesController::class, 'getAddVehiclePage']);
    $app->router->post(path: "/vehicles/add/by-customer", callback: [VehiclesController::class, 'addVehicle']);
    $app->router->get(path: "/invoices", callback: [InvoicesController::class, 'getInvoicesPage']);
    $app->router->get(path: "/appointments/for-vin", callback: [AppointmentsController::class, 'getCreateAppointmentPage']);
    $app->router->get(path: "/appointments/timeslots", callback: [AppointmentsController::class, 'getTimeSlots']);
    $app->router->get(path: "/appointments", callback: [AppointmentsController::class, 'getOfficeAppointmentsPage']);
    $app->router->post(path: "/appointments/create", callback: [AppointmentsController::class, 'officeCreateAppointment']);
    // $app->router->get(path: "/create-job-card", callback: [JobsController::class, 'getCreateJobCardPage']);
    $app->router->post(path: "/create-job-card", callback: [JobsController::class, 'createJobCard']);
    $app->router->get(path: "/invoices/create", callback: [InvoicesController::class, 'getCreateInvoicePage']);
    $app->router->post(path: "/invoices/create", callback: [InvoicesController::class, 'createInvoice']);
    $app->router->post(path: "/customers/update", callback: [CustomersController::class, 'updateCustomer']);
    $app->router->post(path: "/vehicles/update", callback: [VehiclesController::class, 'updateVehicle']);
    $app->router->get(path: "/job-cards", callback: [JobsController::class, 'getAllJobsPage']);
    $app->router->get(path: "/appointments/update", callback: [AppointmentsController::class, 'officeUpdateAppointment']);
    $app->router->post(path: "/appointments/delete", callback: [AppointmentsController::class, 'officeDeleteAppointment']);
    $app->router->get(path: "/foremen", callback: [AppointmentsController::class, 'getForemen']);

//    $app


//security officer roots
    $app->router->get(path: "/security-officer-login", callback: [AuthenticationController::class, 'getSecurityOfficerLoginPage']);
    $app->router->post(path: "/security-officer-login", callback: [AuthenticationController::class, 'loginSecurityOfficer']);
    $app->router->get(path: "/security-officer-dashboard/profile", callback: [DashboardController::class, 'getSecurityOfficerDashboardProfile']);
    $app->router->get(path: "/security-officer-dashboard/check-appointment", callback: [AppointmentsController::class, 'getCheckAppointmentPage']);
    $app->router->get(path: "/security-officer-dashboard/view-appointment", callback: [AppointmentsController::class, 'getAllAppointmentsDetails']);

    $app->router->get(path: "/security-officer-dashboard/admitting-reports/add", callback: [AdmittingController::class, 'getCreateAdmittingReportPage']);
    $app->router->post(path: "/security-officer-dashboard/admitting-reports/add", callback: [AdmittingController::class, 'addAdmittingReportPage']);
    $app->router->get(path: "/security-officer-dashboard/view-admitting-reports", callback: [AdmittingController::class, 'getAdmittingReportsDetails']);
    $app->router->get(path: "/security-officer-dashboard/admitting-reports/view", callback: [AdmittingController::class, 'viewAdmittingReportDetails']);
    $app->router->post(path: "/security-officer-dashboard/admitting-reports/approve", callback: [AdmittingController::class, 'approveAdmittingReportPage']);
    // $app->router->get(path: "/security-officer-dashboard/view-appointments", callback: [AppointmentsController::class, 'getSecurityAppointments']);
}
// run the application
$app->run();

?>