<?php
use app\utils\DevOnly;
/**
 * @var array $employees
 * @var int $limit
 * @var int $page
 * @var int $total
 * @var string $searchTermName
 * @var string $searchTermId
 * @var string $employeeJobRole
 * @var string $employeeStatus
 */

$noOfEmployees = count($employees);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfEmployees - 1;

?>

<div class="flex items-center justify-end mb-4">
    <a class="btn" href="/employees/add">
        <i class="fa-solid fa-plus"></i>
        Add Employee
    </a>
</div> 

showing: <?= $startNo ?> - <?= $endNo ?> of <?= $total ?> employees

<div class="filters" id="dashboard-product-filters">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger" >
            Search & Filter
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <form>
        <div class="filters__dropdown">
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Employee by Name" id="dashboard-product-search" name="name" <?php if($searchTermName) echo "value='$searchTermName'"; ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Employee by Id" id="dashboard-product-search" name="id" <?php if($searchTermId) echo "value='$searchTermId'"; ?> >
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p>Filter employee by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <select name="status" id="dashboard-order-status-filter">
                            <option value="active" <?php if($employeeStatus=='active') echo 'selected';?>>Available</option>
                            <option value="busy" <?php if($employeeStatus=='busy') echo 'selected';?>>Not Available</option>

                        </select>
                    </div>
                    <div class="form-item form-item--no-label">
                        <select name="role" id="dashboard-order-status-filter">
                            <option value="all" <?php if($employeeJobRole=='all') echo 'selected';?>>All</option>
                            <option value="admin" <?php if($employeeJobRole=='admin') echo 'selected';?>>Admin</option>
                            <option value="security_officer" <?php if($employeeJobRole=='security_officer') echo 'selected';?>>Security Officer</option>
                            <option value="technician" <?php if($employeeJobRole=='technician') echo 'selected';?>>Technician</option>
                            <option value="foreman" <?php if($employeeJobRole=='foreman') echo 'selected';?>>Foreman</option>
                            <option value="office_staff_member" <?php if($employeeJobRole=='office_staff_member') echo 'selected';?>>Office Staff Member</option>
                            <option value="stock_manager" <?php if($employeeJobRole=='stock_manager') echo 'selected';?>>Stock Manager</option>
                        </select>
                    </div>
                </div>

            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>
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
                    <p class='employee-card__id'>Employee ID: {$employee['ID']}</p>
                    <p class='employee-card__name'> {$employee['First Name'][0]}. {$employee['Last Name']}</p>
                    <p class='employee-card__role'>$employeeRole</p>
                    <a class='employee-card__contact' href='tel:{$employee['Contact No']}'>{$employee['Contact No']}</a>
                    <a class='employee-card__contact' href='mailto:{$employee['Email']}'>{$employee['Email']}</a>
                </div> 
              </div>";  
    }
    ?>

</div>  
        <?php if($total>0){ ?>
            <div class="pagination-container"> <?php
            foreach(range(1, ceil($total / $limit)) as $i){
                $activePage = $i === (float)$page ? "pagination-item--active" : "";
                echo "<a class='pagination-item $activePage' href='/employees?name=$searchTermName&id=$searchTermId&role=$employeeJobRole&status=$employeeStatus&page=$i&limit=$limit'> $i </a>";                       
            } ?>
            </div>

        <?php }
        else{
            echo "<div id='view-no-data-pagination'>Data are not available</div>";
        }

        ?>