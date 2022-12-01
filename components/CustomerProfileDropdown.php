<?php

namespace app\components;

class CustomerProfileDropdown
{
    public static function render(object $customer, int $id): void
    {
        echo "<li class='customer-profile-dropdown__toggle' id='customer-profile-dropdown-$id'>
                <img src='{$customer->image}' alt=\"{$customer->f_name} {$customer->l_name}'s profile photo\">
                <p>
                    {$customer->f_name[0]}. {$customer->l_name}
                </p>
                <i class='fa-solid fa-chevron-down'></i>
                <nav class='customer-profile-dropdown__box' id='customer-profile-dropdown__box-$id'>
                                <a href='/dashboard/profile'>
                                    <i class='fa-solid fa-user'></i>
                                    My profile
                                </a>
                                <a href='/dashboard/overview'>
                                    <i class='fa-solid fa-chart-simple'></i>
                                    Dashboard
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