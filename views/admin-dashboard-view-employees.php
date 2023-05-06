<?php
/**
 * @var array $employees
 * @var int $limit
 * @var int $page
 * @var int $total
 */

?>

<div class="flex items-center justify-end mb-4">
    <a class="btn" href="/employees/add">
        <i class="fa-solid fa-plus"></i>
        Add Employee
    </a>
</div> 

<div class="employee-container">
    <?php
    foreach ($employees as $employee) {

        $isActive = $employee["isActive"] === 1 ? "<p class='employee-card__status'><i class='indicator indicator--success'></i> Available</p>" : "<p class='employee-card__status'><i class='indicator'> </i> Busy</p>";
        $employeeRole = "";
        switch ($employee['JobType']) {
            case "stock_manager":
                $employeeRole = "Stock Manager";
                break;
            case "office_staff_member":
                $employeeRole = "Office Staff";
                break;
            case "technician":
                $employeeRole = "Technician";
                break;
            case "foreman":
                $employeeRole = "Foreman";
                break;
            case "security_officer":
                $employeeRole = "Security Officer";
                break;
            case "admin":
                $employeeRole = "Admin";
                break;
        }

        echo "<div class='employee-card' data-employeeid='{$employee['ID']}' data-employeejobtype='{$employee['JobType']}'>
                <div class='employee-card__header'>
                       $isActive
                       <i class='fa-solid fa-ellipsis'></i>
                </div>
                <div class='employee-card__info'>
                    <img src='{$employee['Image']}'>
                    <p class='employee-card__name'> {$employee['First Name'][0]}. {$employee['Last Name']}</p>
                    <p class='employee-card__role'>$employeeRole</p>
                    <a class='employee-card__contact' href='tel:{$employee['Contact No']}'>{$employee['Contact No']}</a>
                    <a class='employee-card__contact' href='mailto:{$employee['Email']}'>{$employee['Email']}</a>
                </div> 
              </div>";  
    }
    ?>

    <div class="pagination-container view-employee">
        <?php 
            foreach(range(1, ceil($total / $limit)) as $i){
                $activePage = $i === (float)$page ? "pagination-item--active" : "";
                echo "<a class='pagination-item $activePage' href='/employees?page=$i&limit=$limit'> $i </a>";
            }
        ?>
    </div>
</div>