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

class AuthenticationController
{
    //    Regarding customer authentication
    public function getCustomerSignupForm(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            return $res->redirect("/dashboard/profile");
        }
        return $res->render("customer-signup", layoutParams: [
            "title" => "Register",
        ]);
    }

    public function registerCustomer(Request $req, Response $res): string
    {
        $body = $req->body();
        $customer = new Customer($body);
        $result = $customer->register();

        if (is_array($result)) {
            return $res->render(view: "customer-signup", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        }

        if ($result) {
            return $res->redirect("/login?success=1");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function getCustomerLoginForm(Request $req, Response $res): string
    {
        return $res->render(view: "customer-login", layout: "main", layoutParams: [
            'title' => 'Login'
        ]);
    }

    public function loginCustomer(Request $req, Response $res): string
    {
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
            // only reaches here if the customer's login attempt is successful
            $req->session->set("is_authenticated", true); // $_SESSION['is_authenticated'] = true;
            $req->session->set("user_id", $result->customer_id);
            $req->session->set("user_role", "customer"); // $_SESSION['user_role'] = "customer";
            return $res->redirect(path: "/dashboard/profile"); // header("Location: /dashboard/profile");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function logoutCustomer(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $req->session->destroy();
            return $res->redirect(path: "/");
        }

        return $res->redirect("/");
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
            return $res->redirect(path: "/office-staff-dashboard/profile");
        } {
            return $res->render("500", "error", [
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
            return $res->redirect(path: "/stock-manager-dashboard/profile");
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);


    }


    //    Regarding foreman authentication

    public function getEmployeeLoginPage(Request $req, Response $res): string
    {
        return $res->render(view: "employee-login", layout: "employee-auth", layoutParams: [
            'title' => 'Login'
        ]);
    }


    public function loginEmployee(Request $req, Response $res): string
    {
        $body = $req->body();
        $employee = new Employee($body);
        $result = $employee->login();
        var_dump($result);
        if (is_array($result)) {
            return $res->render(view: "employee-login", pageParams: [
                'errors' => $result,
                'body' => $body
            ]);
        }

        if ($result) {
            // only reaches here if the employee's login attempt is successful
            $req->session->set("is_authenticated", true); // $_SESSION['is_authenticated'] = true;
            $req->session->set("user_id", $result->employee_id);
            $req->session->set("user_role", $result->job_role); // $_SESSION['user_role'] = "employee";
            $path = "";
            if ($result->job_role === "admin") {
                $path = "/admin-dashboard/profile";
            } elseif ($result->job_role === "foreman") {
                $path = "/foreman-dashboard/profile";
            } elseif ($result->job_role === "stock_manager") {
                $path = "/stock-manager-dashboard/profile";
            } elseif ($result->job_role === "office_staff_member") {
                $path = "/office-staff-dashboard/profile";
            } elseif ($result->job_role === "technician") {
                $path = "/technician-dashboard/profile";
            }
            return $res->redirect(path: $path);
        }

        return $res->render("500", "error", [
            "error" => "Something went wrong. Please try again later."
        ]);
    }

    public function logoutEmployee(Request $req, Response $res): string
    {
            $req->session->destroy();
            return $res->redirect(path: "/employee-login");
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
        } else {
            return $response->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
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
        } else {
            return $response->render("500", "error", [
                "error" => "Something went wrong. Please try again later."
            ]);
        }
    }
}