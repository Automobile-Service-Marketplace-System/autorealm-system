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
    public static function render(int $employeeId, string $employeeType, string $role, int $id): void
    {
        $employeeModel = null;
        $employee = null;
        switch ($employeeType) {
            case "foreman":
                $employeeModel = new Foreman();
                $employee = $employeeModel->getForemanById($employeeId);
                break;
            case "security_officer":
                $employeeModel = new SecurityOfficer();
                $employee = $employeeModel->getSecurityOfficerById($employeeId);
                break;
            case "technician":
                $employeeModel = new Technician();
                $employee = $employeeModel->getTechnicianById($employeeId);
                break;
            case "admin":
                $employeeModel = new Admin();
                $employee = $employeeModel->getAdminById($employeeId);
                break;
            case "office_staff":
                $employeeModel = new OfficeStaff();
                $employee = $employeeModel->getOfficeStaffById($employeeId);
                break;
            case "stock_manager":
                $employeeModel = new StockManager();
                $employee = $employeeModel->getStockManagerById($employeeId);
                break;
        }

        echo "<div class='employee-profile-dropdown__toggle no_highlights' id='employee-profile-dropdown-$id'>
                <img src='{$employee->image}' alt=\"{$employee->f_name} {$employee->l_name}'s profile photo\">
                <p>
                    {$employee->f_name[0]}. {$employee->l_name}
                </p>
                <i class='fa-solid fa-chevron-down'></i>
                <nav class='employee-profile-dropdown__box' id='employee-profile-dropdown__box-$id'>
                                <a href='/dashboard/profile'>
                                    <i class='fa-solid fa-user'></i>
                                    My profile
                                </a>
                                <form action='/employee-logout' method='post'>
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