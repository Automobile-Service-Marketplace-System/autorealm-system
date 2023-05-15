<?php

namespace app\components;

use app\models\Customer;

class CustomerProfileDropdown
{
    public static function render(int $customerId, int $id): void
    {
        $customerModel = new Customer();
        $customer = $customerModel->getCustomerById($customerId);
        echo "<li class='customer-profile-dropdown__toggle no_highlights' id='customer-profile-dropdown-$id'>
                <img src='$customer->image' alt=\"$customer->f_name $customer->l_name's profile photo\">
                <p>
                    {$customer->f_name[0]}. $customer->l_name
                </p>
                <i class='fa-solid fa-chevron-down'></i>
                <nav class='customer-profile-dropdown__box' id='customer-profile-dropdown__box-$id'>
                                <a href='/dashboard/profile'>
                                    <i class='fa-solid fa-user'></i>
                                    My profile
                                </a>
                                <a href='/dashboard/appointments'>
                                    <i class='fa-solid fa-chart-simple'></i>
                                    Apppointments
                                </a>
                                <form action='/logout' method='post'>
                                    <button>
                                        <i class='fa-solid fa-sign-out'></i>
                                        Logout
                                    </button>
                                </form>                             
                    </nav> 
             </li>
             ";

    }

}