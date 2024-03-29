<?php

namespace app\controllers;

//importing core classes
use app\core\Request;
use app\core\Response;

//importing model classes
use app\models\Customer;
use app\models\StockManager;
use app\models\Admin;
use app\models\Employee;
use app\models\OfficeStaff;
use app\models\SecurityOfficer;
use JsonException;

class AuthenticationController
{
    //    Regarding customer authentication
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            return $res->redirect("/dashboard/profile");
        }
        return $res->render(view: "customer-signup", layoutParams: [
            "title" => "Register",
            'customer' => null
        ]);
    }

    public function registerCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->register();

        if (is_array($result) && isset($result["errors"])) {
            return $res->render(view: "customer-signup", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        }

        if (is_array($result) && isset($result["customerId"])) {
            $req->session->set("is_authenticated", true); // $_SESSION['is_authenticated'] = true;
            $req->session->set("user_id", $result["customerId"]);
            $req->session->set("user_role", "customer");
            return $res->redirect(path: "/register/verify");
        }

        return $result;
    }

    public function getCustomerContactVerificationPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            return $res->render(view: 'customer-contact-verification', layoutParams: [
                'title' => 'Verify your email address',
                'customerId' => $req->session->get("user_id"),
            ]);
        }
        return $res->redirect(path: "/login");
    }

    /**
     * @throws JsonException
     */
    public function sendVerificationCodesAgain(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $query = $req->query();
            $customerId = $req->session->get("user_id");
            $customerModel = new Customer();
            $result = $customerModel->retryVerifying(customerId: $customerId, mode: $query['mode']);
            if (is_array($result)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: $result);
            }
            if ($result === true) {
                $res->setStatusCode(code: 200);
                return $res->json(data: [
                    'success' => 'Verification codes sent successfully'
                ]);
            }
        }
        $res->setStatusCode(code: 401);
        return $res->json(data: [
            'message' => 'Unauthorized'
        ]);
    }


    /**
     * @throws JsonException
     */
    public function verifyCustomerContactDetails(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $body = $req->body();
            $query = $req->query();
            $customerId = $req->session->get("user_id");
            $customerModel = new Customer();
            $result = $customerModel->verifyContactDetails(customerId: $customerId, mode: $query['mode'], otp: $body['otp']);
            if (is_array($result)) {
                $res->setStatusCode(code: 500);
                return $res->json(data: $result);
            }
            if ($result === true) {
                $res->setStatusCode(code: 200);
                return $res->json(data: [
                    'success' => $query["mode"] === 'email' ? 'Email verified successfully' : 'Phone number verified successfully'
                ]);
            }
        }
        $res->setStatusCode(code: 401);
        return $res->json(data: [
            'message' => 'Unauthorized'
        ]);
    }

    public function getCustomerLoginForm(Request $req, Response $res): string
    {
        $query = $req->query();
        if ($req->session->get("is_authenticated")) {
            return $res->redirect(path: $query['redirect_url'] ?? "/dashboard/profile");
        }
        return $res->render(view: "customer-login", pageParams: [
            'redirect_url' => $query['redirect_url'] ?? "/dashboard/profile"
        ], layoutParams: [
            'title' => 'Login',
            'customer' => null
        ]);
    }

    public function loginCustomer(Request $req, Response $res): string
    {
        $query = $req->query();
        $previousPath = $query['redirect_url'] ?? "/dashboard/profile";
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->login();
        if (is_array($result)) {
            return $res->render(view: "customer-login", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        }

        if ($result) {
            try {
                if ($body['remember'] === '1') {
                    $req->session->setPersistentCustomerSession($result->customer_id);
                }
                $req->session->set("is_authenticated", true); // $_SESSION['is_authenticated'] = true;
                $req->session->set("user_id", $result->customer_id);
                $req->session->set("user_role", "customer"); // $_SESSION['user_role'] = "customer";
                return $res->redirect(path: $previousPath);
            } catch (\Exception $e) {
                $errors = ['system' => 'Internal Error, please try again later.If the issue persists, please contact us.'];
                return $res->render(view: "customer-login", pageParams: [
                    'errors' => $errors,
                    'body' => $body
                ]);
            }
        }
        return $res->render(view: "500", layout: "error", pageParams: [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function logoutCustomer(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $req->session->destroy();
            $req->session->deletePersistentCustomerSession($req->session->get("user_id"));
            return $res->redirect(path: "/");
        }

        return $res->redirect(path: "/");
    }


    //     Regarding office staff member authentication
    public function getOfficeStaffLoginPage(Request $req, Response $res): string
    {
        return $res->render(view: "office-staff-login", layout: "plain");
    }

    public function loginOfficeStaff(Request $req, Response $res): string
    {
        $body = $req->body();
        $officeStaff = new OfficeStaff($body);
        $result = $officeStaff->login();
        if (is_array($result)) {
            return $res->render(view: "office-staff-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);
        }

        if ($result) {
            // reaches when office staff successful logged in
            $req->session->set("is_authenticated", true);
            $req->session->set("user_id", $result->employee_id);
            $req->session->set("user_role", "office_staff_member");
            return $res->redirect(path: "/profile");
        }
        {
            return $res->render(view: "500", layout: "error", pageParams: [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
    }

    public function getStockManagerLoginPage(Request $req, Response $res): string
    {
        return $res->render(view: "stock-manager-login", layout: "plain", layoutParams: [
            'title' => 'Stock manager Login'
        ]);
    }

    //    Regarding stock manager authentication
    public function loginStockManager(Request $req, Response $res): string
    {
        $body = $req->body();

        $stockManager = new StockManager($body);

        $result = $stockManager->login();
        if (is_array($result)) {
            return $res->render(view: "stock-manager-login", layout: "plain", pageParams: [
                "errors" => $result
            ]);
        }

        if ($result) {

            $req->session->set("is_authenticated", true);
            $req->session->set("user_id", $result->employee_id);
            $req->session->set("user_role", "stock_manager");
            return $res->redirect(path: "/products");
        }

        return $res->render(view: "500", layout: "error", pageParams: [
            "error" => "Something went wrong. Please try again later."
        ]);


    }

    public function logoutStockManager(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "stock_manager") {
            $req->session->destroy();
            return $res->redirect(path: "/");
        }

        return $res->redirect(path: "/");
    }


    //    Regarding foreman authentication

    public function getEmployeeLoginPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") !== "customer") {
            //when employees already logged in
            $job_role = $req->session->get("user_role");
            $path = "";
            if ($job_role === "admin") {
                $path = "/admin-dashboard/overview";
            } elseif ($job_role === "foreman") {
                $path = "/jobs";
            } elseif ($job_role === "stock_manager") {
                $path = "/products";
            } elseif ($job_role === "office_staff_member") {
                $path = "/customers";
            } elseif ($job_role === "technician") {
                $path = "/technician-dashboard/profile";
            } elseif ($job_role === "security_officer") {
                $path = "/security-officer-dashboard/check-appointment";
            }
            return $res->redirect(path: $path);
        }
        return $res->render(view: "employee-login", layout: "employee-auth", layoutParams: [
            'title' => 'Login'
        ]);
    }


    public function loginEmployee(Request $req, Response $res): string
    {
        $body = $req->body();
        $employee = new Employee($body);
        $result = $employee->login();
        if (is_array($result)) {
            // When results are equal to array, It means there are errors.
            return $res->render(view: "employee-login", layout: "employee-auth", pageParams: [
                'errors' => $result,
                // Display errors
                'body' => $body
            ], layoutParams: [
                'title' => 'Login'
            ]);
        }

        if ($result) {

            try {
                if ($body['remember'] === '1') {
                    $req->session->setPersistentEmployeeSession(employeeId: $result->employee_id, role: $result->job_role);
                }
                // only reaches here if the employee's login attempt is successful
                $req->session->set(key: "is_authenticated", value: true); // $_SESSION['is_authenticated'] = true;
                $req->session->set(key: "user_id", value: $result->employee_id);
                $req->session->set(key: "user_role", value: $result->job_role); // $_SESSION['user_role'] = "employee";
                $path = "";
                if ($result->job_role === "admin") {
                    $path = "/employees";
                } elseif ($result->job_role === "foreman") {
                    $path = "/jobs";
                } elseif ($result->job_role === "stock_manager") {
                    $path = "/products";
                } elseif ($result->job_role === "office_staff_member") {
                    $path = "/customers";
                } elseif ($result->job_role === "technician") {
                    $path = "/assigned-job";
                } elseif ($result->job_role === "security_officer") {
                    $path = "/security-officer-dashboard/check-appointment";
                }
                return $res->redirect(path: $path);
            } catch (\Exception $e) {
                $errors = ['system' => 'Internal Error, please try again later.If the issue persists, please contact us.'];
                return $res->render(view: "employee-login", layout: "employee-auth", pageParams: [
                    'errors' => $errors,
                    'body' => $body
                ]);
            }

        }

        return $res->render(view: "500", layout: "error", pageParams: [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function logoutEmployee(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") !== "customer") {
            $req->session->destroy();
            $req->session->deletePersistentEmployeeSession($req->session->get("user_id"));
            return $res->redirect(path: "/login");
        }

        return $res->redirect(path: $req->path());
    }

    public function getAdminLoginPage(Request $request, Response $response): string
    {
        return $response->render(view: "admin-login", layout: "plain", layoutParams: [
            "title" => "Admin Login"
        ]);
    }

    public function loginAdmin(Request $request, Response $response): string
    {
        $body = $request->body();
        $employee = new Admin($body);
        $result = $employee->login();
        if (is_array($result)) {
            return $response->render(view: "admin-login", layout: "plain", pageParams: [
                "errors" => $result,
                'body' => $body
            ]);

        }

        if ($result) {
            $request->session->set("is-authenticated", true); //$_SESSION["is-authenticated"] = true
            $request->session->set("user_id", $result->employee_id);
            $request->session->set("user_role", "admin");
            return $response->redirect(path: "/admin-dashboard/profile");
        }

        return $response->render(view: "500", layout: "error", pageParams: [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    // Regarding security officer authentication
    public function getSecurityOfficerLoginPage(Request $request, Response $response): string
    {

        return $response->render(view: "security-officer-login", layout: "plain", layoutParams: [
            "title" => "Security Officer Login"
        ]);
    }

    public function loginSecurityOfficer(Request $request, Response $response): string
    {
        $body = $request->body();
        $employee = new SecurityOfficer($body);
        $result = $employee->login();
        if (is_array($result)) {
            return $response->render(view: "security-officer-login", layout: "plain", pageParams: [
                "errors" => $result,
                'body' => $body
            ]);

        }

        if ($result) {
            $request->session->set("is-authenticated", true); //$_SESSION["is-authenticated"] = true
            $request->session->set("user_id", $result->employee_id);
            $request->session->set("user_role", "security-officer");
            return $response->redirect(path: "/security-officer-dashboard/profile");
        }

        return $response->render(view: "500", layout: "error", pageParams: [
            "error" => "Something went wrong. Please try again later."
        ]);
    }
}