<?php

namespace app\components;

use app\models\Foreman;
use app\models\SecurityOfficer;
use app\models\Technician;
use app\models\Admin;
use app\models\OfficeStaff;
use app\models\StockManager;


class EmployeeProfileDropdown
{
    public static function render(int $employeeId, string $employeeType, int $id): void
    {
        $employee = null;
        $profileLink = null;
        switch ($employeeType) {
            case "foreman":
                $employeeModel = new Foreman();
                $employee = $employeeModel->getForemanById($employeeId);
                $profileLink = "/foreman-dashboard/profile";
                break;
            case "security_officer":
                $employeeModel = new SecurityOfficer();
                $employee = $employeeModel->getSecurityOfficerById($employeeId);
                $profileLink = "/security-officer-dashboard/profile";
                break;
            case "technician":
                $employeeModel = new Technician();
                $employee = $employeeModel->getTechnicianById($employeeId);
                $profileLink = "/technician-dashboard/profile";
                break;
            case "admin":
                $employeeModel = new Admin();
                $employee = $employeeModel->getAdminById($employeeId);
                $profileLink = "/admin-dashboard/profile";
                break;
            case "office_staff":
                $employeeModel = new OfficeStaff();
                $employee = $employeeModel->getOfficeStaffById($employeeId);
                $profileLink = "/office-staff-dashboard/profile";
                break;
            case "stock_manager":
                $employeeModel = new StockManager();
                $employee = $employeeModel->getStockManagerById($employeeId);
                $profileLink = "/profile";
                break;
        }

        echo "<div class='employee-profile-dropdown__toggle no_highlights' id='employee-profile-dropdown-$id'>
                <img src='$employee->image' alt=\"$employee->f_name $employee->l_name's profile photo\">
                <p>
                    {$employee->f_name[0]}. $employee->l_name
                </p>
                <i class='fa-solid fa-chevron-down'></i>
                <nav class='employee-profile-dropdown__box' id='employee-profile-dropdown__box-$id'>
                                <a href='$profileLink'>
                                    <i class='fa-solid fa-user'></i>
                                    My profile
                                </a>
                                <form action='/logout' method='post'>
                                    <button>
                                        <i class='fa-solid fa-sign-out'></i>
                                        Logout
                                    </button>
                                </form>                             
                    </nav> 
             </div>
             ";

    }

}