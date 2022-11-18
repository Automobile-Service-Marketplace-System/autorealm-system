<?php

namespace app\components;

class EmployeeProfileDropdown
{
    public static function render(object $employee, string $role, int $id): void
    {
        echo "<div class='employee-profile-dropdown__toggle' id='employee-profile-dropdown-$id'>
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