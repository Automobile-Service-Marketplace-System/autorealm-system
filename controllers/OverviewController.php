<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Customer;
use app\models\Appointment;
use app\models\Foreman;
use app\models\JobCard;

class OverviewController
{
    public function getOverviewPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated")) {
            return match ($req->session->get("user_role")) {
                "admin" => $this->getAdminOverviewPage(req: $req, res: $res),
                "stock_manager" => $this->getStockManagerOverviewPage(req: $req, res: $res),
                "foreman" => $this->getForemanOverviewPage(req: $req, res: $res),
                "office_staff_member" => $this->getOfficeStaffOverviewPage(req: $req, res: $res),
                "technician" => $this->getTechnicianOverviewPage(req: $req, res: $res),
                "security_officer" => $this->getSecurityOfficerOverviewPage(req: $req, res: $res),
                default => $res->redirect(path: "/login"),
            };
        }
        return $res->redirect(path: "/login");
    }

    private function getStockManagerOverviewPage(Request $req, Response $res): string
    {
        return $res->render(view: 'stock-manager-dashboard-overview', layout: 'stock-manager-dashboard', layoutParams: [
            'title' => 'Overview',
            'pageMainHeading' => 'Overview',
            'employeeId' => $req->session->get('user_id'),
        ]);
    }


    private function getForemanOverviewPage(Request $req, Response $res): string
    {
    }

    // private function getOfficeStaffOverviewPage(Request $req, Response $res) : string {

    // }

    private function getTechnicianOverviewPage(Request $req, Response $res): string
    {
    }

    private function getSecurityOfficerOverviewPage(Request $req, Response $res): string
    {
    }
  
    private function getAdminOverviewPage(Request $req, Response $res) : string {
        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="admin"){
            return $res->render(view:"admin-dashboard-overview", layout:"admin-dashboard",layoutParams:[
               "title"=>"Overview",
               "pageMainHeading"=>"Overview",
               "employeeId"=>$req->session->get("user_id"),
           ]);           
        }
    }

    private function getCustomerOverviewPage(Request $req, Response $res): string
    {
    }
    //    public function getStockManagerOverviewPage(Request $req, Response $res):string{
    //
    //    public function getOfficeStaffOverviewPage(Request $req, Response $res):string{
    //        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="office_staff_member"){
    //            return $res->render(view:"office-staff-dashboard-overview", layout:"office-staff-dashboard",layoutParams:[
    //                "title"=>"Overview",
    //                "pageMainHeading"=>"Overview",
    //                "officeStaffId"=>$req->session->get("user_id"),
    //            ]);
    //        }
    //        return $res->redirect(path:"/login");
    //    }
    //
    //
    //    public function getCustomerOverviewPage(Request $req, Response $res):string{
    //        if($req->session->get("is_authenticated") && $req->session->get("user_role")==="customer"){
    //            return $res->render(view:"customer-dashboard-overview", layout:"customer-dashboard",layoutParams:[
    //                "title"=>"Overview",
    //                "pageMainHeading"=>"Your account at a glance",
    //                "customerId"=>$req->session->get("user_id"),
    //            ]);
    //        }
    //        return $res->redirect(path:"/login");
    //    }

    public function getOfficeStaffOverviewPage(Request $req, Response $res): string
    {
            //create new object from customer and get customers count
            $customer = new Customer();
            $totalCustomers = $customer->getTotalCustomers();

            //create new object from appointment and get appointments count
            $appointment = new Appointment();
            $totalAppointments = $appointment->getTotalAppointments();

            //create new object from jobcard and get jobs count
            $jobCard = new JobCard();
            $totalOngoingJobs = $jobCard->getTotalOngoingJobs();

            //get weekly job details
            $weeklyJobStatus = $jobCard->getWeeklyJobStatus();

            //create new object from foreman and get foreman details
            $foremen = new Foreman();
            $foremenDetails = $foremen->getAvailableForemen();

            //render page
            return $res->render(view: "office-staff-dashboard-overview", layout: "office-staff-dashboard", 
            pageParams: [
                "customerCount" => $totalCustomers,
                "appointmentCount" => $totalAppointments,
                "ongoingJobsCount" => $totalOngoingJobs,
                "weeklyJobStatus" => $weeklyJobStatus,
                "foremenDetails" => $foremenDetails
            ],
            layoutParams: [
                "title" => "Overview",
                "pageMainHeading" => "Overview",
                "officeStaffId" => $req->session->get("user_id"),
            ]);
    }
}
